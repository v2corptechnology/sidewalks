<?php

namespace App\Http\Controllers;

class DemoController extends Controller
{
	public function show()
	{
		$shop = \App\Shop::first();

	    return view('demo.show', compact('shop'));
	}
}