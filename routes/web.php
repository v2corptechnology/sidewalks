<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@show');

Route::group(['middleware' => 'auth'], function () {
    Route::get('home', 'HomeController@show')->name('home');
    Route::get('autocomplete', 'AcController@create');
    Route::post('scrape', 'ScrapeController@index');

	Route::group(['middleware' => 'hasShop'], function () {
		Route::resource('categories', 'CategoriesController');
	});

    Route::resource('items', 'ItemsController');
    Route::resource('shops', 'ShopsController');
    Route::resource('schedules', 'SchedulesController');
    Route::resource('shops.markers', 'MarkersController');
    Route::resource('paths', 'PathsController');

    Route::resource('crawls', 'CrawlsController');

    Route::get('demo', 'PathsController@show');
});

Route::group(['prefix' => 'api', 'middleware' => 'auth'], function () {
    Route::get('/paths/', function() {
        //return factory(\App\Path::class, 3)->create();
        return auth()->user()->paths()->with('views')->get();
    });

    Route::post('/paths/', function() {
        $path = request()->user()->paths()->create([
            'name' => request()->input('name')
        ])->load('views');

        return ['data' => $path];
    });
});
