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
use DB;

class PermissoesGrupoController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $cadastrou = usuario::find(Auth::user()->id);

            if ($cadastrou)
            {
                  $dados  = grupos::select('grupos.id', 'grupos.nome')
                  ->where('grupos.empresas_id', $cadastrou['empresas_id'])
                  ->where('grupos.empresas_clientes_cloud_id', $cadastrou['empresas_clientes_cloud_id'])
                  ->get();

                  $paginas = paginas::select('id', 'nome')
                  ->where('nao_mostrar_todos', '0')
                  ->get();

                   return view('permissoes.index', ['dados'=>$dados, 'paginas'=>$paginas]);
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

                  $paginas = paginas::select('id','nome')
                  ->where('nao_mostrar_todos', '0')
                  ->get();

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

                   }
            }

            \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

        }

        return redirect('permissoes');

    }

    //Abre tela para visualização ou edição, conforme parametro preview (true ou false)
   private function exibir ($request, $id, $preview)
   {

        if($request->ajax())
        {
            return URL::to('permissoes/'. $id . '/edit');
        }

            $cadastrou = usuario::find(Auth::user()->id);

            if ($cadastrou)
            {
                  $dados  = grupos::select('grupos.id', 'grupos.nome')
                  ->where('grupos.empresas_id', $cadastrou['empresas_id'])
                  ->where('grupos.empresas_clientes_cloud_id', $cadastrou['empresas_clientes_cloud_id'])
                  ->get();

                  $sql = "select id, nome from grupos where
                  empresas_id = " . $cadastrou['empresas_id'] . " and
                  empresas_clientes_cloud_id = " . $cadastrou['empresas_clientes_cloud_id'] . " and
                  id = " . $id . "";
                  $dados = DB::select($sql);


                  /* Lista todas as páginas e marca o checkbox conforme permissao concedida na tabela permissoes_grupos*/
                  $sql = "select pg.id as id_permissoes, pg.grupos_id, p.id, p.nome, pg.incluir, pg.alterar, pg.excluir, pg.visualizar, pg.exportar, pg.imprimir, pg.acessar
                  from paginas p left join permissoes_grupos pg on (p.id = pg.paginas_id) and (pg.grupos_id = " . $id . " or pg.grupos_id is null
                  where (paginas.nao_mostrar_todos = 0)";

                  $paginas = DB::select($sql);

                  return view('permissoes.edit', ['dados'=>$dados, 'paginas'=>$paginas, 'preview' => $preview]);

            }

   }

   //Somente visualização (preview=true)
   public function show (\Illuminate\Http\Request $request, $id)
   {

        return $this->exibir($request, $id, 'true');

   }

   //Edição registros (preview=false)
   public function edit(\Illuminate\Http\Request $request, $id)
   {

        return $this->exibir($request, $id, 'false');

   }

    /**
     * Update the specified resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function update(\Illuminate\Http\Request  $request)
    {

        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $paginas_array     = $input['pagina'];

        $incluir_array     =  $input['incluir'];
        $alterar_array    =  $input['alterar'];
        $excluir_array    =  $input['excluir'];
        $visualizar_array = $input['visualizar'];
        $exportar_array  = $input['exportar'];
        $imprimir_array  = $input['imprimir'];
        $acessar_array   = $input['acessar'];

            if(is_array($paginas_array))
            {
                   foreach ($paginas_array as $key => $value) {

                            //$permissoes = new \App\Models\permissoes_gfinrupo();
                            $permissoes = \App\Models\permissoes_grupo::firstOrNew(['grupos_id'  => $input['nome'], 'paginas_id' => $value]);

                            $valores = [
                                        'incluir'        => $incluir_array[$key],
                                        'alterar'       => $alterar_array[$key],
                                        'excluir'       => $excluir_array[$key],
                                        'visualizar'   => $visualizar_array[$key],
                                        'acessar'     => $acessar_array[$key],
                                        'exportar'    => $exportar_array[$key],
                                        'imprimir'    => $imprimir_array[$key]
                                        ];

                            $permissoes->fill($valores)->save();

                            $permissoes->save();

                   }

            }


        \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

        return redirect('permissoes');

    }



    /**
     * Exclusão registro
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grupos = permissoes_grupo::findOrfail($id);
        $grupos->delete();
        return redirect('permissoes');
    }

}