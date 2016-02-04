<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use App\Models\users;
use Auth;
use Input;
use Validator;

class UsersController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    //Exibir listagem dos grupos
    public function index()
    {

        //$usuarios = users::find(Auth::user()->id);
        $usuarios = users::select ('id', 'name')
        ->where('id', Auth::user()->id)
        ->get();

        return view('usuarios.index', compact('usuarios'));

    }

    //Criar novo registro
    public function create() {

        return view('usuarios.registrar');

    }


/*
* Grava dados no banco
*
*/
    public function store(\Illuminate\Http\Request  $request)
    {

            /*Validação de campos - request*/
            $this->validate($request, [
                   'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|confirmed|min:6',
             ]);

            $input = $request->except(array('_token', 'ativo')); //não levar o token

            $grupos = new users();

            $grupos->nome  = $input['nome'];
            $grupos->empresas_id  = $cadastrou['empresas_id'];
            $grupos->empresas_clientes_cloud_id  = $cadastrou['empresas_clientes_cloud_id'];
            $grupos->save();

            \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

            return redirect('usuarios');

    }

    //Abre tela para edicao ou somente visualização dos registros
    private function exibir ($request, $id, $preview)
    {
        if($request->ajax())
        {
            return URL::to('usuarios/'. $id . '/edit');
        }

        //preview = true, somente visualizacao, desabilita botao gravar
        $dados = users::findOrfail($id);
        return view('usuarios.edit', ['dados' =>$dados, 'preview' => $preview] );

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

       /*Validação de campos - request*/
        $this->validate($request, [
               'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6',
         ]);

        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $dados = users::findOrfail($id);

        $dados->nome  = $input['nome'];

        $dados->save();

        \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

        return redirect('usuarios');

    }


    /**
     * Excluir registro do banco.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {

            $dados = users::findOrfail($id);
            $dados->delete();
            return redirect('usuarios');

        } catch (Exception $e) {

            \Session::flash('flash_message_erro', 'Erro ao tentar excluir o registro. Detalhes : ' . $e);
            return redirect('usuarios');

        }

    }


}
