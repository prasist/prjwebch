<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Functions;
use URL;
use Auth;
use Input;
use Gate;
use JasperPHP\JasperPHP as JasperPHP;

class RelatorioCelulasController extends Controller
{

    public function __construct()
    {

        $this->rota = "relcelulas"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }

    }


 public function CarregarView($var_download, $var_mensagem)
{

        $publicos = \App\Models\publicos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
        $faixas = \App\Models\faixas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

        /*Busca Lideres*/
        $lideres = \DB::select('select * from view_lideres where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        /*Busca vice - Lideres*/
        $vice_lider = \DB::select('select * from view_vicelideres where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);


        /*Busca Niveis*/
        $view1 = \DB::select('select * from view_celulas_nivel1 v1 where v1.empresas_id = ? and v1.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view2 = \DB::select('select * from view_celulas_nivel2 v2 where v2.empresas_id = ? and v2.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view3 = \DB::select('select * from view_celulas_nivel3 v3 where v3.empresas_id = ? and v3.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view4 = \DB::select('select * from view_celulas_nivel4 v4 where v4.empresas_id = ? and v4.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view5 = \DB::select('select * from view_celulas_nivel5 v5 where v5.empresas_id = ? and v5.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view($this->rota . '.index', ['vice_lider'=>$vice_lider, 'nivel1'=>$view1, 'nivel2'=>$view2, 'nivel3'=>$view3, 'nivel4'=>$view4, 'nivel5'=>$view5, 'publicos'=>$publicos, 'faixas'=>$faixas, 'lideres'=>$lideres, 'var_download' => $var_download, 'var_mensagem'=>$var_mensagem]);

}

public function index()
{

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        return $this->CarregarView('','');

}

//RELATORIO DE ENCONTROS E CELULAS
public function pesquisar(\Illuminate\Http\Request  $request, $tipo_relatorio)
{

    /*Pega todos campos enviados no post*/
    $input = $request->except(array('_token', 'ativo')); //não levar o token

    /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/
    //Pega dados de conexao com o banco para o JASPER REPORT
    $database = \Config::get('database.connections.jasper_report');
    $ext = $input["resultado"]; //Tipo saída (PDF, XLS)
    $output = public_path() . '/relatorios/resultados/' . $ext . '/celulas_' . $this->dados_login->empresas_id . '_' . Auth::user()->id; //Path para cada tipo de relatorio
    $path_download = '/relatorios/resultados/' . $ext . '/celulas_' . $this->dados_login->empresas_id . '_' .  Auth::user()->id; //Path para cada tipo de relatorio
    /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/

    $filtros = "";
    $descricao_publico_alvo="";
    $descricao_faixa_etaria="";
    $descricao_lider="";
    $descricao_vice_lider="";
    $descricao_nivel1="";
    $descricao_nivel2="";
    $descricao_nivel3="";
    $descricao_nivel4="";
    $descricao_nivel5="";

    if (isset($input["publico_alvo"]))
    {
         if ($input["publico_alvo"]!="") $descricao_publico_alvo = explode("|", $input["publico_alvo"]);
         if ($descricao_publico_alvo[0]!="0")  $filtros .= "     Publico Alvo : " . $descricao_publico_alvo[1];
     }

    if (isset($input["faixa_etaria"])) {
        if ($input["faixa_etaria"]!="") $descricao_faixa_etaria = explode("|", $input["faixa_etaria"]);
        if ($descricao_faixa_etaria[0]!="0")  $filtros .= "     Faixa Etaria : " . $descricao_faixa_etaria[1];
    }

    if (isset($input["lideres"]))
        if ($input["lideres"]!="") $descricao_lider = explode("|", $input["lideres"]);

    if (isset($input["vice_lider"]))
    {
        if ($input["vice_lider"]!="") $descricao_vice_lider = explode("|", $input["vice_lider"]);
        if ($descricao_vice_lider[0]!="0")  $filtros .= "     Lider em Treinamento: " . $descricao_vice_lider[1];
    }

    if (isset($input["nivel1_up"]))
        if ($input["nivel1_up"]!="") $descricao_nivel1 = explode("|", $input["nivel1_up"]);

    if (isset($input["nivel2_up"]))
        if ($input["nivel2_up"]!="") $descricao_nivel2 = explode("|", $input["nivel2_up"]);

    if (isset($input["nivel3_up"]))
        if ($input["nivel3_up"]!="") $descricao_nivel3 = explode("|", $input["nivel3_up"]);

    if (isset($input["nivel4_up"]))
        if ($input["nivel4_up"]!="") $descricao_nivel4 = explode("|", $input["nivel4_up"]);

    if (isset($input["nivel5_up"]))
        if ($input["nivel5_up"]!="") $descricao_nivel5 = explode("|", $input["nivel5_up"]);

    $sDiaEncontro = "";

    if (isset($input["dia_encontro"])) {
        switch ($input["dia_encontro"]) {
                case '1':
                $sDiaEncontro = "Segunda-Feira";
                break;

                case '2':
                $sDiaEncontro = "Terca-Feira";
                break;

                case '3':
                $sDiaEncontro = "Quarta-Feira";
                break;

                case '4':
                $sDiaEncontro = "Quinta-Feira";
                break;

                case '5':
                $sDiaEncontro = "Sexta-Feira";
                break;

                case '6':
                $sDiaEncontro = "Sabado";
                break;

                case '0':
                $sDiaEncontro = "Domingo";
                break;

            default:
                $sDiaEncontro = "";
                break;
        }
    }


    if ($tipo_relatorio=="celulas") //SE FOR RELATORIO DE CELULAS
    {
        if ($input["dia_encontro"]!="")  $filtros .= "      Dia Encontro : " . $sDiaEncontro;
        if ($input["turno"]!="")  $filtros .= "         Turno : " . $input["turno"];
        if ($input["segundo_dia_encontro"]!="")  $filtros .= "      Segundo dia encontro : " . $input["segundo_dia_encontro"];
    }
    else //RELATORIO DE ENCONTROS
    {
        $filtros .= "     Mes : " . $input["mes"];
        $filtros .= "     Ano : " . $input["ano"];
    }

    if (isset($input["qtd_inicial"]))
        if ($input["qtd_inicial"]!="")  $filtros .= "        Qtd. Multiplicacoes Inicial : " . $input["qtd_inicial"];

    if (isset($input["qtd_final"]))
        if ($input["qtd_final"]!="")  $filtros .= "        Qtd. Multiplicacoes Final : " . $input["qtd_final"];

    if (isset($input["regiao"]))
        if ($input["regiao"]!="")  $filtros .= "        Regiao : " . $input["regiao"];

    if ($descricao_lider[0]!="0")  $filtros .= "     Lider : " . $descricao_lider[1];

    if (isset($input["nivel1_up"]))
        if ($input["nivel1_up"]!="0")  $filtros .= "        " . \Session::get('nivel1') . " : " . $descricao_nivel1[1];

    if (isset($input["nivel2_up"]))
        if ($input["nivel2_up"]!="0")  $filtros .= "        " . \Session::get('nivel2') . " : " . $descricao_nivel2[1];

    if (isset($input["nivel3_up"]))
        if ($input["nivel3_up"]!="0")  $filtros .= "        " . \Session::get('nivel3') . " : " . $descricao_nivel3[1];

    if (isset($input["nivel4_up"]))
        if ($input["nivel4_up"]!="0")  $filtros .= "        " . \Session::get('nivel4') . " : " . $descricao_nivel4[1];

    if (isset($input["nivel5_up"]))
        if ($input["nivel5_up"]!="0")  $filtros .= "        " . \Session::get('nivel5') . " : " . $descricao_nivel5[1];

    $parametros = array
    (
        "empresas_id"=> $this->dados_login->empresas_id,
        "empresas_clientes_cloud_id"=> $this->dados_login->empresas_clientes_cloud_id,
        "lideres"=> ($descricao_lider=="" ? 0 : $descricao_lider[0]),
        "filtros"=> "'" . ($filtros) . "'"
    );


    if (isset($input["qtd_inicial"]))
    {
            $parametros = array_add($parametros, 'qtd_inicial', ($input["qtd_inicial"]=="" ? 0 : $input["qtd_inicial"]));
    }

    if (isset($input["qtd_final"]))
    {
            $parametros = array_add($parametros, 'qtd_final', ($input["qtd_final"]=="" ? 0 : $input["qtd_final"]));
    }

    if (isset($input["publico_alvo"]))
    {
        if ($input["publico_alvo"]!="0")
            $parametros = array_add($parametros, 'publico_alvo', ($descricao_publico_alvo[0]=="" ? 0 : $descricao_publico_alvo[0]));
    }

    if (isset($input["faixa_etaria"]))
    {
        if ($input["faixa_etaria"]!="0")
            $parametros = array_add($parametros, 'faixa_etaria', ($descricao_faixa_etaria[0]=="" ? 0 : $descricao_faixa_etaria[0]));
    }

    if (isset($input["regiao"]))
    {
        if ($input["regiao"]!="")
            $parametros = array_add($parametros, 'regiao', $input["regiao"] . '%');
    }


    //PARAMETROS
    $parametros = array_add($parametros, 'nivel1', ($descricao_nivel1=="" ? 0 : $descricao_nivel1[0]));
    $parametros = array_add($parametros, 'nivel2', ($descricao_nivel2=="" ? 0 : $descricao_nivel2[0]));
    $parametros = array_add($parametros, 'nivel3', ($descricao_nivel3=="" ? 0 : $descricao_nivel3[0]));
    $parametros = array_add($parametros, 'nivel4', ($descricao_nivel4=="" ? 0 : $descricao_nivel4[0]));
    $parametros = array_add($parametros, 'nivel5', ($descricao_nivel5=="" ? 0 : $descricao_nivel5[0]));

    if (isset($input["mes"]))
    {
        if ($input["mes"]!="")
        {
            $parametros = array_add($parametros, 'mes', $input["mes"]);
        }
    }

    if (isset($input["ano"]))
    {
        if ($input["ano"]!="")
        {
            $parametros = array_add($parametros, 'ano', $input["ano"]);
        }
    }

 /*
    RELATORIOS E SUAS VIEWS
    listagem_celulas => view_celulas_completo
    listagem_celulas_pessoas_analitico => view_celulas_pessoas
    listagem_celulas_pessoas_niveis => view_celulas_pessoas_niveis
    listagem_celulas_sintetico => view_celulas_niveis
 */

   if ($tipo_relatorio=="celulas")  //Relatorio de celulas
   {
        $parametros = array_add($parametros, 'segundo_dia_encontro', $input["segundo_dia_encontro"]);
        $parametros = array_add($parametros, 'turno', $input["turno"]);
        $parametros = array_add($parametros, 'dia_encontro', $input["dia_encontro"] );
        $parametros = array_add($parametros, 'id', 0);


            if ($input["tipo"]=="S") //Sintetico, nao listar endereco, fone e email
            {
                $parametros = array_add($parametros, 'exibir_dados_lider', 'N');
            }


            if ($input["ckExibirDadosParticipantes"]=="")
            {
                $parametros = array_add($parametros, 'exibir_dados', 'N');
            }

            if ($descricao_vice_lider[0]!="0")
            {
                $parametros = array_add($parametros, 'vice_lider', $descricao_vice_lider[0]);
            }

            //if ($input["tipo_relatorio"]=="S") //Sintético
            //{
              if ($input["ckExibir"]) //Exibir participantes
              {
                    if ($input["ckEstruturas"])
                    {
                        //$PHPJasperXML->load_xml_file(__DIR__ . '/../../../public/relatorios/listagem_celulas_pessoas_niveis.jrxml');
                        $nome_relatorio = public_path() . '/relatorios/listagem_celulas_pessoas_niveis.jasper';
                    }
                    else
                    {
                        //$PHPJasperXML->load_xml_file(__DIR__ . '/../../../public/relatorios/listagem_celulas_pessoas.jrxml');
                        //$nome_relatorio = public_path() . '/relatorios/listagem_celulas_pessoas.jasper';
                        $nome_relatorio = public_path() . '/relatorios/listagem_celulas_pessoas_analitico.jasper';
                    }

              } else
              {
                    if ($input["ckEstruturas"])
                    {
                        //$PHPJasperXML->load_xml_file(__DIR__ . '/../../../public/relatorios/listagem_celulas_pessoas_niveis_sintetico.jrxml');
                        //$nome_relatorio = public_path() . '/relatorios/listagem_celulas_pessoas_niveis_sintetico.jasper';
                        $nome_relatorio = public_path() . '/relatorios/listagem_celulas_sintetico.jasper';
                    }
                    else
                    {
                         //$PHPJasperXML->load_xml_file(__DIR__ . '/../../../public/relatorios/listagem_celulas.jrxml');
                         $nome_relatorio = public_path() . '/relatorios/listagem_celulas.jasper';
                    }
              }

   }
   else //RELATORIO ENCONTROS
   {

        $parametros = array_add($parametros, 'SUBREPORT_DIR', public_path() . '/relatorios/');

        //se houver logo informada
        if (rtrim(ltrim(\Session::get('logo')))!="")
        {
            $parametros = array_add($parametros, 'path_logo', public_path() . '/images/clients/' . \Session::get('logo'));
        }

        if ($input["ckExibir"]=="on") //Exibir PARTICIPANTES
        {
               $nome_relatorio = public_path() . '/relatorios/relatorio_encontro.jasper';
        }
        else
        {
                $nome_relatorio = public_path() . '/relatorios/relatorio_encontro_resumo_geral_lider2.jasper';
        }

   }


    \JasperPHP::process(
            $nome_relatorio,
            $output,
            array($ext),
            $parametros,
            $database,
            false,
            false
        )->execute();



            $Mensagem="";

            if (filesize($output . '.' . $ext)<=1000) //Se arquivo tiver menos de 1k, provavelmente está vazio...
            {

                $Mensagem = "Nenhum Registro Encontrado";
                if ($tipo_relatorio=="celulas")  {
                    return $this->CarregarView('', $Mensagem);
                } else {
                    return redirect('relencontro');
                }

            }
                else
            {

                if ($ext=="pdf") //Se for pdf abre direto na pagina
                {

                    header('Content-Description: File Transfer');
                    header('Content-Type: application/pdf');
                    header('Content-Disposition: inline; filename=' . $output .' . ' . $ext . '');
                    //header('Content-Transfer-Encoding: binary');
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Content-Length: ' . filesize($output.'.'.$ext));
                    flush();
                    readfile($output.'.'.$ext);
                    unlink($output.'.'.$ext);
                }
                else //Gera link para download
                {
                    return $this->CarregarView($path_download . '.' . $ext, $Mensagem);
                }
            }


 }

 //Relatorios estatisticos : Batismos, Multiplicacao, Geral

    protected function imprimir($tipo_relatorio, $nivel, $valor, $mes, $ano, $nome, $saida)
    {

         /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/
        //Pega dados de conexao com o banco para o JASPER REPORT
        $database = \Config::get('database.connections.jasper_report');
        $ext = $saida; //Tipo saída (PDF, XLS)
        $output = public_path() . '/relatorios/resultados/' . $ext . '/estatisticas_' . $this->dados_login->empresas_id . '_' . Auth::user()->id; //Path para cada tipo de relatorio
        $path_download = '/relatorios/resultados/' . $ext . '/estatisticas_' . $this->dados_login->empresas_id . '_' .  Auth::user()->id; //Path para cada tipo de relatorio
        /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/

        $filtros="";

        if ($mes!="")
             $filtros .= "Mes : " . $mes;

        if ($ano!="")
             $filtros .= "          Ano : " . $ano;

        //Se foi informado algum nivel da estrutura
        if ($nome!="")
             $filtros .= "          " . \Session::get('nivel' . $nivel) . " : " . $nome;


        $parametros = array
        (
            "empresas_id"=> $this->dados_login->empresas_id,
            "empresas_clientes_cloud_id"=> $this->dados_login->empresas_clientes_cloud_id,
            "filtros"=> "'" . ($filtros) . "'"
        );

        //se foi passado nivel, filtra por estrutura da rede
        if (isset($nivel))
        {
            $parametros = array_add($parametros, 'nivel' . $nivel, $valor);
        }

        switch ($tipo_relatorio) {
            case 1: //Resumo Geral
                $nome_relatorio = public_path() . '/relatorios/total_celulas_anual.jasper';
                break;

           case 2: //Batismos Anual
                $nome_relatorio = public_path() . '/relatorios/total_batismos.jasper';
                $parametros = array_add($parametros, 'ano_inicial', (date("Y")-4));
                $parametros = array_add($parametros, 'ano_final', date("Y"));
                break;

            case 3: //Batismos Mensal
                $nome_relatorio = public_path() . '/relatorios/total_batismos_mensal.jasper';
                $parametros = array_add($parametros, 'ano_inicial', date("Y"));
                $parametros = array_add($parametros, 'ano_final', date("Y"));
                break;

            case 4: //Multiplicacoes ano a ano
                $nome_relatorio = public_path() . '/relatorios/total_multiplicacao_anual.jasper';
                $parametros = array_add($parametros, 'ano_inicial', (date("Y")-4));
                $parametros = array_add($parametros, 'ano_final', date("Y"));
                break;

           case 5: //Multiplicacoes mensal
                $nome_relatorio = public_path() . '/relatorios/total_multiplicacao_mensal.jasper';
                $parametros = array_add($parametros, 'ano_inicial', date("Y"));
                $parametros = array_add($parametros, 'ano_final', date("Y"));
                break;

            default:
                # code...
                break;
        }


        \JasperPHP::process(
                $nome_relatorio,
                $output,
                array($ext),
                $parametros,
                $database,
                false,
                false
            )->execute();

                $Mensagem="";

                if (filesize($output . '.' . $ext)<=1000) //Se arquivo tiver menos de 1k, provavelmente está vazio...
                {

                    $Mensagem = "Nenhum Registro Encontrado";
                    if ($tipo_relatorio=="celulas")  {
                        return $this->CarregarView('', $Mensagem);
                    } else {
                        return redirect('dashboard_celulas');
                    }

                }
                    else
                {

                    if ($ext=="pdf") //Se for pdf abre direto na pagina
                    {

                        header('Content-Description: File Transfer');
                        header('Content-Type: application/pdf');
                        header('Content-Disposition: inline; filename=' . $output .' . ' . $ext . '');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                        header('Content-Length: ' . filesize($output.'.'.$ext));
                        flush();
                        readfile($output.'.'.$ext);
                        unlink($output.'.'.$ext);
                    }
                    else //Gera link para download
                    {
                        //return $this->CarregarView($path_download . '.' . $ext, $Mensagem);
                        return redirect('home');
                    }
                }

    }

    public function estatisticas(\Illuminate\Http\Request  $request, $tipo_relatorio)
    {

            $this->imprimir($tipo_relatorio, '', '', '', '', '');

     }

    public function estatisticas_nivel(\Illuminate\Http\Request  $request, $tipo_relatorio, $nivel, $valor, $nome, $saida)
    {

            $this->imprimir($tipo_relatorio, $nivel, $valor, '', '', $nome, $saida);

    }


    public function estatisticas_batismos(\Illuminate\Http\Request  $request, $tipo_relatorio, $nivel, $valor, $mes, $ano, $nome, $saida)
    {

            $this->imprimir($tipo_relatorio, $nivel, $valor, $mes, $ano, $nome, $saida);

    }

}