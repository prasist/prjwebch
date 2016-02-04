<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Amranidev\Ajaxis\Ajaxis;
use URL;
use App\Models\usuario;
use App\Models\grupos;
use Auth;
use Input;
use Validator;

class UsuariosController extends Controller
{
    //


    public function __construct()
    {
        $this->middleware('auth');
    }

    //Exibir listagem dos grupos
    public function index()
    {
       /*
        *    Verificar se foi cadastrado os dados da igreja
        *    Caso encontre, busca somente os dados da empresa que o usuário pertence
        */
        $cadastrou = usuario::find(Auth::user()->id);

        if ($cadastrou)
        {
            $dados = grupos::all()->where('empresas_id', $cadastrou['empresas_id'], 'empresas_clientes_cloud_id', $cadastrou['empresas_clientes_cloud_id']);

            return view('grupos.index',compact('dados'));
        }
        else
        {
            return view('pages.dashboard_blank');  //Ainda nao cadastrou, solicitar o cadastro
        }

    }

    //Criar novo registro
    public function create() {

        return view('grupos.registrar');

    }


/*
* Grava dados no banco
*
*/
    public function store(\Illuminate\Http\Request  $request)
    {

        try {

            /*Validação de campos - request*/
            $this->validate($request, [
                    'nome' => 'required|max:45:min:3',
             ]);

            /*
            *    Verificar se foi cadastrado os dados da igreja
            *    Caso encontre, busca somente os dados da empresa que o usuário pertence
            */
            $cadastrou = usuario::find(Auth::user()->id);

            if ($cadastrou)
            {

                $input = $request->except(array('_token', 'ativo')); //não levar o token

                $grupos = new grupos();

                $grupos->nome  = $input['nome'];
                $grupos->empresas_id  = $cadastrou['empresas_id'];
                $grupos->empresas_clientes_cloud_id  = $cadastrou['empresas_clientes_cloud_id'];
                $grupos->save();

                \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');
            }

            return redirect('grupos');

        } catch (Exception $e) {

            \Session::flash('flash_message', 'Erro : ' . $e);
            return redirect('grupos');

        }

    }

    //Abre tela para edicao ou somente visualização dos registros
    private function exibir ($request, $id, $preview)
    {
        if($request->ajax())
        {
            return URL::to('grupos/'. $id . '/edit');
        }

        //preview = true, somente visualizacao, desabilita botao gravar
        $grupos = grupos::findOrfail($id);
        return view('grupos.edit', ['grupos' =>$grupos, 'preview' => $preview] );

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
                'nome' => 'required|max:45:min:3',

         ]);

        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $grupos = grupos::findOrfail($id);

        $grupos->nome  = $input['nome'];

        $grupos->save();

        \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

        return redirect('grupos');

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

            $grupos = grupos::findOrfail($id);
            $grupos->delete();
            return redirect('grupos');

        } catch (Exception $e) {

            \Session::flash('flash_message_erro', 'Erro ao tentar excluir o registro. Detalhes : ' . $e);
            return redirect('grupos');

        }

    }


}
