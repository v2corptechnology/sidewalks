<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marker;
use App\Shop;

class MarkersController extends Controller
{

	/**
	 * Description
	 * @param int $shop 
	 * @return type
	 */
    public function create(Shop $shop)
    {
    	return view('markers.create', compact('shop'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Shop $shop, Request $request)
    {
        $request->merge(['shop_id' => $shop->id]);

        Marker::create($request->all());

        return ['status' => 'ok'];
    }
}