<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePanoramaRequest;

class PanoramasApiController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePanoramaRequest $request)
    {
        $path = $request->file('panorama')->store('panoramas');

        $request->merge([
            'image' => basename($path),
            'exif' => exif_read_data(asset('storage/' . $path)),
        ]);

        $panorama = \App\Panorama::Create($request->all());

        $request->merge([
            'markable_id' => $panorama->id,
            'markable_type' => \App\Panorama::class,
        ]);

        $marker = \App\Marker::create($request->all());

        $lng = (float) $request->input('longitude');
        $reverseLongitude = $lng < pi() ? $lng + pi() : fmod($lng + pi(), pi());
        $request->merge([
            'longitude' => $reverseLongitude,
            'latitude_px' => 0,
            'longitude_px' => 0,
        ]);
        $reverseMarker = \App\Marker::create($request->all());
    
        return $panorama->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
