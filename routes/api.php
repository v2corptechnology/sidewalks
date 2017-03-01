<?php
Route::get('/views/{id}', function($id) {
    return \App\Panorama::find($id)->load('markers.markable')->toArray();
});

Route::get('users/{id}/paths/', function($id) {
    return \App\User::find($id)->paths()->with('panoramas')->get();
});


Route::post('paths/', function() {
    $path = \App\Path::create(request()->all());

    $imagePath = request()->file('panorama')->store('panoramas');
    request()->merge([
    	'path_id' => $path->id,
        'image' => basename($imagePath),
        'exif' => exif_read_data(asset('storage/' . $imagePath)),
    ]);

    $panorama = \App\Panorama::Create(request()->all());

    return ['data' => $path->load('panoramas')->load('panoramas')];
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


