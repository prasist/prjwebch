<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\celulas_nivel2;
use URL;
use Auth;
use Input;
use Gate;

class Estruturas2Controller extends Controller
{

    public function __construct()
    {

        $this->rota = "estruturas2"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

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

        $dados = celulas_nivel2::select('celulas_nivel2.id', 'celulas_nivel2.nome', 'celulas_nivel1.nome as nome_nivel1',  'celulas_nivel2.celulas_nivel1_id',  'pessoas.razaosocial')
        ->leftjoin('pessoas', 'pessoas.id', '=', 'celulas_nivel2.pessoas_id')
        ->join('celulas_nivel1', 'celulas_nivel2.celulas_nivel1_id', '=', 'celulas_nivel1.id')
        ->where('celulas_nivel2.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('celulas_nivel2.empresas_id', $this->dados_login->empresas_id)
        ->get();

        return view($this->rota . '.index',compact('dados'));

    }

  public function salvar($request, $id, $tipo_operacao)
  {
        $input = $request->except(array('_token', 'ativo')); //não levar o token

        if ($tipo_operacao=="create") //novo registro
        {
             $dados = new celulas_nivel2();
        }
        else //update
        {
             $dados = celulas_nivel2::findOrfail($id);
        }

         $dados->nome = $input['nome'];
         $dados->celulas_nivel1_id  = ($input['nivel1']=="" ? null : $input['nivel1']);
         $dados->pessoas_id  = ($input['pessoa']=="" ? null : $input['pessoa']);
         $dados->empresas_clientes_cloud_id = $this->dados_login->empresas_clientes_cloud_id;
         $dados->empresas_id  = $this->dados_login->empresas_id;
         $dados->save();

  }

    //Criar novo registro
    public function create()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        //Listagem de pessoas
        $pessoas = \App\Models\pessoas::select('pessoas.id', 'pessoas.razaosocial as nome')
        ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->orderBy('razaosocial')
        ->get();

        /*Busca NIVEL1*/
        $sQuery = "select COALESCE(pessoas.razaosocial, celulas_nivel1.nome) as nome, celulas_nivel1.id";
        $sQuery .= " from celulas_nivel1 left join pessoas on celulas_nivel1.pessoas_id = pessoas.id";
        $sQuery .= " where celulas_nivel1.empresas_id = ? ";
        $sQuery .= " and celulas_nivel1.empresas_clientes_cloud_id = ? ";
        $sQuery .= " order by nome";

        $nivel1 = \DB::select($sQuery, [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view($this->rota . '.registrar', ['pessoas'=> $pessoas, 'nivel1'=>$nivel1]);

    }


/*
* Grava dados no banco
*
*/
    public function store(\Illuminate\Http\Request  $request)
    {
            $this->salvar($request, "", "create");
            \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');
            return redirect($this->rota);
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

        //preview = true, somente visualizacao, desabilita botao gravar
        $dados = celulas_nivel2::select('celulas_nivel2.pessoas_id', 'celulas_nivel2.id', 'celulas_nivel2.celulas_nivel1_id', 'celulas_nivel2.nome', 'pessoas.razaosocial')
        ->leftjoin('pessoas', 'pessoas.id', '=', 'celulas_nivel2.pessoas_id')
        ->where('celulas_nivel2.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('celulas_nivel2.empresas_id', $this->dados_login->empresas_id)
        ->where('celulas_nivel2.id', $id)
        ->get();


        /*Busca NIVEL1*/
        $sQuery = "select COALESCE(pessoas.razaosocial, celulas_nivel1.nome) as nome, celulas_nivel1.id";
        $sQuery .= " from celulas_nivel1 left join pessoas on celulas_nivel1.pessoas_id = pessoas.id";
        $sQuery .= " where celulas_nivel1.empresas_id = ? ";
        $sQuery .= " and celulas_nivel1.empresas_clientes_cloud_id = ? ";
        $sQuery .= " order by nome";

        $nivel1 = \DB::select($sQuery, [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        //Listagem de pessoas
        $pessoas = \App\Models\pessoas::select('pessoas.id', 'pessoas.razaosocial as nome')
        ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->orderBy('razaosocial')
        ->get();

        return view($this->rota . '.edit', ['dados' =>$dados, 'preview' => $preview, 'pessoas' => $pessoas, 'nivel1' =>$nivel1] );

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
           return redirect($this->rota);

    }


    /**
     * Excluir registro do banco.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {

            $dados = celulas_nivel2::findOrfail($id);
            $dados->delete();

            return redirect($this->rota);

    }

}