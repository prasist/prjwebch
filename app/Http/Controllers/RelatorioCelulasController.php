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

    public function index()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        $publicos = \App\Models\publicos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
        $faixas = \App\Models\faixas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

        /*Busca Lideres*/
        $lideres = \DB::select('select * from view_lideres where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        /*Busca Nivel5*/
        $view5 = \DB::select('select * from view_celulas_nivel5 v5 where v5.empresas_id = ? and v5.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view($this->rota . '.index', ['nivel5'=>$view5, 'publicos'=>$publicos, 'faixas'=>$faixas, 'lideres'=>$lideres]);

    }


 public function pesquisar(\Illuminate\Http\Request  $request)
 {

    include_once(__DIR__ . '/../../../public/relatorios/class/tcpdf/tcpdf.php');
    include_once(__DIR__ . '/../../../public/relatorios/class/PHPJasperXML.inc.php');
    include_once (__DIR__ . '/../../../public/relatorios/setting.php');

    /*Pega todos campos enviados no post*/
    $input = $request->except(array('_token', 'ativo')); //não levar o token

    $PHPJasperXML = new \PHPJasperXML();

    $PHPJasperXML->arrayParameter = array
    (
        "empresas_id"=> $this->dados_login->empresas_id,
        "empresas_clientes_cloud_id"=> $this->dados_login->empresas_clientes_cloud_id,
        "dia_encontro"=>"'" . $input["dia_encontro"] . "'",
        "regiao"=>"'%" . $input["regiao"] . "%'",
        "turno"=>"'" . $input["turno"] . "'",
        "segundo_dia_encontro"=>"'" . $input["segundo_dia_encontro"] . "'",
        "publico_alvo"=> ($input["publico_alvo"]=="" ? 0 : $input["publico_alvo"]),
        "faixa_etaria"=> ($input["faixa_etaria"]=="" ? 0 : $input["faixa_etaria"]),
        "lideres"=> ($input["lideres"]=="" ? 0 : $input["lideres"]),
        "id"=> 0
    );

    //$PHPJasperXML->debugsql=true;

    if ($input["nivel5"]!="")
    {
        $PHPJasperXML->arrayParameter=array("nivel5"=>"'" . $input["nivel5"] . "'");
    }

    if ($input["nivel4"]!="")
    {
        $PHPJasperXML->arrayParameter=array("nivel4"=>"'" . $input["nivel4"] . "'");
    }

    if ($input["nivel3"]!="")
    {
        $PHPJasperXML->arrayParameter=array("nivel3"=>"'" . $input["nivel3"] . "'");
    }

    if ($input["nivel2"]!="")
    {
        $PHPJasperXML->arrayParameter=array("nivel2"=>"'" . $input["nivel2"] . "'");
    }

    if ($input["nivel1"]!="")
    {
        $PHPJasperXML->arrayParameter=array("nivel1"=>"'" . $input["nivel1"] . "'");
    }

    if ($input["tipo_relatorio"]=="S") //Sintético
    {
      if ($input["ckExibir"]) //Exibir participantes
      {
            $PHPJasperXML->load_xml_file(__DIR__ . '/../../../public/relatorios/listagem_celulas_pessoas.jrxml');
      } else
      {
            $PHPJasperXML->load_xml_file(__DIR__ . '/../../../public/relatorios/listagem_celulas.jrxml');
      }

    }
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

    $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db, "psql");
    $PHPJasperXML->outpage("D");    //page output method I:standard output  D:Download file

 }

}