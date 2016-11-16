<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function($api) {
    $api->get('hello', function() {
        return "Hello";
    });
    $api->get('world', 'App\Http\Controllers\ExampleController@index');

    $api->post('authenticate', 'App\Http\Controllers\ExampleController@authenticate');
});

$api->version('v1', ['middleware' => 'api.auth'], function($api){
    $api->get('users', 'App\Http\Controllers\ExampleController@index');
    $api->get('user', 'App\Http\Controllers\ExampleController@show');
    $api->get('token', 'App\Http\Controllers\ExampleController@getToken');
    $api->delete('delete', 'App\Http\Controllers\ExampleController@destroy');
});
