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

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }

    }

    //Exibir listagem
    public function index()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

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

              $retorno = \DB::select('select  fn_saldo_contas(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id . ')');
              $saldo_contas = $retorno[0]->fn_saldo_contas;

              return view($this->rota . '.dashboard', ['total_receber_aberto'=>$total_receber_aberto, 'total_receber_mes'=>$total_receber_mes, 'total_pagar_aberto'=>$total_pagar_aberto, 'total_pagar_mes'=>$total_pagar_mes, 'saldo_contas'=>$saldo_contas]);
       }

    }


}