<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\usuario;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //Verificar se foi cadastrado os dados da igreja
        if (usuario::find(Auth::user()->id))
        {
            //Busca ID do cliente cloud e ID da empresa
            $dados_login = usuario::find(Auth::user()->id);

            \Session::put('titulo', 'Home | Dashboard');
            \Session::put('subtitulo', '');
            \Session::put('route', '');
            \Session::put('dados_login', $dados_login);
            \Session::put('tour_rapido', $dados_login->tutorial);

            $where =
            [
                'empresas_id' => $dados_login->empresas_id,
                'empresas_clientes_cloud_id' => $dados_login->empresas_clientes_cloud_id
            ];

            //-------------------Functions no POSTGRES
            //Total de registro na tabela pessoas
            $retorno = \DB::select('select  fn_total_pessoas()');
            $total_pessoas = $retorno[0]->fn_total_pessoas;

            //Total de membros. Verifica-se no cadastro de tipo de pessoas o registro que contenha a aba membros configurada
            $retorno = \DB::select('select  fn_total_membros()');
            $total_membros = $retorno[0]->fn_total_membros;

            //Total de aniversariantes no mes
            $retorno = \DB::select('select  fn_total_niver()');
            $total_aniversariantes = $retorno[0]->fn_total_niver;

            $retorno = \DB::select('select  fn_total_inativos()');
            $total_inativos = $retorno[0]->fn_total_inativos;

            //----------------- FIM Functions POSTGRES

            return view('pages.dashboard', [
            'total_pessoas' => $total_pessoas,
            'total_membros' => $total_membros,
            'total_aniversariantes' => $total_aniversariantes,
            'total_inativos' => $total_inativos]);     //ok, direciona para dashboard

        }
        else
        {
            return view('pages.dashboard_blank');  //Ainda nao cadastrou, solicitar o cadastro
        }


    }
}
