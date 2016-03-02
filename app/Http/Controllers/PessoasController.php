<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\pessoas;
use URL;
use Auth;
use Input;
use Gate;

class PessoasController extends Controller
{

    public function __construct()
    {

        $this->rota = "pessoas"; //Define nome da rota que será usada na classe
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

        $tipos = \App\Models\tipospessoas::where('clientes_cloud_id', $this->dados_login->clientes_cloud_id)->get();

        $dados = pessoas::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

        return view($this->rota . '.index',compact('dados'));

    }

    //Criar novo registro
    public function create($id)
    {

       if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
       {
              return redirect('home');
       }

        $dados = \App\Models\grupospessoas::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->get();

        return view($this->rota . '.registrar', compact('dados'));

    }


/*
* Grava dados no banco
*
*/
    public function store(\Illuminate\Http\Request  $request)
    {

        /*Validação de campos - request*/
        $this->validate($request, [
                'razaosocial' => 'required|max:255:min:3',
                'foneprincipal' => 'required|min:10',
                'emailprincipal' => 'email',
                'emailsecundario' => 'email',
         ]);

        $image = $request->file('caminhologo');

        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $usuarios   = new usuario();

        $pessoas = new pessoas();

/*
        cidades_id  int(11)
        grupos_pessoas_id   int(11)
*/
        $pessoas->razaosocial = $input['razaosocial'];
        $pessoas->nomefantasia = $input['nomefantasia'];
        $pessoas->cnpj = preg_replace("/[^0-9]/", '', $input['cnpj']);
        $pessoas->inscricaoestadual = $input['inscricaoestadual'];
        $pessoas->endereco = $input['endereco'];
        $pessoas->numero = $input['numero'];
        $pessoas->bairro = $input['bairro'];
        $pessoas->cep = $input['cep'];
        $pessoas->complemento = $input['complemento'];
        $pessoas->cidade = $input['cidade'];
        $pessoas->estado = $input['estado'];
        $pessoas->foneprincipal = preg_replace("/[^0-9]/", '', $input['foneprincipal']);
        $pessoas->fonesecundario = preg_replace("/[^0-9]/", '', $input['fonesecundario']);
        $pessoas->emailprincipal = $input['emailprincipal'];
        $pessoas->emailsecundario = $input['emailsecundario'];
        $pessoas->nomecontato = $input['nomecontato'];
        $pessoas->celular = $input['celular'];
        $pessoas->ativo = 'S'; //Sempre ativo quando cadastrar ?
        $pessoas->website = $input['website'];
        $pessoas->clientes_cloud_id = $this->dados_login->empresas_clientes_cloud_id;

        if ($image)
        {
            $pessoas->caminhologo = $image->getClientOriginalName();
        }

        $pessoas->save();

       if ($image) {
                /*Regras validação imagem*/
                $rules = array (
                    'image' => 'image',
                    'image' => array('mimes:jpeg,jpg,png', 'max:800px'),
                );

                // Validar regras
                $validator = Validator::make([$image], $rules);

                // Check to see if validation fails or passes
                if ($validator->fails()) {

                    dd($validator);

                } else {

                    $destinationPath = base_path() . '/public/images/persons'; //caminho onde será gravado
                    if(!$image->move($destinationPath, $image->getClientOriginalName())) //move para pasta destino com nome fixo logo
                    {
                        return $this->errors(['message' => 'Erro ao salvar imagem.', 'code' => 400]);
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

        //preview = true, somente visualizacao, desabilita botao gravar
        $dados = pessoas::findOrfail($id);
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

        $dados = pessoas::findOrfail($id);
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

            $dados = pessoas::findOrfail($id);
            $dados->delete();

            return redirect($this->rota);

    }

}