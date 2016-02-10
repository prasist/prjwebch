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

    Route::get('errors.404', function() {

        return view('errors.404');

    });

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
    Route::get('/grupos/{id}/preview','GruposController@show');
    Route::post('grupos/{id}/update','GruposController@update');
    Route::get('grupos/{id}/edit','GruposController@edit');
    Route::get('grupos/{id}/delete','GruposController@destroy');


  /*Permissoes do Grupo*/
    Route::get('permissoes', 'PermissoesGrupoController@index');
    Route::post('/permissoes/gravar','PermissoesGrupoController@store');
    Route::get('/permissoes/registrar','PermissoesGrupoController@create');
    Route::get('/permissoes/{id}/preview','PermissoesGrupoController@show');
    Route::post('permissoes/update','PermissoesGrupoController@update');
    Route::get('permissoes/{id}/edit','PermissoesGrupoController@edit');
    Route::get('permissoes/{id}/delete','PermissoesGrupoController@destroy');
    Route::get('permissoes/{id}/deleteMsg','PermissoesGrupoController@DeleteMsg');

 /*Usuários*/
    Route::get('usuarios', 'UsersController@index');
    Route::post('/usuarios/gravar','UsersController@store');
    Route::get('/usuarios/registrar','UsersController@create');
    Route::get('/usuarios/{id}/preview','UsersController@show');
    Route::post('usuarios/{id}/update','UsersController@update');
    Route::get('usuarios/{id}/edit','UsersController@edit');
    Route::get('usuarios/{id}/delete','UsersController@destroy');
    Route::get('usuarios/{id}/remover','UsersController@remove_image');
    Route::get('usuarios/{id}/perfil','UsersController@perfil');


});
