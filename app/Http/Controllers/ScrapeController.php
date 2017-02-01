<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Swader\Diffbot\Diffbot;

class ScrapeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rawUrl = $request->input('url');
        $url = urldecode($rawUrl);

        return \Cache::remember($rawUrl, 60, function () use ($url) {
            $diffbot = new Diffbot('3a4112bdb34bca3217613b46b2284893');
            $productApi = $diffbot->createProductAPI($url);
            $rawResult = $productApi->call()->getResponse()->getBody();

            $item = json_decode($rawResult)->objects[0];

            return [
                'amount' => $item->offerPriceDetails->amount,
                'symbol' => $item->offerPriceDetails->symbol,
                'title' => $item->title,
                'description' => $item->text,
                'quantity' => 1,
                'images' => array_column($item->images, 'url'),
            ];
        });
    }

}
