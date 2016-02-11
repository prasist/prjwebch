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

   /*Igrejas*/
    Route::get('igrejas', 'IgrejasController@index');
    Route::post('/igrejas/gravar','IgrejasController@store');
    Route::get('/igrejas/registrar','IgrejasController@create');
    Route::get('/igrejas/{id}/preview','IgrejasController@show');
    Route::post('igrejas/{id}/update','IgrejasController@update');
    Route::get('igrejas/{id}/edit','IgrejasController@edit');
    Route::get('igrejas/{id}/delete','IgrejasController@destroy');

    /*Status*/
    Route::get('status', 'StatusController@index');
    Route::post('/status/gravar','StatusController@store');
    Route::get('/status/registrar','StatusController@create');
    Route::get('/status/{id}/preview','StatusController@show');
    Route::post('status/{id}/update','StatusController@update');
    Route::get('status/{id}/edit','StatusController@edit');
    Route::get('status/{id}/delete','StatusController@destroy');

    /*Idiomas*/
    Route::get('idiomas', 'IdiomasController@index');
    Route::post('/idiomas/gravar','IdiomasController@store');
    Route::get('/idiomas/registrar','IdiomasController@create');
    Route::get('/idiomas/{id}/preview','IdiomasController@show');
    Route::post('idiomas/{id}/update','IdiomasController@update');
    Route::get('idiomas/{id}/edit','IdiomasController@edit');
    Route::get('idiomas/{id}/delete','IdiomasController@destroy');

     /*Graus de Instrução*/
    Route::get('graus', 'GrausController@index');
    Route::post('/graus/gravar','GrausController@store');
    Route::get('/graus/registrar','GrausController@create');
    Route::get('/graus/{id}/preview','GrausController@show');
    Route::post('graus/{id}/update','GrausController@update');
    Route::get('graus/{id}/edit','GrausController@edit');
    Route::get('graus/{id}/delete','GrausController@destroy');

    /*Profissoes */
    Route::get('profissoes', 'ProfissoesController@index');
    Route::post('/profissoes/gravar','ProfissoesController@store');
    Route::get('/profissoes/registrar','ProfissoesController@create');
    Route::get('/profissoes/{id}/preview','ProfissoesController@show');
    Route::post('profissoes/{id}/update','ProfissoesController@update');
    Route::get('profissoes/{id}/edit','ProfissoesController@edit');
    Route::get('profissoes/{id}/delete','ProfissoesController@destroy');

});