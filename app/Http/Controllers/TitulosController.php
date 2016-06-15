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

        /*Instancia a classe de funcoes (Data, valor, etc)*/
        $this->formatador = new  \App\Functions\FuncoesGerais();

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

        //Mes corrente
        $mes =date("m"); // mes atual
        $ano = date("Y"); // Ano atual
        $ultimo_dia = date("t", mktime(0,0,0,$mes,'01',$ano)); // pegar ultimo dia do mes corrente
        $data_inicial = $ano . '-' . $mes . '-01'; //Monta data inicial do mes corrente
        $data_final = $ano . '-' . $mes . '-' . $ultimo_dia; //até último dia mes corrente

        $sQuery = "select id, to_char(to_date(data_vencimento, 'yyyy-MM-dd'), 'DD/MM/YYYY') AS data_vencimento, to_char(to_date(data_pagamento, 'yyyy-MM-dd'), 'DD/MM/YYYY') AS data_pagamento, valor, acrescimo, desconto, descricao, tipo, status, valor_pago, saldo_a_pagar, alteracao_status";
        $sQuery .= " from titulos ";
        $sQuery .= " where tipo = ? ";
        $sQuery .= " and empresas_id = ? ";
        $sQuery .= " and empresas_clientes_cloud_id = ? ";
        $sQuery .= " and data_vencimento >= ? ";
        $sQuery .= " and data_vencimento <= ? ";
        $sQuery .= " order by id ";
        $dados = \DB::select($sQuery, [$tipo, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id, $data_inicial, $data_final]);

        return view($this->rota . '.index',['dados'=>$dados, 'post_status'=>'', 'tipo'=>$tipo, 'post_mes'=>'']);
    }


    //Exibe pagina (view) para insercao de dados
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


    /*Quando clicado botao de acao em lote (Pega checkbox selecionados)*/
    public function acao_lote(\Illuminate\Http\Request  $request, $tipo)
    {

          $input = $request->except(array('_token')); //não levar o token

          foreach($input['check_id'] as $key => $value) //Percorre somente checkbox selecionados
          {

                  $dados = titulos::findOrfail($key);

                  if ($input['quero_fazer']=="baixar") //Baixar selecionados
                  {
                        $dados->data_pagamento  = $this->formatador->FormatarData($input["data_pagto_lote"]);
                        $dados->status  = "B";
                        $dados->valor_pago  = ($input["campo_valor_pago"][$key]>0 ? $this->formatador->GravarCurrency($input["campo_valor_pago"][$key]) : $this->formatador->GravarCurrency($input["campo_valor"][$key]));
                        $dados->users_id  = Auth::user()->id;

                  }
                  else if ($input['quero_fazer']=="estornar") //Estornar selecionados
                  {
                        $dados->status  = "A";
                        $dados->desconto  = null;
                        $dados->acrescimo  = null;
                        $dados->valor_pago  = null;
                        $dados->data_pagamento=null;
                  }

                  $dados->alteracao_status = "S"; //Servirá para filtras o log de titulos somente com baixas e estornors
                  $dados->users_id  = Auth::user()->id;
                  $dados->save();

          }

          return redirect($this->rota . '/' . $tipo);

    }


    /*Pesquisa */
    public function pesquisar(\Illuminate\Http\Request  $request, $tipo)
    {

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
               $data_inicial = $this->formatador->FormatarData($input["data_inicial"]);
               $data_final = $this->formatador->FormatarData($input["data_final"]);
          }
          else if ($input["mes"]=="M") //Mais opcoes
          {
               $data_inicial = $this->formatador->FormatarData($input["data_inicial"]);
               $data_final = $this->formatador->FormatarData($input["data_final"]);
          }


          $sQuery = "select id, to_char(to_date(data_vencimento, 'yyyy-MM-dd'), 'DD/MM/YYYY') AS data_vencimento, to_char(to_date(data_pagamento, 'yyyy-MM-dd'), 'DD/MM/YYYY') AS data_pagamento, valor, acrescimo, desconto, descricao, tipo, status, valor_pago, saldo_a_pagar";
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


    /*Update ou insert*/
    public function salvar($request, $id, $tipo, $tipo_operacao)
    {

           /*Validação de campos - request*/
           $this->validate($request, [
                    'descricao' => 'required',
                    'data_vencimento' => 'required',
                    'valor' => 'required',
                    'conta' => 'required',
           ]);

          $input = $request->except(array('_token', 'ativo')); //não levar o token

          $qtd_parcelas = ($input['parcelas']=="" ? 1 : $input['parcelas']); /*Qtd de parcelas*/
          $vencimento = $this->formatador->FormatarData($input["data_vencimento"]); //Primeiro vencimento
          $date = new \DateTime($vencimento);

            if ($tipo_operacao=="create") //novo registro
            {
                for ($i=1; $i <= $qtd_parcelas; $i++) //Se for passado parcela maior que 1
                {
                     $dados = new titulos();
                     $this->persisteDados($tipo, $dados, $input, $i, $vencimento, $qtd_parcelas, $date);

                     //Acrescenta um mes na data de vencimento
                     $interval = new \DateInterval('P1M');
                     $vencimento = $date->add($interval);

                }
            }
            else //update
            {
                 $dados = titulos::findOrfail($id);
                 $this->persisteDados($tipo, $dados, $input, 1, $vencimento, 1, $date);
            }


    }


  private function persisteDados($tipo, $dados, $input, $seq, $vencimento, $qtd_parcelas, $date)
  {

      if ($qtd_parcelas>1)
      {
          $dados->descricao  = $input['descricao'] . ' - (' . $seq . '/' . $qtd_parcelas . ')';
      }
      else
      {
          $dados->descricao  = $input['descricao'];
      }

      $dados->empresas_id  = $this->dados_login->empresas_id;
      $dados->empresas_clientes_cloud_id  = $this->dados_login->empresas_clientes_cloud_id;
      $dados->valor  = $this->formatador->GravarCurrency($input["valor"]);
      $dados->data_vencimento  = $date->format('Y-m-d'); //Data vencimento (acrescida se mais de uma parcela)
      $dados->data_emissao  = $this->formatador->FormatarData($input["data_emissao"]);
      $dados->data_pagamento  = $this->formatador->FormatarData($input["data_pagamento"]);
      $dados->tipo  = $tipo;

      //Pega valor já pago (Pagamento parcial)
      $var_valor_pago = ($input["total_pago"]!="" ? $this->formatador->GravarCurrency($input["total_pago"]) : 0);

      /*Valores Pagos*/
      $dados->desconto     = ($input["desconto"]!="" ? $this->formatador->GravarCurrency($input["desconto"]) : null);
      $dados->acrescimo   = ($input["acrescimo"]!="" ? $this->formatador->GravarCurrency($input["acrescimo"]) : null);
      $dados->valor_pago  = $var_valor_pago + ($input["valor_pago"]!="" ? $this->formatador->GravarCurrency($input["valor_pago"]) : null);

      //Calcula valor pago com desconto / acrescimo
      $dados->valor_pago      = ($dados->valor_pago + $dados->acrescimo - $dados->desconto);
      $dados->saldo_a_pagar = ($dados->valor - $dados->valor_pago);

      $var_status  = ($input['ckpago']  ? "B" : "A");

      //Verificar se houve alteracao do STATUS, para marcar se é alteracao do status do titulos A Ou B.
      //Alteracoes simples como descricao, valor, fornecedor ou qualquer outro tipo de alteracao sem alterar o status não aparecerá em relatórios de conta corrente (baixas e estornos)
      if ($var_status != $dados->status && $dados->status!="")
      {
          $dados->alteracao_status = "S"; //Servirá para filtras o log de titulos somente com baixas e estornors
      }
      else
      {
          $dados->alteracao_status = ""; //Servirá para filtras o log de titulos somente com baixas e estornors
      }

      //Se houver saldo, será baixa parcial
      if ($dados->saldo_a_pagar<=0)
      { //Se nao houver saldo, deixa colocar o status normalmente
          $dados->status  = $var_status;
      }
      else
      { //Baixa Parcial, deixar titulo em aberto
          $dados->status = "A";
      }

      $dados->grupos_titulos_id  = ($input['grupos_titulos']=="" ? null : $input['grupos_titulos']);
      $dados->pessoas_id  = ($input['fornecedor']=="" ? null : substr($input['fornecedor'],0,9));
      $dados->contas_id  =  ($input['conta']=="" ? null : $input['conta']);
      $dados->planos_contas_id  =  ($input['plano']=="" ? null : $input['plano']);
      $dados->centros_custos_id  =  ($input['centros_custos']=="" ? null : $input['centros_custos']);
      $dados->obs  = $input['obs'];
      $dados->numdoc  = $input['numdoc'];
      $dados->serie  = $input['serie'];
      $dados->numpar  = $seq;
      $dados->users_id  = Auth::user()->id;
      $dados->save();

    }



/*
* Grava dados no banco
*
*/
    public function store(\Illuminate\Http\Request  $request, $tipo)
    {
            $this->salvar($request, "", $tipo, "create");
            \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');
            return redirect($this->rota . '/' . $tipo);
    }



    //Abre tela para edicao ou somente visualização dos registros
    private function exibir ($request, $id, $preview, $tipo)
    {
        if($request->ajax())
        {
            return URL::to($this->rota . '/'. $id . '/edit/' . $tipo);
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

        /*Log historico do titulo*/
        $sQuery = "select to_char(data_ocorrencia, 'DD/MM/YYYY  HH24:MI:SS') AS data_ocorrencia, name, descricao, valor, valor_pago, acrescimo, desconto, tipo, status, acao, ip, id_titulo, saldo_a_pagar, alteracao_status from log_financeiro inner join users  on users.id = log_financeiro.users_id";
        $sQuery .= " where id_titulo = ? Order by data_ocorrencia desc";
        $log = \DB::select($sQuery,[$id]);


        $sQuery = "select titulos.saldo_a_pagar, pessoas.razaosocial, titulos.id, to_char(to_date(data_vencimento, 'yyyy-MM-dd'), 'DD/MM/YYYY') AS data_vencimento, to_char(to_date(data_pagamento, 'yyyy-MM-dd'), 'DD/MM/YYYY') AS data_pagamento, to_char(to_date(data_emissao, 'yyyy-MM-dd'), 'DD/MM/YYYY') AS data_emissao, valor, acrescimo, desconto, descricao, tipo, status, valor_pago, pessoas_id, contas_id, planos_contas_id, centros_custos_id, titulos.obs, numpar, numdoc, serie, grupos_titulos_id, alteracao_status ";
        $sQuery .= " from titulos left join pessoas on pessoas.id = titulos.pessoas_id";
        $sQuery .= " where titulos.tipo = ? ";
        $sQuery .= " and titulos.empresas_id = ? ";
        $sQuery .= " and titulos.empresas_clientes_cloud_id = ? ";
        $sQuery .= " and titulos.id = ? ";
        $dados = \DB::select($sQuery,[$tipo, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id, $id]);

        return view($this->rota . '.edit', ['log'=>$log, 'preview' => $preview, 'dados'=>$dados, 'contas' => $contas,'tipo'=>$tipo, 'plano_contas'=>$plano_contas, 'centros_custos'=>$centros_custos, 'grupos_titulos'=>$grupos_titulos]);

    }




    /*Update pela table editavel*/
    public function update_inline(\Illuminate\Http\Request  $request, $id, $campo, $tipo)
    {

        $input = $request->except(array('_token', 'ativo')); //não levar o token
        $titulos = titulos::findOrfail($id);

        $var_acrescimo = ($titulos->acrescimo!="" ? $titulos->acrescimo :0);
        $var_desconto = ($titulos->desconto!="" ? $titulos->desconto :0);
        $var_valor_pago = ($titulos->valor_pago!="" ? $titulos->valor_pago :0);
        $var_valor_liq = ($var_valor_pago - $var_acrescimo + $var_desconto);
        $titulos->alteracao_status = ""; //Servirá para filtras o log de titulos somente com baixas e estornos. Padrão vazio, apenas alteracao simples

        if ($campo=="data_venc") $titulos->data_vencimento  = $this->formatador->FormatarData($input["value"]);

        if ($campo=="data_pagto")  $titulos->data_pagamento  = $this->formatador->FormatarData($input["value"]);

        if ($campo=="descricao") $titulos->descricao  = $input["value"];

        if ($campo=="status")  $titulos->status  = $input["value"];

        if ($campo=="valor") $titulos->valor  = $this->formatador->GravarCurrency($input["value"]);

        if ($campo=="valor_pago")
        {
            //Calcula valor pago com desconto / acrescimo
            $titulos->valor_pago      = ($this->formatador->GravarCurrency($input["value"]) + $var_acrescimo - $var_desconto);
            $titulos->saldo_a_pagar = ($titulos->valor - $titulos->valor_pago);
            $titulos->alteracao_status = "S"; //Servirá para filtras o log de titulos somente com baixas e estornos
        }

        if ($campo=="acrescimo") //Recalcula valor pago
        {
           $titulos->acrescimo  = $this->formatador->GravarCurrency($input["value"]);
           $titulos->valor_pago  = ($var_valor_liq + $titulos->acrescimo - $var_desconto);
           $titulos->saldo_a_pagar = ($titulos->valor - $titulos->valor_pago);
           $titulos->alteracao_status = "S"; //Servirá para filtras o log de titulos somente com baixas e estornos
        }

        if ($campo=="desconto") //Recalcula valor pago
        {
            $titulos->desconto  = $this->formatador->GravarCurrency($input["value"]);
            $titulos->valor_pago  = ($var_valor_liq + $var_acrescimo - $titulos->desconto);
            $titulos->saldo_a_pagar = ($titulos->valor - $titulos->valor_pago);
            $titulos->alteracao_status = "S"; //Servirá para filtras o log de titulos somente com baixas e estornos
        }

        //Se marcou PAGO ou NÃO PAGO
        if ($campo=="check_pago")
       {
             if ($input["value"]=="0")
             { //PAGOU

                $titulos->valor_pago  = (($var_valor_pago + $titulos->saldo_a_pagar) + $var_acrescimo - $var_desconto);
                $titulos->saldo_a_pagar = ($titulos->valor - $titulos->valor_pago);
                $titulos->data_pagamento  = $titulos->data_vencimento;
                $titulos->status = "B";
                $titulos->alteracao_status = "S"; //Servirá para filtras o log de titulos somente com baixas e estornors
              }
              else
              {//ESTORNOU

                  //Se foi baixado integralmente, estorna integralmente. Caso contrário deixa o saldo a pagar parcial
                  if ($titulos->status=="B")
                  {
                      $titulos->saldo_a_pagar = $titulos->valor; //Valor original titulo
                  }

                  $titulos->valor_pago  = null;
                  $titulos->desconto  = null;
                  $titulos->acrescimo  = null;
                  $titulos->data_pagamento  = null;
                  $titulos->status = "A";
                  $titulos->alteracao_status = "S"; //Servirá para filtras o log de titulos somente com baixas e estornors
              }
        }

        //Se ficou negativo, zera
        if (($titulos->valor - $titulos->valor_pago)<0)
        {
             $titulos->saldo_a_pagar=0;
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

        $this->salvar($request, $id,  $tipo, "update");
        \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');
        return redirect($this->rota . '/' . $tipo);
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
            return redirect($this->rota . '/' . $tipo);
    }

}
