<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use Auth;
use Input;
use Gate;

class MinhaCelulaController extends Controller
{

    public function __construct()
    {

        $this->rota = "minhacelula"; //Define nome da rota que será usada na classe
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

        $dados = atividades::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

        return view($this->rota . '.index',compact('dados'));

    }

    //Criar novo registro
    public function create()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        return view($this->rota . '.registrar');

    }


/*
* Grava dados no banco
*
*/
    public function enviar(\Illuminate\Http\Request  $request)
    {

            /*Validação de campos - request*/
            $this->validate($request, [
                    'mensagem' => 'required',
                    'telefone' => 'required',
            ]);

           $input = $request->except(array('_token', 'ativo')); //não levar o token


           $urlMensagem = "http://177.70.4.6/plataforma/api5.php?usuario=fabianosigma&senha=h4ck3r1423&destinatario=" . $input["telefone"] . "&msg=" . urlencode($input["mensagem"]);

          /*
          $url = $urlMensagem;
          $ch = curl_init($url);
          curl_setopt($ch, CURLOPT_TIMEOUT, 10);
          curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $data = curl_exec($ch);
          curl_close($ch);
          echo $data;
          echo $urlMensagem;
          dd('fim');
          */

          $api_http = file_get_contents($urlMensagem);
          echo $api_http;
          dd('fin');

/*
          $url = $urlMensagem;
          $ch = curl_init();
          curl_setopt ($ch, CURLOPT_URL, $url);
          curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
          curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
          $contents = curl_exec($ch);
          if (curl_errno($ch)) {
             echo curl_error($ch);
             echo "\n<br />";
             $contents = '';
          } else {
            curl_close($ch);
          }

          echo $contents;

          echo "fim";
          */


          \Session::flash('flash_message', $response);

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
        $dados = atividades::findOrfail($id);
        return view($this->rota . '.edit', ['dados' =>$dados, 'preview' => $preview] );

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
                'nome' => 'required|max:60:min:3',
         ]);

        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $dados = atividades::findOrfail($id);
        $dados->nome  = $input['nome'];
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

            $dados = atividades::findOrfail($id);
            $dados->delete();

            return redirect($this->rota);

    }

}