<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\celulaspessoas;
use URL;
use Auth;
use Input;
use Gate;

class CelulasPessoasController extends Controller
{

    public function __construct()
    {

        $this->rota = "celulaspessoas"; //Define nome da rota que será usada na classe
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

        //$dados = \DB::select('select distinct celulas_id, lider_pessoas_id, descricao_lider  as nome from view_celulas_pessoas where  empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        $dados = \DB::select('select distinct celulas_id, lider_pessoas_id, razaosocial  as nome, tot from view_celulas_pessoas_participantes where  empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view($this->rota . '.index',compact('dados'));

    }

    //Criar novo registro
    public function create()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        /*Busca */
        $celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view($this->rota . '.registrar', ['celulas'=>$celulas]);

    }


public function salvar($request, $id, $tipo_operacao)
{

        //Pega dados do post
        $input = $request->except(array('_token', 'ativo')); //não levar o token

        /*Validação de campos - request*/
        $this->validate($request, [
                'celulas' => 'required',
         ]);

        //Se for alteração, exclui primeiro, para depois percorrer a tabela e inserir novamente
        if ($id!="")
        {
              /*Clausula where padrao para as tabelas auxiliares*/
             $where = ['empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id, 'empresas_id' =>  $this->dados_login->empresas_id, 'celulas_id' => $id];
             $excluir = celulaspessoas::where($where)->delete();
        }


        $i_index=0; /*Inicia sequencia*/

        foreach($input['hidden_celulas'] as $selected)
         {

              $whereForEach =
              [
                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                    'empresas_id' =>  $this->dados_login->empresas_id,
                    'pessoas_id' => substr($input['hidden_pessoas'][$i_index],0,9),
                    'celulas_id' => $selected
              ];

                if ($tipo_operacao=="create")  //novo registro
                {
                    $dados = new celulaspessoas();
                }
                else //Alteracao
                {
                    $dados = celulaspessoas::firstOrNew($whereForEach);
                }

                $valores =
                [
                    'pessoas_id' => substr($input['hidden_pessoas'][$i_index],0,9),
                    'empresas_id' =>  $this->dados_login->empresas_id,
                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                    'celulas_id' => $selected,
                    'lider_pessoas_id' => substr($input['hidden_lider_celulas'][$i_index],0,9)
                ];

                $dados->fill($valores)->save();
                $dados->save();

                $i_index = $i_index + 1;
         }

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


public function imprimir($id)
 {

    include_once(__DIR__ . '/../../../public/relatorios/class/tcpdf/tcpdf.php');
    include_once(__DIR__ . '/../../../public/relatorios/class/PHPJasperXML.inc.php');
    include_once (__DIR__ . '/../../../public/relatorios/setting.php');

    $PHPJasperXML = new \PHPJasperXML();

    $PHPJasperXML->arrayParameter = array
    (
        "empresas_id"=> $this->dados_login->empresas_id,
        "empresas_clientes_cloud_id"=> $this->dados_login->empresas_clientes_cloud_id,
        "dia_encontro"=>"'" . "" . "'",
        "regiao"=>"'%" . "" . "%'",
        "turno"=>"'" . "" . "'",
        "segundo_dia_encontro"=>"'" . "" . "'",
        "publico_alvo"=> 0,
        "faixa_etaria"=> 0,
        "lideres"=> 0,
        "id"=> $id
    );

    //$PHPJasperXML->debugsql=true;
    $PHPJasperXML->load_xml_file(__DIR__ . '/../../../public/relatorios/listagem_celulas_pessoas.jrxml');
    $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db, "psql");
    $PHPJasperXML->outpage("I");    //page output method I:standard output  D:Download file

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

        /*Busca */
        $celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        $dados = \DB::select('select * from view_celulas_pessoas where celulas_id = ? and empresas_id = ? and empresas_clientes_cloud_id = ? ', [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view($this->rota . '.edit', ['dados' =>$dados, 'preview' => $preview, 'celulas'=>$celulas]);

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

         if ($id!="") //Se for alteração, exclui primeiro, para depois percorrer a tabela e inserir novamente
         {

                /*Clausula where padrao para as tabelas auxiliares*/
               $where =
               [
                  'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                  'empresas_id' =>  $this->dados_login->empresas_id,
                  'celulas_id' => $id
               ];

               $excluir = celulaspessoas::where($where)->delete();
         }

         return redirect($this->rota);

    }

}