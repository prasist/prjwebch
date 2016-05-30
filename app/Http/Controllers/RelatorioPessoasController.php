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

    public function CarregarView($var_download)
    {

        $ramos = \App\Models\ramos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $cargos = \App\Models\cargos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $profissoes = \App\Models\profissoes::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $graus = \App\Models\graus::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $idiomas = \App\Models\idiomas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
        $formacoes = \App\Models\areas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
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

        return view($this->rota . '.index',
            [
                'nivel1'=>$view1,
                'nivel2'=>$view2,
                'nivel3'=>$view3,
                'nivel4'=>$view4,
                'nivel5'=>$view5,
                'motivos'=>$motivos,
                'ramos'=>$ramos,
                'cargos'=>$cargos,
                'profissoes'=>$profissoes,
                'graus'=>$graus,
                'idiomas'=>$idiomas,
                'formacoes'=>$formacoes,
                'tipos'=>$tipos,
                'situacoes'=>$situacoes,
                'estadoscivis'=>$estadoscivis,
                'status'=>$status,
                'grupos'=>$grupos,
                'emails'=>'', 'filtros'=>'',
                'var_download' => $var_download
                ]);
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

    /*Pega todos campos enviados no post*/
    $input = $request->except(array('_token', 'ativo')); //não levar o token

    /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/
    //Pega dados de conexao com o banco para o JASPER REPORT
    $database = \Config::get('database.connections.jasper_report');
    $ext = $input["resultado"]; //Tipo saída (PDF, XLS)
    $output = public_path() . '/relatorios/resultados/' . $ext . '/relatorio_' . $this->dados_login->empresas_id . '_' . Auth::user()->id; //Path para cada tipo de relatorio
    $path_download = '/relatorios/resultados/' . $ext . '/relatorio_' . $this->dados_login->empresas_id . '_' .  Auth::user()->id; //Path para cada tipo de relatorio
    /*------------------------------------------INICIALIZA PARAMETROS JASPER--------------------------------------------------*/

    /*Instancia biblioteca de funcoes globais*/
    $formatador = new  \App\Functions\FuncoesGerais();

    $filtros = "";
    $descricao_status="";
    $descricao_situacoes="";
    $descricao_tipos="";
    $descricao_estado_civil="";
    $descricao_motivo_ent="";
    $descricao_motivo_sai="";
    $descricao_grupo="";
    $descricao_nivel1="";
    $descricao_nivel2="";
    $descricao_nivel3="";
    $descricao_nivel4="";
    $descricao_nivel5="";
    $descricao_idiomas="";
    $descricao_graus="";
    $where="";

    if ($input["situacoes"]!="") $descricao_situacoes = explode("|", $input["situacoes"]);
    if ($input["estadoscivis"]!="") $descricao_estado_civil = explode("|", $input["estadoscivis"]);
    if ($input["tipos"]!="") $descricao_tipos = explode("|", $input["tipos"]);
    if ($input["status_id"]!="") $descricao_status = explode("|", $input["status_id"]);
    if ($input["idiomas_id"]!="") $descricao_idiomas = explode("|", $input["idiomas_id"]);
    if ($input["graus_id"]!="") $descricao_graus = explode("|", $input["graus_id"]);
    if ($input["motivoentrada"]!="") $descricao_motivo_ent = explode("|", $input["motivoentrada"]);
    if ($input["motivosaida"]!="") $descricao_motivo_sai = explode("|", $input["motivosaida"]);
    if ($input["grupo"]!="") $descricao_grupo = explode("|", $input["grupo"]);
    if ($input["nivel1_up"]!="") $descricao_nivel1 = explode("|", $input["nivel1_up"]);
    if ($input["nivel2_up"]!="") $descricao_nivel2 = explode("|", $input["nivel2_up"]);
    if ($input["nivel3_up"]!="") $descricao_nivel3 = explode("|", $input["nivel3_up"]);
    if ($input["nivel4_up"]!="") $descricao_nivel4 = explode("|", $input["nivel4_up"]);
    if ($input["nivel5_up"]!="") $descricao_nivel5 = explode("|", $input["nivel5_up"]);


    $where = " where empresas_id = " . $this->dados_login->empresas_id . "  and empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " and (emailprincipal is not null and emailprincipal<> '') ";

    /*Filtros utilizados*/
    if ($input["possui_necessidades_especiais"]!="")
    {
        $filtros .= "   Possui Necessidades Esp.: " . ($input["possui_necessidades_especiais"]=="1" ? "Sim" : "Não");
        $where .= " and possui_necessidades_especiais = " . ($input["possui_necessidades_especiais"]=="true" ? "true" : "false");
    }

    if ($input["doador_orgaos"]!="")
    {
        $filtros .= "   Doador Orgãos: " . ($input["doador_orgaos"]=="1" ? "Sim" : "Não");
        $where .= " and doador_orgaos = " . ($input["doador_orgaos"]=="1" ? "true" : "false");
    }

    if ($input["doador_sangue"]!="")
    {
        $filtros .= "   Doador Sangue : " . ($input["doador_sangue"]=="1" ? "Sim" : "Não");
        $where .= " and doador_sangue = " . ($input["doador_sangue"]=="1" ? "true" : "false");
    }

    if ($input["status"]!="")
    {
        $filtros .= "   Status Cadastro : " . ($input["status"]=="S" ? "Ativo" : "Inativo");
        $where .= " and ativo = '" . $input["status"] . "'";
    }

    if ($input["graus_id"]!="")
    {
        $filtros .= "   Grau Instrução : " . $descricao_graus[1];
        $where .= " and graus_id = " . $descricao_graus[0];
    }

    if ($input["idiomas_id"]!="")
    {
        $filtros .= "   Idioma : " . $descricao_idiomas[1];
        $where .= " and idiomas_id = " . $descricao_idiomas[0];
    }

    if ($input["mes"]!="")
    {
        $filtros .= "   Mes Aniversario : " . $input["mes"];
        $where .= " and mes = '" . $input["mes"] . "'";
    }

    if ($input["sexo"]!="")
    {
        $filtros .= "   Sexo : " . ($input["sexo"]=="M" ? "Masculino" : "Feminino");
        $where .= " and sexo = '" . $input["sexo"] . "'";
    }

    if ($descricao_estado_civil!="")
    {
        $filtros .= "   Estado Civil : " . $descricao_estado_civil[1];
        $where .= " and estadoscivis_id = " . $descricao_estado_civil[0];
    }

    if ($descricao_grupo!="")
    {
        $filtros .= "   Grupo : " . $descricao_grupo[1];
        $where .= " and grupos_pessoas_id = " . $descricao_grupo[0];
    }

    if ($descricao_situacoes!="")
    {
        $filtros .= "   Situação : " . $descricao_situacoes[1];
        $where .= " and situacoes_id = " . $descricao_situacoes[0];
    }

    if ($descricao_tipos!="")
    {
        $filtros .= "   Tipo Pessoa : " . $descricao_tipos[1];
        $where .= " and tipos_pessoas_id = " . $descricao_tipos[0];
    }

    if ($descricao_status!="")
    {
        $filtros .= "   Status : " . $descricao_status[1];
        $where .= " and status_id = " . $descricao_status[0];
    }

    if ($descricao_motivo_ent!="")
    {
        $filtros .= "   Motivo Entrada : " . $descricao_motivo_ent[1];
        $where .= " and motivos_entrada_id = " . $descricao_motivo_ent[0];
    }

    if ($descricao_motivo_sai!="")
    {
        $filtros .= "   Motivo Saída : " . $descricao_motivo_sai[1];
        $where .= " and motivos_saida_id = " . $descricao_motivo_sai[0];
    }

    if ($input["data_entrada"]!="")
    {
        $filtros .= "   Entrada : " . $input["data_entrada"] . " até " . $input["data_entrada_ate"] ;
        $where .= " and data_entrada >= '" . $formatador->FormatarData($input["data_entrada"]) . "'";
        $where .= " and data_entrada <= '" . $formatador->FormatarData($input["data_entrada_ate"]) . "'";
    }

    if ($input["data_saida"]!="")
    {
        $filtros .= "   Saída : " . $input["data_saida"] . " até " . $input["data_saida_ate"] ;
        $where .= " and data_saida >= '" . $formatador->FormatarData($input["data_saida"]) . "'";
        $where .= " and data_saida < '" . $formatador->FormatarData($input["data_saida_ate"]) . "'";
    }

    if ($input["data_batismo"]!="")
    {
        $filtros .= "   Batismo : " . $input["data_batismo"] . " até " . $input["data_batismo_ate"] ;
        $where .= " and data_batismo >= '" . $formatador->FormatarData($input["data_batismo"]) . "'";
        $where .= " and data_batismo <= '" . $formatador->FormatarData($input["data_batismo_ate"]) . "'";
    }

    if ($input["nivel1_up"]!="0")
    {
        $filtros .= "<br/>" . \Session::get('nivel1') . " : " . $descricao_nivel1[1];
        $where .= " and celulas_nivel1_id = " . $descricao_nivel1[0];
    }

    if ($input["nivel2_up"]!="0")
    {
        $filtros .= "" . \Session::get('nivel2') . " : " . $descricao_nivel2[1];
        $where .= " and celulas_nivel2_id = " . $descricao_nivel2[0];
    }

    if ($input["nivel3_up"]!="0")
    {
        $filtros .= "<br/>" . \Session::get('nivel3') . " : " . $descricao_nivel3[1];
        $where .= " and celulas_nivel3_id = " . $descricao_nivel3[0];
    }

    if ($input["nivel4_up"]!="0")
    {
        $filtros .= "" . \Session::get('nivel4') . " : " . $descricao_nivel4[1];
        $where .= " and celulas_nivel4_id = " . $descricao_nivel4[0];
    }

    if ($input["nivel5_up"]!="0")
    {
        $filtros .= "" . \Session::get('nivel5') . " : " . $descricao_nivel5[1];
        $where .= " and celulas_nivel5_id = " . $descricao_nivel5[0];
    }


    //Parametros JASPER REPORT
    $parametros = array
    (
        "empresas_id"=> $this->dados_login->empresas_id,
        "empresas_clientes_cloud_id"=> $this->dados_login->empresas_clientes_cloud_id,
        "sexo"=>"'" . $input["sexo"] . "'",
        "mes"=>"'" . $input["mes"] . "'",
        "status"=>"'" . $input["status"] . "'",
        "nivel1"=> ($descricao_nivel1=="" ? 0 : $descricao_nivel1[0]),
        "nivel2"=> ($descricao_nivel2=="" ? 0 : $descricao_nivel2[0]),
        "nivel3"=> ($descricao_nivel3=="" ? 0 : $descricao_nivel3[0]),
        "nivel4"=> ($descricao_nivel4=="" ? 0 : $descricao_nivel4[0]),
        "nivel5"=> ($descricao_nivel5=="" ? 0 : $descricao_nivel5[0]),
        "doador_sangue" => ($input["doador_sangue"]=="1" ? "true" : "false"),
        "doador_orgaos" => ($input["doador_orgaos"]=="1" ? "true" : "false"),
        "possui_necessidades_especiais" => ($input["possui_necessidades_especiais"]==true ? "true" : "false"),
        "idiomas_id" => ($descricao_idiomas=="" ? 0 : $descricao_idiomas[0]),
        "graus_id" => ($descricao_graus=="" ? 0 : $descricao_graus[0]),
        "estadoscivis"=> ($descricao_estado_civil=="" ? 0 : $descricao_estado_civil[0]),
        "situacoes"=> ($descricao_situacoes=="" ? 0 : $descricao_situacoes[0]),
        "tipos"=> ($descricao_tipos=="" ? 0 : $descricao_tipos[0]),
        "grupo"=> ($descricao_grupo=="" ? 0 : $descricao_grupo[0]),
        "status_id"=> ($descricao_status=="" ? 0 : $descricao_status[0]),
        "motivo_entrada"=> ($descricao_motivo_ent=="" ? 0 : $descricao_motivo_ent[0]),
        "motivo_saida"=> ($descricao_motivo_sai=="" ? 0 : $descricao_motivo_sai[0]),
        "data_entrada_inicial"=>"'" . ($input["data_entrada"]=="" ? '' : $formatador->FormatarData($input["data_entrada"])) . "'",
        "data_entrada_final"=>"'" . ($input["data_entrada_ate"]=="" ? '' : $formatador->FormatarData($input["data_entrada_ate"])) . "'",
        "filtros"=> "'" . ($filtros) . "'",
    );

    //A ordem DEFAULT do relatório é DIA/MES da data de nascimento. Se não for relatório de aniversariantes, altera a ordem
    if ($input["ordem"]=="razaosocial")
    {
        $parametros = array_add($parametros, 'ordem', 'razaosocial');
    }
    else if ($input["ordem"]=="idade")
    {
        $parametros = array_add($parametros, 'ordem', 'idade');
    }

    /*Se foi passado filtro por ano de nascimento*/
    if ($input["ano_inicial"]!="" && $input["ano_final"]!="")
    {
        $parametros = array_add($parametros, 'ano_inicial', $input["ano_inicial"]);
        $parametros = array_add($parametros, 'ano_final', $input["ano_final"]);
    }


    if ($input["resultado"]=="email")
    {
        $emails = \DB::select('select distinct razaosocial, emailprincipal from view_pessoas_geral_celulas' . $where . ' order by razaosocial');
        return view($this->rota . '.listaremails', ['emails'=>$emails, 'filtros'=>$filtros]);
    }
     else
    {
        /*Exibir quebras por estrutura de celulas*/
            if ($input["ckEstruturas"])
            {
                if ($descricao_situacoes!="")
                {
                    $nome_relatorio = public_path() . '/relatorios/listagem_pessoas_geral_celulas_situacoes.jasper';
                }
                else
                {
                    $nome_relatorio = public_path() . '/relatorios/listagem_pessoas_geral_celulas.jasper';
                }

            }
            else
            {
                if ($descricao_situacoes!="")
                {
                    $nome_relatorio = public_path() . '/relatorios/listagem_pessoas_geral_situacoes.jasper';
                }
                else
                {

                    if ($input["ordem"]!="razaosocial" || $input["mes"]!="" || $input["ano_inicial"]!="" || $input["ano_final"]!="")
                    {
                        $nome_relatorio = public_path() . '/relatorios/listagem_aniversariantes.jasper';
                    }
                    else
                    {
                        $nome_relatorio = public_path() . '/relatorios/listagem_pessoas_geral.jasper';
                    }
                }
            }

            //Executa JasperReport
            \JasperPHP::process(
                    $nome_relatorio,
                    $output,
                    array($ext),
                    $parametros,
                    $database,
                    false,
                    false
                )->execute();

             //Recarrega a tela com o link do relatorio gerado
             return $this->CarregarView($path_download . '.' . $ext);

    }

 }

}