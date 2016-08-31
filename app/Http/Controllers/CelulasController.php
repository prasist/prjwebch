<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\celulas;
use URL;
use Auth;
use Input;
use Gate;

class CelulasController extends Controller
{

    public function __construct()
    {

        $this->rota = "celulas"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        /*Instancia a classe de funcoes (Data, valor, etc)*/
        $this->formatador = new  \App\Functions\FuncoesGerais();

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');

            //Verificar se usuario logado é LIDER
            $this->lider_logado = $this->formatador->verifica_se_lider();

        }



    }

    public function buscar_dados($id)
    {

            $buscar = \App\Models\celulas::select('dia_encontro')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('id', $id)
            ->get();

            if ($buscar)
            {
                return $buscar[0]->dia_encontro;
            }
            else
            {
                return ""; //Retorna vazio
            }

    }

 protected function participantes_presenca ()
 {


            $strSql = " SELECT * FROM view_participantes_celula_ultima_presenca";
            $strSql .=  " WHERE ";
            $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";

            //SE for lider, direciona para dashboard da célula
            if ($this->lider_logado!=null)
            {
                   $strSql .=  " AND lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
            }

            $participantes_presenca = \DB::select($strSql);
            return $participantes_presenca;


 }

    protected function resumo_perguntas($mes, $ano)
    {
            //RESUMO por Respostas
            $strSql = " SELECT c.empresas_id, c.empresas_clientes_cloud_id, ca.mes, ca.ano, qe.pergunta, ";
            $strSql .=  " sum(cast(resposta as int)) as total ";
            $strSql .=  " FROM controle_atividades ca  ";
            $strSql .=  " inner join celulas c on c.id = ca.celulas_id ";
            $strSql .=  " inner join pessoas p on p.id = ca.lider_pessoas_id ";
            $strSql .=  " inner join controle_questions cq on cq.controle_atividades_id = ca.id and cq.empresas_id = ca.empresas_id and cq.empresas_clientes_cloud_id = ca.empresas_clientes_cloud_id ";
            $strSql .=  " inner join questionarios_encontros qe on qe.id = cq.questionarios_id ";
            $strSql .=  " where qe.tipo_resposta = 2  and cq.resposta is not null and cq.resposta <> '' AND ";
            $strSql .=  " ca.empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " ca.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " AND ";
            $strSql .=  " ca.mes  = '" . $mes . "' AND ";
            $strSql .=  " ca.ano  = '" . $ano . "'";

            //SE for lider, direciona para dashboard da célula
            if ($this->lider_logado!=null)
            {
                   $strSql .=  " AND ca.lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
            }

            $strSql .=  " group by c.empresas_id, c.empresas_clientes_cloud_id, ca.mes, ca.ano, qe.pergunta ";
            $resumo_perguntas = \DB::select($strSql);
            return $resumo_perguntas;
    }

    protected function resumo_tipo_pessoas($mes, $ano, $opcao)
    {

           //RESUMO POR TIPO DE PESSOA
            if ($opcao=="Geral")
            {

                $strSql = " SELECT c.empresas_id, c.empresas_clientes_cloud_id, tp.nome,  count(*) as total";
                $strSql .=  " from celulas_pessoas ca   ";
                $strSql .=  " inner join celulas c on c.id = ca.celulas_id ";
                $strSql .=  " inner join pessoas p on p.id = ca.pessoas_id ";
                $strSql .=  " inner join tipos_pessoas tp on tp.id = p.tipos_pessoas_id ";
                $strSql .=  " WHERE ";
                $strSql .=  " ca.empresas_id = " . $this->dados_login->empresas_id . " AND ";
                $strSql .=  " ca.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "";

                //SE for lider, direciona para dashboard da célula
                if ($this->lider_logado!=null)
                {
                       $strSql .=  " AND c.lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
                }

                $strSql .=  " group by c.empresas_id, c.empresas_clientes_cloud_id, tp.nome ";

            }
            else
            {
                //POR  PESSOA MES E ANO ESPECIFICOS
                $strSql = " SELECT c.empresas_id, c.empresas_clientes_cloud_id, ca.mes, ca.ano, tp.nome, ";
                $strSql .=  " sum(total) as total ";
                $strSql .=  " from controle_atividades ca ";
                $strSql .=  " inner join celulas c on c.id = ca.celulas_id ";
                $strSql .=  " inner join pessoas p on p.id = ca.pessoas_id ";
                $strSql .=  " inner join controle_resumo_tipo_pessoa cr on cr.controle_atividades_id = ca.id ";
                $strSql .=  " inner join tipos_pessoas tp on tp.id = cr.tipos_pessoas_id ";
                $strSql .=  " WHERE ";
                $strSql .=  " ca.empresas_id = " . $this->dados_login->empresas_id . " AND ";
                $strSql .=  " ca.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " AND ";
                $strSql .=  " ca.mes  = '" . $mes . "' AND ";
                $strSql .=  " ca.ano  = '" . $ano . "'";

                //SE for lider, direciona para dashboard da célula
                if ($this->lider_logado!=null)
                {
                       $strSql .=  " AND c.lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
                }

                $strSql .=  " group by c.empresas_id, c.empresas_clientes_cloud_id, ca.mes, ca.ano, tp.nome ";
            }

            $resumo_tipo_pessoas = \DB::select($strSql);

            return $resumo_tipo_pessoas;


    }

    protected function resumo_geral($mes, $ano) {
            //RESUMO GERAL - total geral de presentes
            $strSql = " SELECT sum(total) as total ";
            $strSql .=  " FROM controle_atividades ca  ";
            $strSql .=  " inner join celulas c on c.id = ca.celulas_id ";
            $strSql .=  " inner join pessoas p on p.id = ca.lider_pessoas_id ";
            $strSql .=  " inner join controle_resumo_tipo_pessoa cr on cr.controle_atividades_id = ca.id ";
            $strSql .=  " WHERE ";
            $strSql .=  " ca.empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " ca.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " AND ";
            $strSql .=  " ca.mes  = '" . $mes . "' AND ";
            $strSql .=  " ca.ano  = '" . $ano . "'";

            //SE for lider, direciona para dashboard da célula
            if ($this->lider_logado!=null)
            {
                   $strSql .=  " AND ca.lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
            }

            $resumo_geral = \DB::select($strSql);
            //dd($strSql);
            return $resumo_geral;

    }
    protected function resumo_presencas($mes, $ano)
    {

            //RESUMO DE PRESENCAS
            $strSql = " SELECT c.empresas_id, c.empresas_clientes_cloud_id, ca.mes, ca.ano, ";
            $strSql .=  " sum(total_membros) as total_membros, sum(total_visitantes) as total_visitantes, sum(total_geral) as total_geral ";
            $strSql .=  " FROM controle_atividades ca ";
            $strSql .=  " inner join celulas c on c.id = ca.celulas_id ";
            $strSql .=  " inner join pessoas p on p.id = ca.lider_pessoas_id ";
            $strSql .=  " inner join controle_resumo cr on cr.controle_atividades_id = ca.id ";
            $strSql .=  " WHERE ";
            //$strSql .=  " ca.id = " . $id . " AND ";
            $strSql .=  " ca.empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " ca.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " AND ";
            $strSql .=  " ca.mes  = '" . $mes . "' AND ";
            $strSql .=  " ca.ano  = '" . $ano . "'";

            //SE for lider, direciona para dashboard da célula
            if ($this->lider_logado!=null)
            {
                   $strSql .=  " AND ca.lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
            }

            $strSql .=  " GROUP BY c.empresas_id, c.empresas_clientes_cloud_id, ca.mes, ca.ano";

            $resumo = \DB::select($strSql);

            return $resumo;

    }

    public function grafico_mensal($opcao, $mes, $ano)
    {
        //Frequencia mes atual e ultimos meses
        //% percentual do total

        if ($opcao=="visitantes")
        {

            $retorna = array();

            //ULTIMOS 3 MESES
            $resumo = $this->resumo_presencas(($mes-2), $ano); //Mes atual menos 2

            foreach ($resumo as $item)
            {
                    $descricao_mes = $this->retorna_mes($item->mes);
                    $retorna[] = array("mes" => $descricao_mes, "total" => $item->total_visitantes);
            }

            $resumo = $this->resumo_presencas(($mes-1), $ano); //Mes atual menos 1

            foreach ($resumo as $item)
            {
                    $descricao_mes = $this->retorna_mes($item->mes);
                    $retorna[] = array("mes" => $descricao_mes, "total" => $item->total_visitantes);
            }

            $resumo = $this->resumo_presencas($mes, $ano); //Mes Atual

            foreach ($resumo as $item)
            {
                    $descricao_mes = $this->retorna_mes($item->mes);
                    $retorna[] = array("mes" => $descricao_mes, "total" => $item->total_visitantes);
            }


        }
        else if ($opcao=="frequencia")
        {

                    $retorno = \DB::select('select  fn_total_participantes(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
                    $total_participantes = $retorno[0]->fn_total_participantes;

                    $retorna = array();

                    //ULTIMOS 3 MESES
                    $resumo = $this->resumo_presencas(($mes-2), $ano); //Mes atual menos 2

                    foreach ($resumo as $item)
                    {
                            $retorna[] = array("mes" => ($item->ano . '-' . $item->mes), "total" => ($item->total_visitantes / $total_participantes * 100));
                    }

                    $resumo = $this->resumo_presencas(($mes-1), $ano); //Mes atual menos 1

                    foreach ($resumo as $item)
                    {
                            $retorna[] = array("mes" => ($item->ano . '-' . $item->mes), "total" => ($item->total_visitantes / $total_participantes * 100));
                    }

                    $resumo = $this->resumo_presencas($mes, $ano); //Mes Atual

                    foreach ($resumo as $item)
                    {
                            $retorna[] = array("mes" => ($item->ano . '-' . '08'), "total" => ($item->total_visitantes / $total_participantes * 100));
                    }


        }
        else if ($opcao=="tipo_pessoa")
        {

                    $retorna = array();

                    //ULTIMOS 3 MESES
                    $resumo = $this->resumo_tipo_pessoas($mes, $ano, "Geral");

                    foreach ($resumo as $item)
                    {
                            $retorna[] = array('label' => $item->nome, 'value' => $item->total);
                    }

        }

        return json_encode($retorna);

    }

    protected function retorna_mes($mes) {

        switch ($mes)
        {
                        case 1:
                            $descricao_mes = "Janeiro";
                            break;
                            case 2:
                            $descricao_mes = "Fevereiro";
                            break;
                            case 3:
                            $descricao_mes = "Março";
                            break;
                            case 4:
                            $descricao_mes = "Abril";
                            break;
                            case 5:
                            $descricao_mes = "Maio";
                            break;
                            case 6:
                            $descricao_mes = "Junho";
                            break;
                            case 7:
                            $descricao_mes = "Julho";
                            break;
                            case 8:
                            $descricao_mes = "Agosto";
                            break;
                            case 9:
                            $descricao_mes = "Setembro";
                            break;
                            case 10:
                            $descricao_mes = "Outubro";
                            break;
                            case 11:
                            $descricao_mes = "Novembro";
                            break;
                            case 12:
                            $descricao_mes = "Dezembro";
                            break;

                        default:
                            $descricao_mes="";
                            break;
          }

          return $descricao_mes;

    }

    public function dashboard()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        //Verificar se foi cadastrado os dados da igreja
        if (\App\Models\usuario::find(Auth::user()->id))
        {

            $publicos = \App\Models\publicos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
            $faixas = \App\Models\faixas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

            /*Busca Lideres*/
            $lideres = \DB::select('select * from view_lideres where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

            /*Busca vice - Lideres*/
            $vice_lider = \DB::select('select * from view_vicelideres where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

            $var_download="";
            $var_mensagem="";

            /*Busca Niveis*/
            $view1 = \DB::select('select * from view_celulas_nivel1 v1 where v1.empresas_id = ? and v1.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            $view2 = \DB::select('select * from view_celulas_nivel2 v2 where v2.empresas_id = ? and v2.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            $view3 = \DB::select('select * from view_celulas_nivel3 v3 where v3.empresas_id = ? and v3.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            $view4 = \DB::select('select * from view_celulas_nivel4 v4 where v4.empresas_id = ? and v4.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            $view5 = \DB::select('select * from view_celulas_nivel5 v5 where v5.empresas_id = ? and v5.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

            $retorno = \DB::select('select  fn_total_celulas(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
            $total_celulas = $retorno[0]->fn_total_celulas;

            $retorno = \DB::select('select  fn_total_participantes(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
            $total_participantes = $retorno[0]->fn_total_participantes;

            $celulas_faixas = \DB::select('select * from view_total_celulas_faixa_etaria vw where vw.empresas_id = ? and vw.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            $celulas_publicos = \DB::select('select * from view_total_celulas_publico_alvo vw where vw.empresas_id = ? and vw.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

            $resumo = $this->resumo_presencas(date('m'), date('Y'));

            $resumo_geral = $this->resumo_geral(date('m'), date('Y'));

            $resumo_tipo_pessoas = $this->resumo_tipo_pessoas(date('m'), date('Y'), 'Geral');

            $resumo_perguntas = $this->resumo_perguntas(date('m'), date('Y'));

            //AQUI
            //Busca ID do cliente cloud e ID da empresa
            $this->dados_login = \App\Models\usuario::find(Auth::user()->id);

            //SE for lider, direciona para dashboard da célula
            if ($this->lider_logado!=null)
            {
                $qual_pagina = ".dashboard_lider";
                $participantes_presenca = $this->participantes_presenca();
            } else {
                $qual_pagina = ".dashboard";
                $participantes_presenca = '';
            }


              return view($this->rota . $qual_pagina,
                 [
                  'dados'=>'',
                  'resumo'=>$resumo,
                  'resumo_geral'=>$resumo_geral,
                  'resumo_tipo_pessoas'=>$resumo_tipo_pessoas,
                  'total_celulas'=>$total_celulas,
                  'total_participantes'=>$total_participantes,
                  'celulas_faixas'=>$celulas_faixas,
                  'celulas_publicos'=>$celulas_publicos,
                  'resumo_perguntas'=>$resumo_perguntas,
                  'vice_lider'=>$vice_lider,
                   'nivel1'=>$view1,
                   'nivel2'=>$view2,
                   'nivel3'=>$view3,
                   'nivel4'=>$view4,
                   'nivel5'=>$view5,
                   'publicos'=>$publicos,
                   'faixas'=>$faixas,
                   'lideres'=>$lideres,
                   'var_download'=>'',
                   'var_mensagem'=>'',
                   'participantes_presenca'=> $participantes_presenca
                ]);
        }

    }


   //Return all dates in a month by dayOfWeek
   public function return_dates($id, $var_month, $var_year)
   {

        $var_dayOfWeek = $this->buscar_dados($id); //pega dia do encontro da celula

        $var_counting_days = cal_days_in_month(CAL_GREGORIAN, $var_month, $var_year); //days of month

        $dini = mktime(0,0,0,$var_month,1,$var_year);
        $dfim = mktime(0,0,0,$var_month,$var_counting_days,$var_year);

        $return_d = array();

        while($dini <= $dfim) //Enquanto uma data for inferior a outra
        {
            $dt = date("d/m/Y",$dini); //Convertendo a data no formato dia/mes/ano
            $diasemana = date("w", $dini);

            if($diasemana == $var_dayOfWeek)
            { // [0 Domingo] - [1 Segunda] - [2 Terca] - [3 Quarta] - [4 Quinta] - [5 Sexta] - [6 Sabado]
                array_push($return_d, $dt);
            }

            $dini += 86400; // Adicionando mais 1 dia (em segundos) na data inicial
        }

        return ($return_d);

   }



    //Exibir listagem
    public function index()
    {

            if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
            {
                  return redirect('home');
            }

            $strSql = "SELECT * from view_celulas_simples ";
            $strSql .=  " WHERE  empresas_id = " . $this->dados_login->empresas_id;
            $strSql .=  " AND empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id;

            //SE for lider, direciona para dashboard da célula
            if ($this->lider_logado!=null)
            {
                   $strSql .=  " AND lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
            }

            $dados = \DB::select($strSql);

            //Listagem de pessoas
            return view($this->rota . '.index',compact('dados'));

    }

  public function salvar($request, $id, $tipo_operacao)
  {
        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $this->validate($request, [
            'pessoas' => 'required',
            'dia_encontro' => 'required',
            'horario' => 'required',
        ]);


        if ($tipo_operacao=="create") //novo registro
        {
             $dados = new celulas();
        }
        else //update
        {
             $dados = celulas::findOrfail($id);
        }

         $dados->dia_encontro = $input['dia_encontro'];

         if ($input["horario"]<"12:00") //bom dia
         {
                $dados->turno = "M";
         }
         else if ($input["horario"]>"12:00" && $input["horario"]<"18:00") //boa tarde
         {
                $dados->turno = "T";
         }
         else if ($input["horario"]>"18:00") //boa noite
         {
                $dados->turno = "N";
         }

         //$dados->turno = $input['turno'];
         $dados->regiao = $input['regiao'];
         $dados->horario = $input['horario'];
         $dados->horario2 = $input['horario2'];
         $dados->segundo_dia_encontro = $input['segundo_dia_encontro'];
         $dados->obs = $input['obs'];
         $dados->email_grupo = $input['email_grupo'];
         $dados->faixa_etaria_id = ($input['faixa_etaria']=="" ? null : $input['faixa_etaria']);
         $dados->publico_alvo_id = ($input['publico_alvo']=="" ? null : $input['publico_alvo']);
         $dados->nome = $input['nome'];
         $dados->cor = $input['cor'];
         $dados->data_previsao_multiplicacao = $this->formatador->FormatarData($input["data_previsao_multiplicacao"]);
         $dados->celulas_nivel1_id  = ($input['nivel1']=="" ? null : $input['nivel1']);
         $dados->celulas_nivel2_id  = ($input['nivel2']=="" ? null : $input['nivel2']);
         $dados->celulas_nivel3_id  = ($input['nivel3']=="" ? null : $input['nivel3']);
         $dados->celulas_nivel4_id  = ($input['nivel4']=="" ? null : $input['nivel4']);
         $dados->celulas_nivel5_id  = ($input['nivel5']=="" ? null : $input['nivel5']);
         $dados->lider_pessoas_id  = ($input['pessoas']=="" ? null : substr($input['pessoas'],0,9));
         $dados->vicelider_pessoas_id  = ($input['vicelider_pessoas_id']=="" ? null : substr($input['vicelider_pessoas_id'],0,9));
         $dados->suplente1_pessoas_id  = ($input['suplente1_pessoas_id']=="" ? null : substr($input['suplente1_pessoas_id'],0,9));
         $dados->suplente2_pessoas_id  = ($input['suplente2_pessoas_id']=="" ? null : substr($input['suplente2_pessoas_id'],0,9));
         $dados->empresas_clientes_cloud_id = $this->dados_login->empresas_clientes_cloud_id;
         $dados->empresas_id  = $this->dados_login->empresas_id;
         $dados->celulas_pai_id = ($input['celulas_pai_id']=="" ? null : $input['celulas_pai_id']);
         $dados->origem = ($input['origem']=="" ? null : $input['origem']);

         if (isset($input["endereco_encontro"]))
         {
               $dados->endereco_encontro = ($input['endereco_encontro']=="" ? null : $input['endereco_encontro']);
         }

         if ($input["origem"]=="1")  //Multiplicacao
         {
                $dados->data_multiplicacao = date('Y-m-d');
         }

         $dados->qual_endereco = ($input['local']=="" ? null : $input['local']);

         //Verifique qual endereco sera o encontro conforme selecao do local
         if (isset($input["endereco_encontro"]))
         {
               if ($dados->qual_endereco != "6")
               {
                        switch ($dados->qual_endereco)
                        {
                            case '1': //lider
                                $id_pessoa_endereco = $dados->lider_pessoas_id;
                                break;

                                case '2': //lider em treinamento
                                $id_pessoa_endereco = $dados->vicelider_pessoas_id;
                                break;

                                case '3': //anfitriao
                                $id_pessoa_endereco = $dados->suplente1_pessoas_id;
                                break;

                                case '4': //suplente
                                $id_pessoa_endereco = $dados->suplente2_pessoas_id;
                                break;

                            default:
                                $id_pessoa_endereco = "";
                                break;
                        }

                        if ($dados->qual_endereco=='5') //endereco igreja sede
                        {
                            $pegar_endereco = \App\Models\empresas::select('endereco', 'numero', 'bairro', 'cidade', 'estado', 'complemento')->findOrfail($this->dados_login->empresas_id);
                            $dados->endereco_encontro = $pegar_endereco->endereco . ', ' . $pegar_endereco->numero . ' - ' . $pegar_endereco->bairro . '  ' . $pegar_endereco->complemento;
                        }
                        else
                        {
                            if ($id_pessoa_endereco!="")
                            {
                                    $pegar_endereco = \App\Models\pessoas::select('endereco', 'numero', 'bairro', 'cidade', 'estado', 'complemento')->findOrfail($id_pessoa_endereco);
                                    $dados->endereco_encontro = $pegar_endereco->endereco . ', ' . $pegar_endereco->numero . ' - ' . $pegar_endereco->bairro . '  ' . $pegar_endereco->complemento;
                            }
                        }

               }

         }

         $dados->data_inicio = ($input["data_inicio"]!="" ? $this->formatador->FormatarData($input["data_inicio"]) : date('Y-m-d'));
         $dados->save();
         return  $dados->id;
  }

    //Criar novo registro
    public function create()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        $publicos = \App\Models\publicos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
        $faixas = \App\Models\faixas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
        $celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        $vazio = \App\Models\tabela_vazia::get();

        /*Busca NIVEL5*/
        $view5 = \DB::select('select * from view_celulas_nivel5 v5 where v5.empresas_id = ? and v5.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        //return view($this->rota . '.registrar', ['nivel5'=>$view5, 'publicos'=>$publicos, 'faixas'=>$faixas]);
        return view($this->rota . '.atualizacao', ['participantes'=>'', 'preview'=>'false', 'nivel5'=>$view5, 'publicos'=>$publicos, 'faixas'=>$faixas, 'tipo_operacao'=>'incluir', 'dados'=>$vazio, 'celulas'=>$celulas, 'vinculos'=>$vazio, 'total_vinculos'=>'0']);

    }

/*
* Grava dados no banco
*
*/
    public function store(\Illuminate\Http\Request  $request)
    {
            $id_gerado = $this->salvar($request, "", "create");
            \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

            if ($request["quero_incluir_participante"]=="sim")
            {
                return redirect('celulaspessoas/registrar/' . $id_gerado);
            }
            else
            {
                return redirect($this->rota);
            }

    }

    //Abre tela para edicao ou somente visualização dos registros
    private function exibir ($request, $id, $preview)
    {
        if($request->ajax())
        {
            return URL::to($this->rota . '/'. $id . '/edit');
        }

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        $publicos = \App\Models\publicos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
        $faixas = \App\Models\faixas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

        /*Busca NIVEL5*/
        $view5  = \DB::select('select * from view_celulas_nivel5 v5 where v5.empresas_id = ? and v5.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        /*Busca */
        $celulas = \DB::select('select id, descricao_concatenada as nome, tot from view_celulas_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        /*Busca NIVEL4*/
        $dados = \DB::select("select to_char(to_date(data_previsao_multiplicacao, 'yyyy-MM-dd'), 'DD/MM/YYYY') AS data_previsao_multiplicacao_format, to_char(to_date(data_inicio, 'yyyy-MM-dd'), 'DD/MM/YYYY') AS data_inicio_format, * from view_celulas  where id = ? and empresas_id = ? and empresas_clientes_cloud_id = ? ", [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        $participantes = \DB::select('select * from view_celulas_pessoas where celulas_id = ? and empresas_id = ? and empresas_clientes_cloud_id = ? ', [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        //$dados = \DB::select('select distinct celulas_id, lider_pessoas_id, descricao_lider  as nome, tot from view_celulas_pessoas_participantes where  empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        //Busca celulas filhas
        $vinculos = \DB::select('select * from view_celulas_simples  where celulas_pai_id = ?  and empresas_id = ? and empresas_clientes_cloud_id = ? ', [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        if  ($vinculos==null) //Se nao encontrar, gera controller vazio
        {
            $vinculos = \App\Models\tabela_vazia::get();
            $total_vinculos = 0;
        }
        else
        {
            $temp = \DB::select('select count(*) as tot from view_celulas  where celulas_pai_id = ?  and empresas_id = ? and empresas_clientes_cloud_id = ? ', [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            $total_vinculos =$temp[0]->tot;
        }

        //return view($this->rota . '.edit', ['dados' =>$dados, 'preview' => $preview,  'nivel5' =>$view5, 'publicos'=>$publicos, 'faixas'=>$faixas]);
        return view($this->rota . '.atualizacao', ['participantes'=>$participantes, 'dados' =>$dados, 'preview' => $preview,  'nivel5' =>$view5, 'publicos'=>$publicos, 'faixas'=>$faixas, 'tipo_operacao'=>'editar', 'vinculos'=>$vinculos, 'celulas'=>$celulas, 'total_vinculos'=>$total_vinculos]);

    }

    //Visualizar registro
    public function show (\Illuminate\Http\Request $request, $id)
    {
         return $this->exibir($request, $id, 'true');
    }

    //Direciona para tela de alteracao
    public function edit(\Illuminate\Http\Request $request, $id)
    {
         return $this->exibir($request, $id, 'false');
    }


    /**
     * Atualiza dados no banco
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update(\Illuminate\Http\Request  $request, $id)
    {
           $this->salvar($request, $id,  "update");
           \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

           if ($request["quero_incluir_participante"]=="sim") //quando for edicao com membros ja incluidos
            {
                return redirect('celulaspessoas/' . $id . '/edit');
            }
            else if ($request["quero_incluir_participante"]=="simnovo") //nenhum membro inserido ainda...
            {
                 return redirect('celulaspessoas/registrar/' . $id);
            }
            else //nao quer incluir participante agora
            {
                 return redirect($this->rota);
            }
    }


    /**
     * Excluir registro do banco.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $dados = celulas::findOrfail($id);
            $dados->delete();
            return redirect($this->rota);
    }

}