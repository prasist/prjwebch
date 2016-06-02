<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\titulos;
use URL;
use Auth;
use Input;
use Gate;

class TitulosController extends Controller
{

    public function __construct()
    {

        $this->rota = "titulos"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }

    }

    //Exibir listagem
    public function index($tipo)
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        $sQuery = "select id, to_char(to_date(data_vencimento, 'yyyy-MM-dd'), 'DD/MM/YYYY') AS data_vencimento, to_char(to_date(data_pagamento, 'yyyy-MM-dd'), 'DD/MM/YYYY') AS data_pagamento, valor, acrescimo, desconto, descricao, tipo, status, valor_pago";
        $sQuery .= " from titulos ";
        $sQuery .= " where tipo = ? ";
        $sQuery .= " and empresas_id = ? ";
        $sQuery .= " and empresas_clientes_cloud_id = ? ";
        $sQuery .= " order by id ";
        $dados = \DB::select($sQuery, [$tipo, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view($this->rota . '.index',['dados'=>$dados, 'post_status'=>'', 'tipo'=>$tipo, 'post_mes'=>'']);
    }

    //Criar novo registro
    public function create($tipo)
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        $contas = \App\Models\contas::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->OrderBy('nome')
        ->get();

        $plano_contas = \App\Models\planos_contas::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->OrderBy('nome')
        ->get();

        $centros_custos = \App\Models\centros_custos::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->OrderBy('nome')
        ->get();

        $grupos_titulos = \App\Models\grupos_titulos::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->OrderBy('nome')
        ->get();

        return view($this->rota . '.registrar', ['contas' => $contas,'tipo'=>$tipo, 'plano_contas'=>$plano_contas, 'centros_custos'=>$centros_custos, 'grupos_titulos'=>$grupos_titulos]);

    }

    public function pesquisar(\Illuminate\Http\Request  $request, $tipo)
    {

        $formatador = new  \App\Functions\FuncoesGerais();

          $input = $request->except(array('_token')); //não levar o token

          if ($input["mes"]=="C") //Mes corrente
          {

               $mes =date("m"); // mes atual
               $ano = date("Y"); // Ano atual
               $ultimo_dia = date("t", mktime(0,0,0,$mes,'01',$ano)); // pegar ultimo dia do mes corrente

               $data_inicial = $ano . '-' . $mes . '-01'; //Monta data inicial do mes corrente
               $data_final = $ano . '-' . $mes . '-' . $ultimo_dia; //até último dia mes corrente
          }
          else if ($input["mes"]=="E") //Mes especifico
          {
               $data_inicial = $formatador->FormatarData($input["data_inicial"]);
               $data_final = $formatador->FormatarData($input["data_final"]);
          }


          $sQuery = "select id, to_char(to_date(data_vencimento, 'yyyy-MM-dd'), 'DD/MM/YYYY') AS data_vencimento, to_char(to_date(data_pagamento, 'yyyy-MM-dd'), 'DD/MM/YYYY') AS data_pagamento, valor, acrescimo, desconto, descricao, tipo, status, valor_pago";
          $sQuery .= " from titulos ";
          $sQuery .= " where tipo = ? ";
          $sQuery .= " and empresas_id = ? ";
          $sQuery .= " and empresas_clientes_cloud_id = ? ";

          if ($input["status"]=="T")
          {
              $sQuery .= " and status <> ? ";
          }
          else
          {
            $sQuery .= " and status = ? ";
          }

          $sQuery .= " and data_vencimento >= ? ";
          $sQuery .= " and data_vencimento <= ? ";
          $sQuery .= " order by id ";

          $dados = \DB::select($sQuery, [$tipo, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id, $input["status"], $data_inicial, $data_final]);

          return view($this->rota . '.index',['dados'=>$dados, 'post_status'=>$input["status"], 'tipo'=>$tipo, 'post_mes'=>$input["mes"]]);

    }

/*
* Grava dados no banco
*
*/
    public function store(\Illuminate\Http\Request  $request, $tipo)
    {

            /*Validação de campos - request*/
            $this->validate($request, [
                    'nome' => 'required|max:60:min:3',
            ]);

           $input = $request->except(array('_token', 'ativo')); //não levar o token

           $grupos = new titulos();
           $grupos->nome  = $input['nome'];
           $grupos->clientes_cloud_id  = $this->dados_login->empresas_clientes_cloud_id;
           $grupos->save();

           \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

            return redirect($this->rota);

    }

    //Abre tela para edicao ou somente visualização dos registros
    private function exibir ($request, $id, $preview, $tipo)
    {
        if($request->ajax())
        {
            return URL::to($this->rota . '/'. $id . '/edit');
        }

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        //preview = true, somente visualizacao, desabilita botao gravar
        $dados = titulos::findOrfail($id);
        return view($this->rota . '.edit', ['dados' =>$dados, 'preview' => $preview] );

    }

    /*Update pela table editavel*/
    public function update_inline(\Illuminate\Http\Request  $request, $id, $campo, $tipo)
    {

        $formatador = new  \App\Functions\FuncoesGerais();

        $input = $request->except(array('_token', 'ativo')); //não levar o token
        $titulos = titulos::findOrfail($id);

        if ($campo=="data_venc") $titulos->data_vencimento  = $formatador->FormatarData($input["value"]);

        if ($campo=="data_pagto")  $titulos->data_pagamento  = $formatador->FormatarData($input["value"]);

        if ($campo=="descricao") $titulos->descricao  = $input["value"];

        if ($campo=="status")  $titulos->status  = $input["value"];

        if ($campo=="valor") $titulos->valor  = $formatador->GravarCurrency($input["value"]);

        if ($campo=="valor_pago")  $titulos->valor_pago  = $formatador->GravarCurrency($input["value"]);

        if ($campo=="acrescimo") $titulos->acrescimo  = $formatador->GravarCurrency($input["value"]);

        if ($campo=="desconto")  $titulos->desconto  = $formatador->GravarCurrency($input["value"]);

        if ($campo=="check_pago")
        {
          //Criar trigger historico
             if ($input["value"]=="0")
             { //Sim
                $titulos->valor_pago  = $titulos->valor;
                $titulos->data_pagamento  = $titulos->data_vencimento;
                $titulos->status = "B";
              }
              else
              {
                  $titulos->valor_pago  = null;
                  $titulos->data_pagamento  = null;
                  $titulos->status = "A";
              }
        }

        $titulos->save();
        return response()->json([ 'code'=>200], 200);
    }

    //Visualizar registro
    public function show (\Illuminate\Http\Request $request, $id, $tipo)
    {

            return $this->exibir($request, $id, 'true', $tipo);

    }

    //Direciona para tela de alteracao
    public function edit(\Illuminate\Http\Request $request, $id, $tipo)
    {

            return $this->exibir($request, $id, 'false', $tipo);

    }


    /**
     * Atualiza dados no banco
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update(\Illuminate\Http\Request  $request, $id, $tipo)
    {

        /*Validação de campos - request*/
        $this->validate($request, [
                'nome' => 'required|max:60:min:3',
         ]);

        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $dados = titulos::findOrfail($id);
        $dados->nome  = $input['nome'];
        $dados->save();

        \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

        return redirect($this->rota);

    }

    /**
     * Excluir registro do banco.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id, $tipo)
    {

            $dados = titulos::findOrfail($id);
            $dados->delete();

            return redirect($this->rota);

    }

}