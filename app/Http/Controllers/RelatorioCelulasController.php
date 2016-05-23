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

    public function CarregarView($var_download)
    {

        $publicos = \App\Models\publicos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
        $faixas = \App\Models\faixas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

        /*Busca Lideres*/
        $lideres = \DB::select('select * from view_lideres where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        /*Busca Niveis*/
        $view1 = \DB::select('select * from view_celulas_nivel1 v1 where v1.empresas_id = ? and v1.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view2 = \DB::select('select * from view_celulas_nivel2 v2 where v2.empresas_id = ? and v2.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view3 = \DB::select('select * from view_celulas_nivel3 v3 where v3.empresas_id = ? and v3.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view4 = \DB::select('select * from view_celulas_nivel4 v4 where v4.empresas_id = ? and v4.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view5 = \DB::select('select * from view_celulas_nivel5 v5 where v5.empresas_id = ? and v5.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view($this->rota . '.index', ['nivel1'=>$view1, 'nivel2'=>$view2, 'nivel3'=>$view3, 'nivel4'=>$view4, 'nivel5'=>$view5, 'publicos'=>$publicos, 'faixas'=>$faixas, 'lideres'=>$lideres, 'var_download' => $var_download]);

    }

    public function index()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        return $this->CarregarView('');

    }


 public function pesquisar(\Illuminate\Http\Request  $request)
 {

    //include_once(__DIR__ . '/../../../public/relatorios/class/tcpdf/tcpdf.php');
    //include_once(__DIR__ . '/../../../public/relatorios/class/PHPJasperXML.inc.php');
    //include_once (__DIR__ . '/../../../public/relatorios/setting.php');

    /*Pega todos campos enviados no post*/
    $input = $request->except(array('_token', 'ativo')); //não levar o token

    //$PHPJasperXML = new \PHPJasperXML();

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
    $descricao_nivel1="";
    $descricao_nivel2="";
    $descricao_nivel3="";
    $descricao_nivel4="";
    $descricao_nivel5="";


    if ($input["publico_alvo"]!="") $descricao_publico_alvo = explode("|", $input["publico_alvo"]);
    if ($input["faixa_etaria"]!="") $descricao_faixa_etaria = explode("|", $input["faixa_etaria"]);
    if ($input["lideres"]!="") $descricao_lider = explode("|", $input["lideres"]);
    if ($input["nivel1_up"]!="") $descricao_nivel1 = explode("|", $input["nivel1_up"]);
    if ($input["nivel2_up"]!="") $descricao_nivel2 = explode("|", $input["nivel2_up"]);
    if ($input["nivel3_up"]!="") $descricao_nivel3 = explode("|", $input["nivel3_up"]);
    if ($input["nivel4_up"]!="") $descricao_nivel4 = explode("|", $input["nivel4_up"]);
    if ($input["nivel5_up"]!="") $descricao_nivel5 = explode("|", $input["nivel5_up"]);

    if ($input["dia_encontro"]!="")  $filtros .= "      Dia Encontro : " . $input["dia_encontro"];
    if ($input["regiao"]!="")  $filtros .= "        Região : " . $input["regiao"];
    if ($input["turno"]!="")  $filtros .= "         Turno : " . $input["turno"];
    if ($input["segundo_dia_encontro"]!="")  $filtros .= "      Segundo dia encontro : " . $input["segundo_dia_encontro"];
    if ($descricao_publico_alvo!="")  $filtros .= "     Publico Alvo : " . $descricao_publico_alvo[1];
    if ($descricao_faixa_etaria!="")  $filtros .= "     Faixa Etária : " . $descricao_faixa_etaria[1];
    if ($descricao_lider[0]!="0")  $filtros .= "     Líder : " . $descricao_lider[1];
    if ($input["nivel1_up"]!="0")  $filtros .= "        " . \Session::get('nivel1') . " : " . $descricao_nivel1[1];
    if ($input["nivel2_up"]!="0")  $filtros .= "        " . \Session::get('nivel2') . " : " . $descricao_nivel2[1];
    if ($input["nivel3_up"]!="0")  $filtros .= "        " . \Session::get('nivel3') . " : " . $descricao_nivel3[1];
    if ($input["nivel4_up"]!="0")  $filtros .= "        " . \Session::get('nivel4') . " : " . $descricao_nivel4[1];
    if ($input["nivel5_up"]!="0")  $filtros .= "        " . \Session::get('nivel5') . " : " . $descricao_nivel5[1];

    $parametros = array
    (
        "empresas_id"=> $this->dados_login->empresas_id,
        "empresas_clientes_cloud_id"=> $this->dados_login->empresas_clientes_cloud_id,
        "dia_encontro"=>"'" . $input["dia_encontro"] . "'",
        "regiao"=>"'%" . $input["regiao"] . "%'",
        "turno"=>"'" . $input["turno"] . "'",
        "segundo_dia_encontro"=>"'" . $input["segundo_dia_encontro"] . "'",
        "publico_alvo"=> ($input["publico_alvo"]=="" ? 0 : $input["publico_alvo"]),
        "faixa_etaria"=> ($input["faixa_etaria"]=="" ? 0 : $input["faixa_etaria"]),
        "lideres"=> ($descricao_lider=="" ? 0 : $descricao_lider[0]),
        "nivel1"=> ($descricao_nivel1=="" ? 0 : $descricao_nivel1[0]),
        "nivel2"=> ($descricao_nivel2=="" ? 0 : $descricao_nivel2[0]),
        "nivel3"=> ($descricao_nivel3=="" ? 0 : $descricao_nivel3[0]),
        "nivel4"=> ($descricao_nivel4=="" ? 0 : $descricao_nivel4[0]),
        "nivel5"=> ($descricao_nivel5=="" ? 0 : $descricao_nivel5[0]),
        "filtros"=> "'" . ($filtros) . "'",
        "id"=> 0
    );

    //$PHPJasperXML->debugsql=true;


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
                $nome_relatorio = public_path() . '/relatorios/listagem_celulas_pessoas.jasper';
            }

      } else
      {
            if ($input["ckEstruturas"])
            {
                //$PHPJasperXML->load_xml_file(__DIR__ . '/../../../public/relatorios/listagem_celulas_pessoas_niveis_sintetico.jrxml');
                $nome_relatorio = public_path() . '/relatorios/listagem_celulas_pessoas_niveis_sintetico.jasper';
            }
            else
            {
                 //$PHPJasperXML->load_xml_file(__DIR__ . '/../../../public/relatorios/listagem_celulas.jrxml');
                 $nome_relatorio = public_path() . '/relatorios/listagem_celulas.jasper';
            }
      }

    //}

    /*
    else //Analítico
    {
        if ($input["ckExibir"]) //Exibir participantes
        {
            $PHPJasperXML->load_xml_file(__DIR__ . '/../../../public/relatorios/listagem_pessoas_celulas_analitico.jrxml');
        }
        else
        {
            $PHPJasperXML->load_xml_file(__DIR__ . '/../../../public/relatorios/listagem_celulas_modelo2.jrxml');
        }

    }
*/

    //$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db, "psql");
    //$PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file


    \JasperPHP::process(
            $nome_relatorio,
            $output,
            array($ext),
            $parametros,
            $database,
            false,
            false
        )->execute();

     /*Gera link para abrir o relatório*/
     return $this->CarregarView($path_download . '.' . $ext);


 }

}