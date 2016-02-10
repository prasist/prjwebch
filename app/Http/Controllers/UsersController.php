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
use Gate;

class UsersController extends Controller
{
    //

    public function __construct()
    {

        $this->middleware('auth');

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.usuarios'),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }

    }

    //Exibir listagem dos grupos
    public function index()
    {
        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.usuarios'))==false)
        {
              return redirect('home');
        }

        $usuarios = users::select ('users.id', 'users.name', 'users.email', 'usuarios.master', 'empresas.razaosocial')
        ->join('usuarios', 'usuarios.id' , '=' , 'users.id')
        ->join('empresas', 'empresas.id' , '=' , 'usuarios.empresas_id')
       // ->where('usuarios.empresas_id', $this->dados_login->empresas_id)
        ->where('usuarios.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->get();

        return view('usuarios.index', compact('usuarios'));

    }

    //Criar novo registro
    public function create()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.usuarios'))==false)
        {
              return redirect('home');
        }

        $dados  = \App\Models\grupos::select('grupos.id', 'grupos.nome')
        ->where('grupos.empresas_id', $this->dados_login->empresas_id)
        ->where('grupos.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->get();

        $empresas = \App\Models\empresas::select('empresas.id', 'empresas.razaosocial')
        ->where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->get();

        return view('usuarios.registrar', ['dados' => $dados, 'empresas'=>$empresas]);

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
                   'empresa' => 'required',
                   'grupo' => 'required',
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
            $usuarios->empresas_id                          =  $input['empresa'];
            $usuarios->empresas_clientes_cloud_id  =  $usuario_master['empresas_clientes_cloud_id'];
            $usuarios->master = 0; //Criada a empresa a primeira vez, o usuario que cadastrou será o master e nao podera ser removido
            $usuarios->save();

            //Grava Grupo que o usuário iŕa pertencer
            $grupo_usuario = new \App\Models\usuarios_grupo();
            $grupo_usuario->usuarios_id = $dados->id;
            $grupo_usuario->usuarios_empresas_id = $input['empresa'];
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

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.usuarios'))==false)
        {
              return redirect('home');
        }

        //Pega dados do grupo do usuario cadastrado
        $grupo_do_usuario = \App\Models\usuarios_grupo::select('usuarios_grupo.grupos_id' , 'usuarios_grupo.usuarios_empresas_id', 'usuarios_grupo.usuarios_empresas_clientes_cloud_id')
        ->join('grupos', 'grupos.id', '=', 'usuarios_grupo.grupos_id')
        ->where('usuarios_id', $id)
        ->get();

        //Todos grupos da empresa
        $grupos = \App\Models\grupos::select('id', 'nome')
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->get();

        //preview = true, somente visualizacao, desabilita botao gravar
        $dados = users::findOrfail($id);

        //Todas igrejas/instituições pertencentes a igreja sede
        $empresas = \App\Models\empresas::select('id', 'razaosocial')
        ->where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->get();

        return view('usuarios.edit', ['dados' =>$dados, 'preview' => $preview, 'grupos'=>$grupos, 'empresas'=>$empresas, 'grupo_do_usuario' =>$grupo_do_usuario]);

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

       //Atualizar tabela USUARIOS_GRUPO
        $where = ['usuarios_empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id, 'usuarios_id' => $id];

        $update = \DB::table('usuarios_grupo')->where($where)
           ->update(array(
                        'usuarios_empresas_id'    =>  $input['empresa'],
                        'grupos_id'    => $input['grupo']));

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

            //Apaga tabela USERS
            $dados = users::findOrfail($id);
            $dados->delete();


            //Apaga tabela USUARIOS_GRUPO
            $where = [
            'usuarios_empresas_id' => $this->dados_login->empresas_id,
            'usuarios_empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
            'usuarios_id' => $id];

            \DB::table('usuarios_grupo')->where($where)->delete();

            //Apaga tabela USUARIOS
            $where = [
            'empresas_id' => $this->dados_login->empresas_id,
            'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
            'id' => $id];

            \DB::table('usuarios')->where($where)->delete();

            return redirect('usuarios');

        } catch (Exception $e) {

            \Session::flash('flash_message_erro', 'Erro ao tentar excluir o registro. Detalhes : ' . $e);
            return redirect('usuarios');

        }

    }


}
