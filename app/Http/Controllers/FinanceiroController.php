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
use App\User;


class FinanceiroController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
        $this->rota = "financeiro"; //Define nome da rota que será usada na classe

    }

    //Exibir listagem
    public function index()
    {

        //Verificar se foi cadastrado os dados da igreja
        if (usuario::find(Auth::user()->id))
       {
              //Busca ID do cliente cloud e ID da empresa
              $this->dados_login = usuario::find(Auth::user()->id);

              //$dados = bancos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

              $retorno = \DB::select('select  fn_total_titulos_aberto(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id . ', ' . "'R'" . ')');
              $total_receber_aberto = $retorno[0]->fn_total_titulos_aberto;

              $retorno = \DB::select('select  fn_total_titulos_mes(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id . ', ' . "'R'" . ')');
              $total_receber_mes = $retorno[0]->fn_total_titulos_mes;

              $retorno = \DB::select('select  fn_total_titulos_aberto(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id . ', ' . "'P'" . ')');
              $total_pagar_aberto = $retorno[0]->fn_total_titulos_aberto;

              $retorno = \DB::select('select  fn_total_titulos_mes(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id . ', ' . "'P'" . ')');
              $total_pagar_mes = $retorno[0]->fn_total_titulos_mes;

              return view($this->rota . '.dashboard', ['total_receber_aberto'=>$total_receber_aberto, 'total_receber_mes'=>$total_receber_mes, 'total_pagar_aberto'=>$total_pagar_aberto, 'total_pagar_mes'=>$total_pagar_mes]);
       }

    }


}