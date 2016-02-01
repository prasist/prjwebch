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

    /*Clientes Cloud*/
    Route::get('clientes', 'ClientesCloudController@index');
    Route::post('/clientes/gravar','ClientesCloudController@store');
    Route::get('/clientes/registrar','ClientesCloudController@create');
    Route::get('/clientes/{id}/preview','ClientesCloudController@show');
    Route::post('clientes/{id}/update','ClientesCloudController@update');
    Route::get('clientes/{id}/edit','ClientesCloudController@edit');
    Route::get('clientes/{id}/remover','ClientesCloudController@remove_image');

    /*Empresas do cliente*/
    Route::get('empresas', 'EmpresasController@index');
    Route::post('/empresas/gravar','EmpresasController@store');
    Route::get('/empresas/registrar','EmpresasController@create');
    Route::get('/empresas/{id}/preview','EmpresasController@show');
    Route::post('empresas/{id}/update','EmpresasController@update');
    Route::get('empresas/{id}/edit','EmpresasController@edit');
    Route::get('empresas/{id}/remover','EmpresasController@remove_image');
    Route::get('empresas/{id}/delete','EmpresasController@destroy');
    Route::get('empresas/{id}/deleteMsg','EmpresasController@DeleteMsg');

     /*Grupos de Usuários*/
    Route::get('grupos', 'GruposController@index');
    Route::post('/grupos/gravar','GruposController@store');
    Route::get('/grupos/registrar','GruposController@create');
    //Route::get('/empresas/{id}/preview','EmpresasController@show');
    Route::post('grupos/{id}/update','GruposController@update');
    Route::get('grupos/{id}/edit','GruposController@edit');
    Route::get('grupos/{id}/delete','GruposController@destroy');
    Route::get('grupos/{id}/deleteMsg','GruposController@DeleteMsg');

  /*Permissoes do Grupo*/
    Route::get('permissoes', 'GruposController@index');
    Route::post('/permissoes/gravar','GruposController@store');
    Route::get('/permissoes/registrar','GruposController@create');
    //Route::get('/empresas/{id}/preview','EmpresasController@show');
    Route::post('permissoes/{id}/update','GruposController@update');
    Route::get('permissoes/{id}/edit','GruposController@edit');
    Route::get('permissoes/{id}/delete','GruposController@destroy');
    Route::get('permissoes/{id}/deleteMsg','GruposController@DeleteMsg');

});
