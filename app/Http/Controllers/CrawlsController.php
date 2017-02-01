<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CrawlsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $baseUrl = 'http://www.come-sit-stay-shop.com/';
        $crawler = \Goutte::request('GET', $baseUrl);
        $url = $crawler->filter('a')->each(function ($node) use ($baseUrl) {
            return $this->make_absolute($node->attr('href'), $baseUrl);
        });

        dd(collect($url)->unique()->values()->toArray());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('crawls.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function make_absolute($url, $base)
{
    // Return base if no url
    if( ! $url) return $base;

    // Return if already absolute URL
    if(parse_url($url, PHP_URL_SCHEME) != '') return $url;
   
    // Urls only containing query or anchor
    if($url[0] == '#' || $url[0] == '?') return $base.$url;
   
    // Parse base URL and convert to local variables: $scheme, $host, $path
    extract(parse_url($base));

    // If no path, use /
    if( ! isset($path)) $path = '/';
 
    // Remove non-directory element from path
    $path = preg_replace('#/[^/]*$#', '', $path);
 
    // Destroy path if relative url points to root
    if($url[0] == '/') $path = '';
   
    // Dirty absolute URL
    $abs = "$host$path/$url";
 
    // Replace '//' or '/./' or '/foo/../' with '/'
    $re = array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
    for($n = 1; $n > 0; $abs = preg_replace($re, '/', $abs, -1, $n)) {}
   
    // Absolute URL is ready!
    return $scheme.'://'.$abs;
}
}
