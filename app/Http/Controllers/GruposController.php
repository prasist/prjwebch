<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\clientescloud;
use Amranidev\Ajaxis\Ajaxis;
use URL;
use App\Models\usuario;
use App\Models\grupos;
use Auth;
use Input;
use Validator;

class GruposController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

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

    //
    public function create() {

        return view('grupos.registrar');

    }


/*
* ClientesCloudRequesempresas = Validação de campos
*
*/
    public function store(\Illuminate\Http\Request  $request)
    {

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

    }

    public function show (\Illuminate\Http\Request $request, $id)
    {
            if($request->ajax())
            {
                return URL::to ( 'grupos/'.$id);
            }

            $grupos = grupos::find($id);
            return view('grupos.show',compact('grupos'));
    }

    public function edit(Request $request, $id)
    {
        if($request->ajax())
        {
            return URL::to('grupos/'. $id . '/edit');
        }

        $grupos = grupos::findOrfail($id);
        return view('grupos.edit',compact('grupos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function update(Request  $request, $id)
    {

        /*Validação de campos - request*/
        $this->validate($request, [
                'nome' => 'required|max:45:min:3',

         ]);


        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $grupos = grupos::findOrfail($id);

        $empresas->nome  = $input['nome'];

        \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

        return redirect('grupos');

    }

    /**
     * Delete confirmation message by Ajaxis
     *
     * @link  https://github.com/amranidev/ajaxis
     *
     * @return  String
     */
    public function DeleteMsg(Request $request, $id)
    {
        $msg = Ajaxis::MtDeleting('Aviso!!','Confirma exclusão ?','/grupos/'. $id . '/delete/');

        if($request->ajax())
        {
            return $msg;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grupos = grupos::findOrfail($id);
        $grupos->delete();
        return redirect('grupos');
    }

}