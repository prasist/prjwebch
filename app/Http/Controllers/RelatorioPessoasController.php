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

class RelatorioPessoasController extends Controller
{

    public function __construct()
    {

        $this->rota = "relpessoas"; //Define nome da rota que será usada na classe
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

        $motivos = \App\Models\tiposmovimentacao::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $tipos = \App\Models\tipospessoas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $situacoes = \App\Models\situacoes::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $status = \App\Models\status::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $estadoscivis = \App\Models\civis::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $grupos = \App\Models\grupospessoas::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->orderBy('nome','ASC')->get();

        /*Busca Nivel1*/
        $view1 = \DB::select('select * from view_celulas_nivel1 v1 where v1.empresas_id = ? and v1.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view2 = \DB::select('select * from view_celulas_nivel2 v2 where v2.empresas_id = ? and v2.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view3 = \DB::select('select * from view_celulas_nivel3 v3 where v3.empresas_id = ? and v3.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view4 = \DB::select('select * from view_celulas_nivel4 v4 where v4.empresas_id = ? and v4.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $view5 = \DB::select('select * from view_celulas_nivel5 v5 where v5.empresas_id = ? and v5.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view($this->rota . '.index', ['nivel1'=>$view1, 'nivel2'=>$view2, 'nivel3'=>$view3, 'nivel4'=>$view4, 'nivel5'=>$view5, 'motivos'=>$motivos, 'tipos'=>$tipos, 'situacoes'=>$situacoes, 'estadoscivis'=>$estadoscivis, 'status'=>$status, 'grupos'=>$grupos]);

    }


  public function pesquisar(\Illuminate\Http\Request  $request)
 {

    include_once(__DIR__ . '/../../../public/relatorios/class/tcpdf/tcpdf.php');
    include_once(__DIR__ . '/../../../public/relatorios/class/PHPJasperXML.inc.php');
    include_once (__DIR__ . '/../../../public/relatorios/setting.php');

    /*Pega todos campos enviados no post*/
    $input = $request->except(array('_token', 'ativo')); //não levar o token

    $PHPJasperXML = new \PHPJasperXML();

    /*Instancia biblioteca de funcoes globais*/
    $formatador = new  \App\Functions\FuncoesGerais();

    $filtros = "";
    $descricao_status="";
    $descricao_tipos="";
    $descricao_estado_civil="";
    $descricao_motivo_ent="";
    $descricao_motivo_sai="";
    $descricao_grupo="";

    if ($input["estadoscivis"]!="") $descricao_estado_civil = explode("|", $input["estadoscivis"]);
    if ($input["tipos"]!="") $descricao_tipos = explode("|", $input["tipos"]);
    if ($input["status_id"]!="") $descricao_status = explode("|", $input["status_id"]);
    if ($input["motivoentrada"]!="") $descricao_motivo_ent = explode("|", $input["motivoentrada"]);
    if ($input["motivosaida"]!="") $descricao_motivo_sai = explode("|", $input["motivosaida"]);
    if ($input["grupo"]!="") $descricao_grupo = explode("|", $input["grupo"]);

    if ($input["status"]!="")  $filtros .= "          Status Cadastro : " . ($input["status"]=="S" ? "Ativo" : "Inativo");
    if ($input["mes"]!="")  $filtros .= "         Mês Aniversário : " . $input["mes"];
    if ($input["sexo"]!="")  $filtros .= "        Sexo : " . ($input["sexo"]=="M" ? "Masculino" : "Feminino");
    if ($descricao_estado_civil!="")  $filtros .= "       Estado Civil : " . $descricao_estado_civil[1];
    if ($descricao_grupo!="")  $filtros .= "         Grupo : " . $descricao_grupo[1];
    if ($descricao_tipos!="")  $filtros .= "          Tipo Pessoa : " . $descricao_tipos[1];
    if ($descricao_status!="")  $filtros .= "         Status : " . $descricao_status[1];
    if ($descricao_motivo_ent!="")  $filtros .= "         Motivo Entrada : " . $descricao_motivo_ent[1];
    if ($descricao_motivo_sai!="")  $filtros .= "         Motivo Saída : " . $descricao_motivo_sai[1];
    if ($input["data_entrada"]!="")  $filtros .= "        Entrada : " . $input["data_entrada"] . " até " . $input["data_entrada_ate"] ;
    if ($input["data_saida"]!="")  $filtros .= "          Saída : " . $input["data_saida"] . " até " . $input["data_saida_ate"] ;
    if ($input["data_batismo"]!="")  $filtros .= "        Batismo : " . $input["data_batismo"] . " até " . $input["data_batismo_ate"] ;

    /*Se for filtrada alguma data, direcionara para relatorio especifico*/
    if ($input["data_entrada"]!="" || $input["data_saida"]!="" || $input["data_batismo"]!="" || $input["motivoentrada"]!="" || $input["motivosaida"]!="")
    {
            $PHPJasperXML->arrayParameter = array
            (
                "empresas_id"=> $this->dados_login->empresas_id,
                "empresas_clientes_cloud_id"=> $this->dados_login->empresas_clientes_cloud_id,
                "status"=>"'" . $input["status"] . "'",
                "mes"=>"'" . $input["mes"] . "'",
                "sexo"=>"'" . $input["sexo"] . "'",
                "estadoscivis"=> ($descricao_estado_civil=="" ? 0 : $descricao_estado_civil[0]),
                "tipos"=> ($descricao_tipos=="" ? 0 : $descricao_tipos[0]),
                "grupo"=> ($descricao_grupo=="" ? 0 : $descricao_grupo[0]),
                "status_id"=> ($descricao_status=="" ? 0 : $descricao_status[0]),
                "motivo_entrada"=> ($descricao_motivo_ent=="" ? 0 : $descricao_motivo_ent[0]),
                "motivo_saida"=> ($descricao_motivo_sai=="" ? 0 : $descricao_motivo_sai[0]),
                "data_entrada_inicial"=>"'" . ($input["data_entrada"]=="" ? '1900/01/01' : $formatador->FormatarData($input["data_entrada"])) . "'",
                "data_entrada_final"=>"'" . ($input["data_entrada_ate"]=="" ? '1900/01/01' : $formatador->FormatarData($input["data_entrada_ate"])) . "'",
                "data_saida_inicial"=>"'" . ($input["data_saida"]=="" ? '1900/01/01' : $formatador->FormatarData($input["data_saida"])) . "'",
                "data_saida_final"=>"'" . ($input["data_saida_ate"]=="" ? '1900/01/01' : $formatador->FormatarData($input["data_saida_ate"])) . "'",
                "data_batismo_inicial"=>"'" . ($input["data_batismo"]=="" ? '1900/01/01' : $formatador->FormatarData($input["data_batismo"])) . "'",
                "data_batismo_final"=>"'" . ($input["data_batismo_ate"]=="" ? '1900/01/01' : $formatador->FormatarData($input["data_batismo_ate"])) . "'",
                "filtros"=> $filtros,
            );

            $PHPJasperXML->load_xml_file(__DIR__ . '/../../../public/relatorios/listagem_pessoas_datas.jrxml');
    }
    else
    {
            $PHPJasperXML->arrayParameter = array
            (
                "empresas_id"=> $this->dados_login->empresas_id,
                "empresas_clientes_cloud_id"=> $this->dados_login->empresas_clientes_cloud_id,
                "status"=>"'" . $input["status"] . "'",
                "mes"=>"'" . $input["mes"] . "'",
                "sexo"=>"'" . $input["sexo"] . "'",
                "grupo"=> ($descricao_grupo=="" ? 0 : $descricao_grupo[0]),
                "estadoscivis"=> ($descricao_estado_civil=="" ? 0 : $descricao_estado_civil[0]),
                "tipos"=> ($descricao_tipos=="" ? 0 : $descricao_tipos[0]),
                "status_id"=> ($descricao_status=="" ? 0 : $descricao_status[0]),
                "filtros"=> $filtros,
            );

            $PHPJasperXML->load_xml_file(__DIR__ . '/../../../public/relatorios/listagem_pessoas.jrxml');
    }

   //$PHPJasperXML->debugsql=true;

    if ($input["nivel5_up"]!="0" || $input["nivel4_up"]!="0" || $input["nivel3_up"]!="0" || $input["nivel2_up"]!="0" || $input["nivel1_up"]!="0")
    {
        //$PHPJasperXML->arrayParameter=array("nivel5"=>"'" . $input["nivel5"] . "'");
    }


    $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db, "psql");
    $PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file

 }

}