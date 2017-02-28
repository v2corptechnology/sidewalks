<?php
Route::get('/views/{id}', function($id) {
    return \App\Panorama::find($id)->load('markers')->toArray();
});

Route::get('users/{id}/paths/', function($id) {
    return \App\User::find($id)->paths()->with('panoramas')->get();
});


Route::post('paths/', function() {
    $path = \App\Path::create(request()->all())
                ->load('panoramas');

    return ['data' => $path];
});

Route::resource('panoramasApi', 'API\PanoramasApiController');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register the API routes for your application as
| the routes are automatically authenticated using the API guard and
| loaded automatically by this application's RouteServiceProvider.
|
*/

Route::group([
    'middleware' => 'auth:api'
], function () {
});


