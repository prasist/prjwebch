<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\clientescloud;
use Amranidev\Ajaxis\Ajaxis;
use URL;
use App\Models\usuario;
use App\Models\grupos;
use App\Models\usuarios_grupo;
use App\Models\paginas;
use Auth;
use Input;
use Validator;

class PermissoesGrupoController extends Controller
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

          $dados  = usuarios_grupo::Join('grupos', 'grupos.id', '=', 'usuarios_grupo.grupos_id')
          ->select('grupos.id', 'grupos.nome', 'grupos.default')
          ->where('usuarios_grupo.usuarios_id', $cadastrou['id'])
          ->get();

            return view('permissoes.index',compact('dados'));
        }
        else
        {
            return view('pages.dashboard_blank');  //Ainda nao cadastrou, solicitar o cadastro
        }

    }

   //
   public function create()
   {

            $cadastrou = usuario::find(Auth::user()->id);

            if ($cadastrou)
            {
                  $dados  = grupos::select('grupos.id', 'grupos.nome')
                  ->where('grupos.empresas_id', $cadastrou['empresas_id'])
                  ->where('grupos.empresas_clientes_cloud_id', $cadastrou['empresas_clientes_cloud_id'])
                  ->get();

                  $paginas = paginas::all();

                   return view('permissoes.registrar', ['dados'=>$dados, 'paginas'=>$paginas]);
            }
            else
            {
                  return view('pages.dashboard_blank');  //Ainda nao cadastrou, solicitar o cadastro
            }

   }

/*
* ClientesCloudRequesempresas = Validação de campos
*
*/
    public function store(\Illuminate\Http\Request  $request)
    {
        /*
        *    Verificar se foi cadastrado os dados da igreja
        *    Caso encontre, busca somente os dados da empresa que o usuário pertence
        */
        $cadastrou = usuario::find(Auth::user()->id);

        if ($cadastrou)
        {

            $input = $request->except(array('_token', 'ativo')); //não levar o token

            $paginas_array     = $input['pagina'];
            $incluir_array        = $input['incluir'];
            $alterar_array       = $input['alterar'];
            $excluir_array       = $input['excluir'];
            $visualizar_array   = $input['visualizar'];
            $exportar_array    = $input['exportar'];
            $imprimir_array    = $input['imprimir'];

            if(is_array($paginas_array))
            {
                   foreach ($paginas_array as $key => $value) {

                            /*echo $input['nome'];
                            echo "<br/>";
                            echo "pag : " . $value;
                            echo "<br/>";
                            echo "incluir " . (isset($incluir_array[$value]) ? 1 : 0);
                            echo "<br/>";
*/
                            $permissoes = new \App\Models\permissoes_grupo();


                            $permissoes->grupos_id    = $input['nome'];
                            $permissoes->paginas_id   = $value;
                            $permissoes->incluir          = (isset($incluir_array[$key]) ? 1 : 0);
                            $permissoes->alterar         = (isset($alterar_array[$key]) ? 1 : 0);
                            $permissoes->excluir         = (isset($excluir_array[$key]) ? 1 : 0);
                            $permissoes->visualizar     = (isset($visualizar_array[$key]) ? 1 : 0);
                            $permissoes->acessar       = (isset($acessar_array[$key]) ? 1 : 0);
                            $permissoes->exportar      = (isset($exportar_array[$key]) ? 1 : 0);
                            $permissoes->imprimir      = (isset($imprimir_array[$key]) ? 1 : 0);

                            $permissoes->save();

                            //echo "indice : " . $key . " valor : " . $value . " = " . (isset($incluir_array[$key]) ? 1 : 0) . "<br/>";

                   }
            }

           // dd($input);

            \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');
        }

        return redirect('permissoes');

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
            return URL::to('permissoes/'. $id . '/edit');
        }

        $permissoes  = usuarios_grupo::join('permissoes_grupos', 'permissoes_grupos.grupos_id', '=', 'usuarios_grupo.grupos_id')
        ->join('paginas', 'paginas.id', '=', 'permissoes_grupos.paginas_id')
        ->select('paginas.id as id_pagina', 'paginas.nome', 'permissoes_grupos.incluir', 'permissoes_grupos.alterar')
        ->where('usuarios_grupo.grupos_id', $id)
        ->distinct()->get();

        $grupos = usuarios_grupo::join('grupos', 'usuarios_grupo.grupos_id', '=', 'grupos.id')
        ->select('grupos.id as id_grupo', 'grupos.nome', 'grupos.default')
        ->where('grupos.id', $id)
        ->distinct()->first();

        //$temp =  compact('grupos');
        dd(compact('permissoes'));
        //dd($temp['grupos']->id_grupo);

        return view('permissoes.edit',['grupos'=>compact('grupos'),'permissoes'=> compact('permissoes')]);
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