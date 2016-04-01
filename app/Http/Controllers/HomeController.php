<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\usuario;
use App\Http\Controllers\Controller;
use URL;
use Auth;
use Input;
use Gate;

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
        $this->rota = "home"; //Define nome da rota que será usada na classe
        //retirado gate
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //retirado da construct
        //Validação de permissão de acesso a pagina
        //if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        //{
            //$this->dados_login = \Session::get('dados_login');
        //}

        //Verificar se foi cadastrado os dados da igreja
        if (usuario::find(Auth::user()->id))
       {
            //Busca ID do cliente cloud e ID da empresa
            $this->dados_login = usuario::find(Auth::user()->id);

            \Session::put('titulo', 'Home | Dashboard');
            \Session::put('subtitulo', '');
            \Session::put('route', '');
            \Session::put('dados_login', $this->dados_login);
            \Session::put('tour_rapido', $this->dados_login->tutorial);
            \Session::put('admin', $this->dados_login->admin);

            /*
            Busca Configuracao de labels para menu de estrutura de celulas
            */
            $menu_celulas = \App\Models\configuracoes::select('id', 'celulas_nivel1_label', 'celulas_nivel2_label', 'celulas_nivel3_label', 'celulas_nivel4_label', 'celulas_nivel5_label')
                    ->where('empresas_id', $this->dados_login->empresas_id)
                    ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
                    ->get();

            if ($menu_celulas)
            {
                 \Session::put('nivel1', $menu_celulas[0]->celulas_nivel1_label);
                 \Session::put('nivel2', $menu_celulas[0]->celulas_nivel2_label);
                 \Session::put('nivel3', $menu_celulas[0]->celulas_nivel3_label);
                 \Session::put('nivel4', $menu_celulas[0]->celulas_nivel4_label);
                 \Session::put('nivel5', $menu_celulas[0]->celulas_nivel5_label);
            }

            $where =
            [
                'empresas_id' => $this->dados_login->empresas_id,
                'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id
            ];

            //-------------------Functions no POSTGRES
            //Total de registro na tabela pessoas
            $retorno = \DB::select('select  fn_total_pessoas(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
            $total_pessoas = $retorno[0]->fn_total_pessoas;

            //Total de membros. Verifica-se no cadastro de tipo de pessoas o registro que contenha a aba membros configurada
            $retorno = \DB::select('select  fn_total_membros(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
            $total_membros = $retorno[0]->fn_total_membros;

            //Total de aniversariantes no mes
            $retorno = \DB::select('select  fn_total_niver(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
            $total_aniversariantes = $retorno[0]->fn_total_niver;

            $retorno = \DB::select('select  fn_total_inativos(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
            $total_inativos = $retorno[0]->fn_total_inativos;

            //----------------- FIM Functions POSTGRES

            return view('pages.dashboard',
                [
                    'total_pessoas' => $total_pessoas,
                    'total_membros' => $total_membros,
                    'total_aniversariantes' => $total_aniversariantes,
                    'total_inativos' => $total_inativos
                ]);

        }
        else
        {
            return view('pages.dashboard_blank');  //Ainda nao cadastrou, solicitar o cadastro
        }


    }
}
