<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

Route::get('foo', function () {
    return 'Hello World';
});
*/
//Route::post('/products/store-multiple-image','ProductImagesController@store');
//Route::get('/curso/detalles/{any}', 'HomeController@index')->where('any', '.*'); /
Route::get('/admin/', 'ValhallaController');
Route::get('/admin/{any}', 'ValhallaController')->where('any', '.*');
//Route::get('/', 'HomeController@index')->name('home');
Route::get('/img/{key}','MediaController@getImage');
Route::get('/docs/{key}','MediaController@getDocument');



//Route::get('/departamentos/','DepartmentController@index');//->middleware('auth.role:administrador');


//Auth::routes();




