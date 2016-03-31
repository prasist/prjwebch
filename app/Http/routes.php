<?php

    Route::get('/', function ()
    {
        return view('home');
    });

    Route::group(['middleware' => ['web']], function ()
    {
        //
    });

    Route::group(['middleware' => 'web'], function ()
    {

        Route::auth();

        Route::get('/home', 'HomeController@index');

        Route::get('errors.404', function() {

            return view('errors.404');

    });


    /*Validacao do CPF / CNPJ - disparado pelo jquery*/
    Route::get('funcoes/{id}', 'FuncoesController@validar');


    Route::get('pdf', function ()
    {

        //Exemplo 1
        //$pdf = App::make('dompdf.wrapper');
        //$pdf->loadHTML('<h1>Test</h1>');
        //return $pdf->stream();

        //Exemplo 2
        //$pdf = PDF::loadView('pessoas.index');
        //return $pdf->download('invoice.pdf');

    });

    Route::post('filhos', 'FilhosController@destroy');

    Route::get('tutoriais/{id}', 'TutoriaisController@tutorial');

    Route::get('quicktour/{id}', 'TutoriaisController@index');
    Route::post('quicktour/done/{id}', 'TutoriaisController@concluir');
    Route::get('quicktour/reload/{id}', 'TutoriaisController@iniciar');

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

    /*Perfil*/
    Route::get('perfil/{id}/perfil','PerfilController@perfil');

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

    /*Àreas de Formação */
    Route::get('areas', 'AreasController@index');
    Route::post('/areas/gravar','AreasController@store');
    Route::get('/areas/registrar','AreasController@create');
    Route::get('/areas/{id}/preview','AreasController@show');
    Route::post('areas/{id}/update','AreasController@update');
    Route::get('areas/{id}/edit','AreasController@edit');
    Route::get('areas/{id}/delete','AreasController@destroy');

    /*Ministério */
    Route::get('ministerios', 'MinisteriosController@index');
    Route::post('/ministerios/gravar','MinisteriosController@store');
    Route::get('/ministerios/registrar','MinisteriosController@create');
    Route::get('/ministerios/{id}/preview','MinisteriosController@show');
    Route::post('ministerios/{id}/update','MinisteriosController@update');
    Route::get('ministerios/{id}/edit','MinisteriosController@edit');
    Route::get('ministerios/{id}/delete','MinisteriosController@destroy');

     /*Atividades  */
    Route::get('atividades', 'AtividadesController@index');
    Route::post('/atividades/gravar','AtividadesController@store');
    Route::get('/atividades/registrar','AtividadesController@create');
    Route::get('/atividades/{id}/preview','AtividadesController@show');
    Route::post('atividades/{id}/update','AtividadesController@update');
    Route::get('atividades/{id}/edit','AtividadesController@edit');
    Route::get('atividades/{id}/delete','AtividadesController@destroy');

    /*Dons */
    Route::get('dons', 'DonsController@index');
    Route::post('/dons/gravar','DonsController@store');
    Route::get('/dons/registrar','DonsController@create');
    Route::get('/dons/{id}/preview','DonsController@show');
    Route::post('dons/{id}/update','DonsController@update');
    Route::get('dons/{id}/edit','DonsController@edit');
    Route::get('dons/{id}/delete','DonsController@destroy');

    /*Tipos Presenca */
    Route::get('tipospresenca', 'TiposPresencaController@index');
    Route::post('/tipospresenca/gravar','TiposPresencaController@store');
    Route::get('/tipospresenca/registrar','TiposPresencaController@create');
    Route::get('/tipospresenca/{id}/preview','TiposPresencaController@show');
    Route::post('tipospresenca/{id}/update','TiposPresencaController@update');
    Route::get('tipospresenca/{id}/edit','TiposPresencaController@edit');
    Route::get('tipospresenca/{id}/delete','TiposPresencaController@destroy');

    /*Tipos Movimentação */
    Route::get('tiposmovimentacao', 'TiposMovimentacaoController@index');
    Route::post('/tiposmovimentacao/gravar','TiposMovimentacaoController@store');
    Route::get('/tiposmovimentacao/registrar','TiposMovimentacaoController@create');
    Route::get('/tiposmovimentacao/{id}/preview','TiposMovimentacaoController@show');
    Route::post('tiposmovimentacao/{id}/update','TiposMovimentacaoController@update');
    Route::get('tiposmovimentacao/{id}/edit','TiposMovimentacaoController@edit');
    Route::get('tiposmovimentacao/{id}/delete','TiposMovimentacaoController@destroy');

    /*Graus parentesco */
    Route::get('grausparentesco', 'GrausParentescoController@index');
    Route::post('/grausparentesco/gravar','GrausParentescoController@store');
    Route::get('/grausparentesco/registrar','GrausParentescoController@create');
    Route::get('/grausparentesco/{id}/preview','GrausParentescoController@show');
    Route::post('grausparentesco/{id}/update','GrausParentescoController@update');
    Route::get('grausparentesco/{id}/edit','GrausParentescoController@edit');
    Route::get('grausparentesco/{id}/delete','GrausParentescoController@destroy');

    /*Cargos e Funções*/
    Route::get('cargos', 'CargosController@index');
    Route::post('/cargos/gravar','CargosController@store');
    Route::get('/cargos/registrar','CargosController@create');
    Route::get('/cargos/{id}/preview','CargosController@show');
    Route::post('cargos/{id}/update','CargosController@update');
    Route::get('cargos/{id}/edit','CargosController@edit');
    Route::get('cargos/{id}/delete','CargosController@destroy');

    /*Ramos Atividades*/
    Route::get('ramos', 'RamosAtividadesController@index');
    Route::post('/ramos/gravar','RamosAtividadesController@store');
    Route::get('/ramos/registrar','RamosAtividadesController@create');
    Route::get('/ramos/{id}/preview','RamosAtividadesController@show');
    Route::post('ramos/{id}/update','RamosAtividadesController@update');
    Route::get('ramos/{id}/edit','RamosAtividadesController@edit');
    Route::get('ramos/{id}/delete','RamosAtividadesController@destroy');

    /*Estados Civis*/
    Route::get('civis', 'EstadosCivisController@index');
    Route::post('/civis/gravar','EstadosCivisController@store');
    Route::get('/civis/registrar','EstadosCivisController@create');
    Route::get('/civis/{id}/preview','EstadosCivisController@show');
    Route::post('civis/{id}/update','EstadosCivisController@update');
    Route::get('civis/{id}/edit','EstadosCivisController@edit');
    Route::get('civis/{id}/delete','EstadosCivisController@destroy');

    /*Religioẽs*/
    Route::get('religioes', 'ReligioesController@index');
    Route::post('/religioes/gravar','ReligioesController@store');
    Route::get('/religioes/registrar','ReligioesController@create');
    Route::get('/religioes/{id}/preview','ReligioesController@show');
    Route::post('religioes/{id}/update','ReligioesController@update');
    Route::get('religioes/{id}/edit','ReligioesController@edit');
    Route::get('religioes/{id}/delete','ReligioesController@destroy');

    /*Habilidades*/
    Route::get('habilidades', 'HabilidadesController@index');
    Route::post('/habilidades/gravar','HabilidadesController@store');
    Route::get('/habilidades/registrar','HabilidadesController@create');
    Route::get('/habilidades/{id}/preview','HabilidadesController@show');
    Route::post('habilidades/{id}/update','HabilidadesController@update');
    Route::get('habilidades/{id}/edit','HabilidadesController@edit');
    Route::get('habilidades/{id}/delete','HabilidadesController@destroy');

    /*Disponibilidades*/
    Route::get('disponibilidades', 'DisponibilidadesController@index');
    Route::post('/disponibilidades/gravar','DisponibilidadesController@store');
    Route::get('/disponibilidades/registrar','DisponibilidadesController@create');
    Route::get('/disponibilidades/{id}/preview','DisponibilidadesController@show');
    Route::post('disponibilidades/{id}/update','DisponibilidadesController@update');
    Route::get('disponibilidades/{id}/edit','DisponibilidadesController@edit');
    Route::get('disponibilidades/{id}/delete','DisponibilidadesController@destroy');

    /*Situações*/
    Route::get('situacoes', 'SituacoesController@index');
    Route::post('/situacoes/gravar','SituacoesController@store');
    Route::get('/situacoes/registrar','SituacoesController@create');
    Route::get('/situacoes/{id}/preview','SituacoesController@show');
    Route::post('situacoes/{id}/update','SituacoesController@update');
    Route::get('situacoes/{id}/edit','SituacoesController@edit');
    Route::get('situacoes/{id}/delete','SituacoesController@destroy');

    /*Pessoas*/
    Route::get('pessoas', 'PessoasController@index');
    Route::post('/pessoas/gravar','PessoasController@store');
    Route::get('/pessoas/registrar','PessoasController@create');
    Route::get('/pessoas/registrar/{id}','PessoasController@create');
    Route::get('/pessoas/{id}/preview','PessoasController@show');
    Route::get('/pessoas/{id}/preview/{id_tipo_pessoa}','PessoasController@show');
    Route::post('pessoas/{id}/update','PessoasController@update');
    Route::get('pessoas/{id}/edit','PessoasController@edit');
    Route::get('pessoas/{id}/edit/{id_tipo_pessoa}','PessoasController@edit');
    Route::get('pessoas/{id}/delete','PessoasController@destroy');
    Route::get('pessoas/{id}/remover','PessoasController@remove_image');

    /*Grupos Pessoas*/
    Route::get('grupospessoas', 'GruposPessoasController@index');
    Route::post('/grupospessoas/gravar','GruposPessoasController@store');
    Route::get('/grupospessoas/registrar','GruposPessoasController@create');
    Route::get('/grupospessoas/{id}/preview','GruposPessoasController@show');
    Route::post('grupospessoas/{id}/update','GruposPessoasController@update');
    Route::get('grupospessoas/{id}/edit','GruposPessoasController@edit');
    Route::get('grupospessoas/{id}/delete','GruposPessoasController@destroy');

    /*Tipos de Pessoas*/
    Route::get('tipospessoas', 'TiposPessoasController@index');
    Route::post('/tipospessoas/gravar','TiposPessoasController@store');
    Route::get('/tipospessoas/registrar','TiposPessoasController@create');
    Route::get('/tipospessoas/{id}/preview','TiposPessoasController@show');
    Route::post('tipospessoas/{id}/update','TiposPessoasController@update');
    Route::get('tipospessoas/{id}/edit','TiposPessoasController@edit');
    Route::get('tipospessoas/{id}/delete','TiposPessoasController@destroy');

    /*Tipos de Telefones*/
    Route::get('tipostelefones', 'TiposTelefonesController@index');
    Route::post('/tipostelefones/gravar','TiposTelefonesController@store');
    Route::get('/tipostelefones/registrar','TiposTelefonesController@create');
    Route::get('/tipostelefones/{id}/preview','TiposTelefonesController@show');
    Route::post('tipostelefones/{id}/update','TiposTelefonesController@update');
    Route::get('tipostelefones/{id}/edit','TiposTelefonesController@edit');
    Route::get('tipostelefones/{id}/delete','TiposTelefonesController@destroy');

    /* Usado para verificar a existencia de um usuário para as igrejas/instituições.*/
    Route::get('/validar/{id}/user', 'UsersController@validar');

    /*Bancos*/
    Route::get('bancos', 'BancosController@index');
    Route::post('/bancos/gravar','BancosController@store');
    Route::get('/bancos/registrar','BancosController@create');
    Route::get('/bancos/{id}/preview','BancosController@show');
    Route::post('bancos/{id}/update','BancosController@update');
    Route::get('bancos/{id}/edit','BancosController@edit');
    Route::get('bancos/{id}/delete','BancosController@destroy');

});