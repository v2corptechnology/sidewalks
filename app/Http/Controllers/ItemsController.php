<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Http\Requests\StoreItem;

class ItemsController extends Controller
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
        $categories = auth()->user()->shop->categories;

        return view('items.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request\StoreItem $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItem $request)
    {
        // Store item
        $item = Item::create($request->except('images'));

        // Attach the categories to him
        $item->categories()->attach($request->get('categories'));

        // Save image
        $images = $this->saveImages($item, $request->get('images'));

        // Redirect accordingly
        if ($request->get('next', 'save') == 'save') {
            return redirect()->route('shops.markers.create', $request->user()->shop);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    protected function saveImages(Item $item, array $images = [])
    {
        $path = "items/originals/{$item->id}/";
        $imageNames = [];

        foreach ($images as $image) {
            $name = str_random() . '.jpg';
            $image = \Image::make($image)
                    ->orientate()
                    ->resize(1800, 1800, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('jpg', 100)
                    ->__toString();

            \Storage::put($path . $name, $image);

            $imageNames[] = $name;
        }

        $item->images = $imageNames;
        $item->save();
    }
}
