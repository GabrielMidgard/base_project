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
Auth::routes();

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    
    Route::post('logout', 'Auth\JwtController@logout');
    Route::post('register', 'Auth\JwtController@register');
    Route::post('refresh', 'Auth\JwtController@refresh');
    Route::post('me', 'Auth\JwtController@me');
});
Route::post('login', 'Auth\JwtController@login');

Route::post('/menu/','MenuController@index');
Route::get('/menus/','MenuController@getAllElements');
Route::get('/menus/getOptions','MenuController@getOptions');
Route::post('/menus/getElement/','MenuController@show');
Route::post('/menus/add/','MenuController@store');//->middleware('auth.role:administrador');
Route::post('/menus/update/','MenuController@update');//->middleware('auth.role:administrador');
Route::post('/menus/updateActive/','MenuController@updateActive');//->middleware('auth.role:administrador');
Route::post('/menus/delete/','MenuController@destroy');
Route::delete('/menus/multiDelete/',"MenuController@destroyMultiple");	

Route::get('/user/','UserController@index'); 
Route::get('/user/all/','UserController@getAllElements');
Route::post('/user/getElement/','UserController@show');
Route::get('/user/getOptions','RolController@getOptions');
Route::post('/user/add/','UserController@store');//->middleware('auth.role:administrador');
Route::post('/user/update/','UserController@update');//->middleware('auth.role:administrador');
Route::post('/user/updateActive/','UserController@updateActive');//->middleware('auth.role:administrador');
Route::post('/user/delete/','UserController@destroy');
Route::delete('/user/multiDelete/',"UserController@destroyMultiple");	


//Front
Route::post('/image/add/', 'ImageController@store');


Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    
    return "Cache is cleared";
});

