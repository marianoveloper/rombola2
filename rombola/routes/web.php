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
*/

Route::get('/',function () {return redirect ('login');});

//Route::get('/', 'ClienteController@inicio');

Route::get('login',['as' => 'login',function () { return view('adminlte::auth.login');}]);

Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
    
});
Route::get('pre-venta/respuesta','PreventaController@respuesta');
Route::resource('clientes','ClienteController');
Route::resource('pre-venta','PreventaController');

//Route::get('autos.index','AutomovileController@autos')->name('autos');
//Route::get('autos.create','AutomovileController@create')->name('create');
//Route::get('autos/{auto}/edit','AutomovileController@edit')->name('edit');
Route::get('autos/{auto}/editusado','AutomovileController@editusado')->name('editusado');
Route::get('autos/usados','AutomovileController@usados')->name('usados');
Route::get('autos/createusados','AutomovileController@createusados')->name('agregarusado');



Route::resource('autos', 'AutomovileController');



?>