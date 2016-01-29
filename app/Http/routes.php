<?php


Route::get('/', function () {

	return view('home');
});


Route::group(['middleware' => ['web']], function () {
    //
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');
    Route::get('cliente', 'ClientesCloudController@index');
    Route::post('/cliente/gravar','ClientesCloudController@store');
    Route::get('/cliente/registrar','ClientesCloudController@create');
    Route::get('/cliente/{id}/preview','ClientesCloudController@show');
    Route::post('cliente/{id}/update','ClientesCloudController@update');
    Route::get('cliente/{id}/edit','ClientesCloudController@edit');
    Route::get('cliente/{id}/remover','ClientesCloudController@remove_image');
    //Route::get('cliente/{id}/delete','ClientesCloudController@destroy');
    //Route::get('cliente/{id}/deleteMsg','ClientesCloudController@DeleteMsg');


});