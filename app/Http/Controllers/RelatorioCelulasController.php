<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Functions;
use URL;
use Auth;
use Input;
use Gate;

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

    if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
    {
         return redirect('home');
    }

    /*Pega todos campos enviados no post*/
    $input = $request->except(array('_token', 'ativo')); //não levar o token

    $where="";

    if ($input["lideres"]!="")
    {
        $where = "ativo|" . $input["opStatus"] . "&";
    }

    if ($input["opPessoa"]!="")
    {
        if ($where!="")
        {
            $where .= "tipopessoa|" . $input["opPessoa"] . "&";
        }
        else
        {
           $where = "tipopessoa|" . $input["opPessoa"] . "&";
        }
    }


    if ($input["datanasc"]!="")
    {
        if ($where!="")
        {
            $where .= "datanasc|" . $input["datanasc"] . "&";
        }
        else
        {
           $where = "datanasc|" . $input["datanasc"] . "&";
        }
    }

    if ($input["datanasc_ate"]!="")
    {
        if ($where!="")
        {
            $where .= "datanasc_ate|" . $input["datanasc_ate"] . "&";
        }
        else
        {
           $where = "datanasc_ate|" . $input["datanasc_ate"] . "&";
        }
    }


    if ($input["mes"]!="")
    {
        if ($where!="")
        {
            $where .= "mes|" . $input["mes"] . "&";
        }
        else
        {
           $where = "mes|" . $input["mes"] . "&";
        }
    }


    if ($input["razaosocial"]!="")
    {
        if ($where!="")
        {
            $where .= "razaosocial|" . $input["razaosocial"] . "&";
        }
        else
        {
            $where = "razaosocial|" . $input["razaosocial"] . "&";
        }
    }

    if ($input["grupo"]!="")
    {
        if ($where!="")
        {
             $where .= "grupos_pessoas_id|" . $input["grupo"] . "&";
        }
        else
        {
            $where = "grupos_pessoas_id|" . $input["grupo"] . "&";
        }

    }

    if ($input["tipos"]!="")
    {
        if ($where!="")
        {
            $where .= "tipos_pessoas_id|" . $input["tipos"] . "&";
        }
        else
        {
             $where  = "tipos_pessoas_id|" . $input["tipos"] . "&";
        }
     }

    $dados = pessoas::select('pessoas.id', 'pessoas.razaosocial', 'pessoas.nomefantasia', 'pessoas.cnpj_cpf', 'pessoas.fone_principal', 'tipos_pessoas.id as id_tipo_pessoa', 'tipos_pessoas.nome as nome_tipo_pessoa')
        ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->status($status)
        ->pessoa($tipopessoa)
        ->razaosocial($razaosocial)
        ->datanasc($datanasc)
        ->datanascfim($datanasc_ate)
        ->mes($mes)
        ->grupo($grupos_pessoas_id)
        ->tipopessoa($tipos_pessoas_id)
        ->join('tipos_pessoas', 'tipos_pessoas.id', '=' , 'pessoas.tipos_pessoas_id')
        ->orderBy('pessoas.razaosocial')
        ->get();


    return view($this->rota . '.index', ['tipos' => $tipos, 'grupos'=>$grupos, 'where'=>$where, 'visualizar'=>$visualizar, 'alterar'=>$alterar, 'excluir'=>$excluir, 'rota'=>$this->rota]);

 }

}