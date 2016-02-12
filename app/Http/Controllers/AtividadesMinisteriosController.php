<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\atividadesministerios;
use App\Models\ministerios;
use URL;
use Auth;
use Input;
use Gate;

class AtividadesMinisteriosController extends Controller
{

    public function __construct()
    {

        $this->rota = "atividadesministerios"; //Define nome da rota que será usada na classe
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

        $dados = atividadesministerios::select('ministerios.nome as nome_ministerio', 'atividades_ministerio.id', 'atividades_ministerio.nome', 'atividades_ministerio.ministerios_id')
        ->join('ministerios', 'atividades_ministerio.ministerios_id', '=', 'ministerios.id' )
        ->where('ministerios_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

        return view($this->rota . '.index',compact('dados'));

    }

    //Criar novo registro
    public function create()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        $dados  = ministerios::all();

        return view($this->rota . '.registrar', compact('dados'));

    }


/*
* Grava dados no banco
*
*/
    public function store(\Illuminate\Http\Request  $request)
    {

          $input = $request->except(array('_token', 'ativo')); //não levar o token

          $id_ministerio                  = $input['ministerio'];
          $array_areasministerio   = $input['nome'];

          if(is_array($array_areasministerio))
          {
                 foreach ($array_areasministerio as $key => $value)
                 {

                          if ($value!="")
                          {
                              $dados = new atividadesministerios();

                              $dados->ministerios_id    = $id_ministerio;
                              $dados->ministerios_clientes_cloud_id   = $this->dados_login->empresas_clientes_cloud_id;
                              $dados->nome                = $value;
                              $dados->save();
                        }

                 }
          }

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


        $ministerios = atividadesministerios::select('ministerios.nome', 'ministerios.id')
        ->join('ministerios', 'atividades_ministerio.ministerios_id', '=', 'ministerios.id' )
        ->where('atividades_ministerio.ministerios_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('atividades_ministerio.id', $id)
        ->get();

        //preview = true, somente visualizacao, desabilita botao gravar
        $dados = atividadesministerios::findOrfail($id);
        return view($this->rota . '.edit', ['dados' =>$dados, 'preview' => $preview, 'ministerios'=> $ministerios] );

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

          $input = $request->except(array('_token', 'ativo')); //não levar o token

          $dados = atividadesministerios::firstOrNew(['id' => $id]);

          //$valores = ['nome' => $input['nome']];

          $dados->nome = $input['nome'];
          //$dados->fill($valores)->save();
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
    public function destroy($id)
    {

            $dados = atividadesministerios::findOrfail($id);
            $dados->delete();

            return redirect($this->rota);

    }

}