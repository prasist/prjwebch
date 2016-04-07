<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use Auth;
use Input;
use Gate;

class CarregaEstruturasController extends Controller
{

    public function __construct()
    {

        /*O usuário deverá ter acesso a tela de pessoas para ter acesso as estruturas...*/
        $this->rota = "pessoas"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }

    }


    public function carregar_nivel5($id)
    {

        /* Pega  ID do nivel 4 */
        $nivel5 = \App\Models\celulas_nivel5::select('celulas_nivel4_id')->where('id', '=', $id)->get();

        /*Pelo ID passado do nivel 5 busca qual o nivel 4 vinculado*/
        $nivel4 = \App\Models\celulas_nivel4::select('celulas_nivel4.id', 'nome', 'razaosocial')
        ->where('celulas_nivel4.id', '=', $nivel5[0]->celulas_nivel4_id)
        ->where('celulas_nivel4.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('celulas_nivel4.empresas_id', $this->dados_login->empresas_id)
        ->leftJoin('pessoas', 'pessoas.id', '=' , 'celulas_nivel4.pessoas_id')
        ->get();

        $options = array();

        foreach ($nivel4 as $item)
        {
            $options += array($item->id => ($item->razaosocial=="" ? $item->nome : $item->razaosocial) );
        }

        return \Response::json($options);

    }

    public function carregar_nivel4($id)
    {

        $nivel4 = \App\Models\celulas_nivel4::select('celulas_nivel3_id')->where('id', '=', $id)->get();

        /*Pelo ID passado do nivel 4 busca qual o nivel 3 vinculado*/
        $nivel3 = \App\Models\celulas_nivel3::select('celulas_nivel3.id', 'nome', 'razaosocial')
        ->where('celulas_nivel3.id', '=', $nivel4[0]->celulas_nivel3_id)
        ->where('celulas_nivel3.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('celulas_nivel3.empresas_id', $this->dados_login->empresas_id)
        ->leftJoin('pessoas', 'pessoas.id', '=' , 'celulas_nivel3.pessoas_id')
        ->get();

        $options = array();

        foreach ($nivel3 as $item)
        {
            $options += array($item->id => ($item->razaosocial=="" ? $item->nome : $item->razaosocial));
        }

        return \Response::json($options);

    }


    public function carregar_nivel3($id)
    {

        $nivel3 = \App\Models\celulas_nivel3::select('celulas_nivel2_id')->where('id', '=', $id)->get();

        /*Pelo ID passado do nivel 3 busca qual o nivel 2 vinculado*/
        $nivel2 = \App\Models\celulas_nivel2::select('celulas_nivel2.id', 'nome', 'razaosocial')
        ->where('celulas_nivel2.id', '=', $nivel3[0]->celulas_nivel2_id)
        ->where('celulas_nivel2.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('celulas_nivel2.empresas_id', $this->dados_login->empresas_id)
        ->leftJoin('pessoas', 'pessoas.id', '=' , 'celulas_nivel2.pessoas_id')
        ->get();

        $options = array();

        foreach ($nivel2 as $item)
        {
            $options += array($item->id => ($item->razaosocial=="" ? $item->nome : $item->razaosocial));
        }

        return \Response::json($options);

    }


    public function carregar_nivel2($id)
    {

        /*Pelo ID passado do nivel 2 busca qual o nivel 1 vinculado*/
        $nivel2 = \App\Models\celulas_nivel2::select('celulas_nivel1_id')->where('id', '=', $id)->get();

        /*Carregar todos registros do nivel 1 conforme ID encontrado */
        $nivel1 = \App\Models\celulas_nivel1::select('celulas_nivel1.id', 'nome', 'razaosocial')
        ->where('celulas_nivel1.id', '=', $nivel2[0]->celulas_nivel1_id)
        ->where('celulas_nivel1.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('celulas_nivel1.empresas_id', $this->dados_login->empresas_id)
        ->leftJoin('pessoas', 'pessoas.id', '=' , 'celulas_nivel1.pessoas_id')
        ->get();

        $options = array();

        //enquanto houver registros
        foreach ($nivel1 as $item)
        {
            $options += array($item->id => ($item->razaosocial=="" ? $item->nome : $item->razaosocial));
        }

        return \Response::json($options);

    }

}
