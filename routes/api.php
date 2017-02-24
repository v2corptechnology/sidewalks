<?php
Route::get('/views/{id}', function($id) {
    $data = [
        [
            'path' => asset('img/01.jpg'), 
            'markers' => [
                [
                    'id' => 1,
                    'latitude' => 0,
                    'longitude' => pi(),
                    'anchor' => "center center",
                    'html' => '<i style="color: #FFF" class="fa fa-arrow-circle-up fa-5x"></i>',
                    'tooltip' => "Walk there",
                    'view_id' => 2,
                ]
            ]
        ], 
        [
            'path' => asset('img/02.jpg'), 
            'markers' => [
                [
                    'id' => 1,
                    'latitude' => 0,
                    'longitude' => pi(),
                    'anchor' => "center center",
                    'html' => '<i style="color: #FFF" class="fa fa-arrow-circle-up fa-5x"></i>',
                    'tooltip' => "Walk there",
                    'view_id' => 3,
                ],
                [
                    'id' => 2,
                    'latitude' => 0,
                    'longitude' => 0.40613944590901535,
                    'anchor' => "center center",
                    'html' => '<i style="color: #FFF" class="fa fa-arrow-circle-up fa-5x"></i>',
                    'tooltip' => "Walk there",
                    'view_id' => 1,
                ]
            ]
        ], 
        [
            'path' => asset('img/03.jpg'), 
            'markers' => [
                [
                    'id' => 1,
                    'latitude' => 0,
                    'longitude' => pi(),
                    'anchor' => "center center",
                    'html' => '<i style="color: #FFF" class="fa fa-arrow-circle-up fa-5x"></i>',
                    'tooltip' => "Walk there",
                    'view_id' => 4,
                ],
                [
                    'id' => 2,
                    'latitude' => 0,
                    'longitude' => 0.7496433213062232,
                    'anchor' => "center center",
                    'html' => '<i style="color: #FFF" class="fa fa-arrow-circle-up fa-5x"></i>',
                    'tooltip' => "Walk there",
                    'view_id' => 2,
                ]
            ]
        ], 
        [
            'path' => asset('img/04.jpg'), 
            'markers' => [
                [
                    'id' => 1,
                    'latitude' => 0,
                    'longitude' => 1.4688032772132902,
                    'anchor' => "center center",
                    'html' => '<i style="color: #FFF" class="fa fa-arrow-circle-up fa-5x"></i>',
                    'tooltip' => "Walk there",
                    'view_id' => 3,
                ]
            ]
        ], 
    ];

    return $data[$id -1];
});

Route::get('users/{id}/paths/', function($id) {
    //return factory(\App\Path::class, 3)->create();
    return \App\User::find($id)->paths()->with('views')->get();
});


Route::post('users/{id}/paths/', function($id) {
    $path = \App\User::find($id)->paths()
        ->create(request()->all())
        ->load('views');

    return ['data' => $path];
});
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


