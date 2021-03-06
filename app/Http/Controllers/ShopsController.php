<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Shop;
use App\Schedule;
use App\Http\Requests\StoreShop;
use libphonenumber\PhoneNumberFormat;

class ShopsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shops.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShop $request)
    {
        // Format phone number
        $request->merge(['phone' => phone($request->input('phone'), null, PhoneNumberFormat::E164)]);

        $shop = auth()->user()->shop()->create($request->all());

        return redirect()->route('shops.edit', [$shop, 'narrow']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Shop $shop)
    {
        $sunday = $shop->schedules->shift();
        $shop->schedules->push($sunday);

        return view('shops.show', compact('shop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        return view('shops.edit', compact('shop'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('panoramas');
            $request->merge(['panorama' => basename($path)]);
        }
        $shop->update($request->all());
        $this->saveSchedules($request->input('schedules', '[]'), $shop);

        if (! $shop->items->count()) {
            return redirect()->route('items.create');
        }

        return redirect()->route('shops.show', $shop);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function saveSchedules(string $json, Shop $shop)
    {
        $shop->schedules()->delete();
        foreach (json_decode($json) as $schedule) {
            foreach ($schedule->days as $day) {
                $dayOfWeek = Carbon::createFromFormat('D', $day)->dayOfWeek;    
                $start = Carbon::createFromFormat('D H:i', $day . ' ' .$schedule->start);
                $end = Carbon::createFromFormat('D H:i', $day . ' ' .$schedule->end);

                // In case the schedule ends after midnight
                if ($start->timestamp > $end->timestamp) {
                    $end->addDay();
                }

                Schedule::updateOrCreate([
                    'shop_id'       => $shop->id,
                    'day_of_week'   => $dayOfWeek,
                    'time_open'     => $start->format('H:i'),
                    'working_time'  => $end->diffInMinutes($start),
                ]);
            }
        }
    }
}
