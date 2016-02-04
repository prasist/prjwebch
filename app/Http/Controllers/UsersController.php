<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use App\Models\users;
use App\Models\usuario;
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
        $usuarios = users::select ('users.id', 'users.name','usuarios.master')
        ->join('usuarios', 'usuarios.id' , '=' , 'users.id')
        ->where('users.id', Auth::user()->id)
        ->get();

        return view('usuarios.index', compact('usuarios'));

    }

    //Criar novo registro
    public function create() {

        $cadastrou = usuario::find(Auth::user()->id);

        $dados  = \App\Models\grupos::select('grupos.id', 'grupos.nome')
        ->where('grupos.empresas_id', $cadastrou['empresas_id'])
        ->where('grupos.empresas_clientes_cloud_id', $cadastrou['empresas_clientes_cloud_id'])
        ->get();

        return view('usuarios.registrar', compact('dados'));

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

            //Grava novo usuario (Tabela USERS)
            $dados = new users();
            $dados->name  = $input['name'];
            $dados->email  = $input['email'];
            $dados->password  = bcrypt($input['password']);
            $dados->save();
            //

            //Pega dados do usuarios admin (id da empresa e cliente cloud)
            $usuario_master = usuario::find(Auth::user()->id);

            //cria registro na tabela usuarios para associar com a tabela users
            $usuarios = new usuario();
            $usuarios->id                                           =   $dados->id;    //id recem cadastrado na tabela users
            $usuarios->empresas_id                          =  $usuario_master['empresas_id']; //Pegar ID do registro recém criado (clientes_cloud)
            $usuarios->empresas_clientes_cloud_id  =  $usuario_master['empresas_clientes_cloud_id'];
            $usuarios->master = 0; //Criada a empresa a primeira vez, o usuario que cadastrou será o master e nao podera ser removido
            $usuarios->save();

            //Grava Grupo que o usuário iŕa pertencer
            $grupo_usuario = new usuarios_grupo();
            $grupo_usuario->usuarios_id = $dados->id;
            $grupo_usuario->usuarios_empresas_id = $usuario_master['empresas_id'];
            $grupo_usuario->usuarios_empresas_clientes_cloud_id = $usuario_master['empresas_clientes_cloud_id'];
            $grupo_usuario->grupos_id = $input['grupo'];
            $grupo_usuario->save();


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
                'email' => 'required|email|max:255',
                'password' => 'required|confirmed|min:6',
         ]);

        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $dados = users::findOrfail($id);

        $dados->name  = $input['name'];
        $dados->email  = $input['email'];
        $dados->password  = bcrypt($input['password']);

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
