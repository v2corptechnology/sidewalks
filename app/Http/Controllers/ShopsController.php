<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use App\Shop;
use App\Schedule;
use App\Http\Requests\StoreShop;
use libphonenumber\PhoneNumberFormat;

class ShopsController extends Controller
{
    use DatabaseTransactions;

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

        return redirect()->route('shops.edit', $shop);
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

        dd('Shop was updated but schedules need to be done');


        $schedules = json_decode($request->input('schedules'));

        foreach ($schedules as $schedule) {

            foreach ($schedule->days as $day) {
                $dayOfWeek = \Carbon\Carbon::createFromFormat('D', $day)->dayOfWeek;    
                $start = \Carbon\Carbon::createFromFormat('D H:i', $day . ' ' .$schedule->start);
                $end = \Carbon\Carbon::createFromFormat('D H:i', $day . ' ' .$schedule->end);

                // In case the schedule ends after midnight
                if ($start->timestamp > $end->timestamp) {
                    $end->addDay();
                }

                Schedule::create([
                    'shop_id' =>        $shop->id,
                    'day_of_week' =>    $dayOfWeek,
                    'time_open' =>      $start->format('H:i'),
                    'working_time' =>   $end->diffInMinutes($start),
                ]);
            }
        }
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
}
