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

        //Lista tipos de pessoas, será usado no botão novo registro para indicar qual tipo de cadastro efetuar
        $tipos = \App\Models\tipospessoas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

        //Listagem de pessoas
        $dados = pessoas::select('pessoas.*', 'tipos_pessoas.id as id_tipo_pessoa', 'tipos_pessoas.nome as nome_tipo_pessoa')
        ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->join('tipos_pessoas', 'tipos_pessoas.id', '=' , 'pessoas.tipos_pessoas_id')
        ->get();

        return view($this->rota . '.index', ['dados' => $dados, 'tipos' => $tipos]);

    }

    //Criar novo registro
    //parametros = $id (id do cadastro tipos de pessoas)
    //Buscar pelo ID o cadastro do tipo de pessoa e verificar quais abas e dados habilitar na página
    public function create($id)
    {

       if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
       {
              return redirect('home');
       }

        //Para carregar combo de grupos de pessoas
        $dados = \App\Models\grupospessoas::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->get();

        //Verificar qual o tipo de pessoa para habilitar ou não abas e campos conforme o tipo
        //Ex; Pessoa fisica, habilita cpf e rg, juridica habilita CNPJ,  membros habilita dados especificos de membresia.
        $habilitar_interface = \App\Models\tipospessoas::findOrfail($id);

        //Para carregar combo de bancos
        $bancos = \App\Models\bancos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

        return view($this->rota . '.registrar', ['dados'=> $dados, 'interface' => $habilitar_interface, 'bancos' => $bancos]);

    }


/*
* Grava dados no banco
*
*/
public function salvar($request, $id, $tipo_operacao) {

        /*Validação de campos - request*/
        $this->validate($request, [
                'razaosocial' => 'required|max:255:min:3',
                'emailprincipal' => 'email',
                'emailsecundario' => 'email',
         ]);

        $image = $request->file('caminhologo');

        $input = $request->except(array('_token', 'ativo')); //não levar o token



        /*--------------------------------- CADASTRO DE PESSOAS------------------- */
        if ($tipo_operacao=="create") //novo registro
        {
             $pessoas = new pessoas();
        }
        else //update
        {
             $pessoas = pessoas::findOrfail($id);
        }

        $pessoas->razaosocial = $input['razaosocial'];
        $pessoas->nomefantasia = $input['nomefantasia'];
        $pessoas->cnpj_cpf = preg_replace("/[^0-9]/", '', $input['cnpj_cpf']);
        $pessoas->inscricaoestadual_rg = $input['inscricaoestadual_rg'];
        $pessoas->endereco = $input['endereco'];
        $pessoas->numero = $input['numero'];
        $pessoas->bairro = $input['bairro'];
        $pessoas->cep = $input['cep'];
        $pessoas->complemento = $input['complemento'];
        $pessoas->cidade = $input['cidade'];
        $pessoas->estado = $input['estado'];
        $pessoas->grupos_pessoas_id = ($input['grupo']=="" ? null : $input['grupo']);
        $pessoas->obs = $input['obs'];
        $pessoas->fone_principal = preg_replace("/[^0-9]/", '', $input['foneprincipal']);
        $pessoas->fone_secundario = preg_replace("/[^0-9]/", '', $input['fonesecundario']);
        $pessoas->fone_recado = $input['fonerecado'];
        $pessoas->fone_celular = $input['celular'];
        $pessoas->emailprincipal = $input['emailprincipal'];
        $pessoas->emailsecundario = $input['emailsecundario'];
        $pessoas->ativo = ($input['opStatus'] ? 1 : 0);
        $pessoas->tipos_pessoas_id = $input['tipos_pessoas_id'];

        if ($input['datanasc']!="")
        {
            $data_formatada = \DateTime::createFromFormat('d/m/Y', $input['datanasc']);
            $pessoas->datanasc = $data_formatada->format('Y-m-d');
        }

        $pessoas->tipopessoa = ($input['opPessoa'] ? 1 : 0);
        $pessoas->website = $input['website'];
        $pessoas->empresas_clientes_cloud_id = $this->dados_login->empresas_clientes_cloud_id;
        $pessoas->empresas_id = $this->dados_login->empresas_id;

        if ($image)
        {
            $pessoas->caminhofoto = $image->getClientOriginalName();
        }

        $pessoas->save();
        /*------------------------------FIM  CADASTRO DE PESSOAS------------------- */



        /*------------------------------DADOS FINANCEIROS------------------------------*/
        $where = [
            'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
            'empresas_id' =>  $this->dados_login->empresas_id,
            'pessoas_id' => $pessoas->id
        ];

        $financ = \App\Models\financpessoas::firstOrNew($where);

        $valores =
                [
                    'pessoas_id' => $pessoas->id,
                    'endereco' => $input['endereco_cobranca'],
                    'numero' => $input['numero_cobranca'],
                    'bairro' => $input['bairro_cobranca'],
                    'cep' => $input['cep_cobranca'],
                    'complemento' => $input['complemento_cobranca'],
                    'cidade' => $input['cidade_cobranca'],
                    'estado' => $input['estado_cobranca'],
                    'bancos_id' => ($input['banco']=="" ? null : $input['banco']),
                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                    'empresas_id' =>  $this->dados_login->empresas_id
                ];

        $financ->fill($valores)->save();
        $financ->save();
        /*------------------------------FIM - DADOS FINANCEIROS------------------------------*/



       /*--------------------------------------------------UPLOAD IMAGEM */
       if ($image) {


                /*Regras validação imagem*/
                $rules = array(
                    'image' => 'image',
                    'image' => array('mimes:jpeg,jpg,png', 'max:2000kb'),
                );

                // Validar regras
                $validator = \Validator::make([$image], $rules);

                // Check to see if validation fails or passes

                if ($validator->fails()) {

                    \Session::flash('flash_message_erro', 'Os dados foram salvos, porém houve erro no envio da imagem.');
                    return redirect($this->rota);

                } else {

                    $destinationPath = base_path() . '/public/images/persons'; //caminho onde será gravado
                    if(!$image->move($destinationPath, $image->getClientOriginalName())) //move para pasta destino com nome fixo logo
                    {
                        //return $this->errors(['message' => 'Erro ao salvar imagem.', 'code' => 400]);
                        \Session::flash('flash_message_erro', 'Os dados foram salvos, porém houve erro no envio da imagem.' . ['message' => 'Erro ao salvar imagem.', 'code' => 400]);
                    }

                }
         }
         /*--------------------------------------------------FIM UPLOAD IMAGEM */

}

    //Criar novo registro
    public function store(\Illuminate\Http\Request  $request)
    {
            $this->salvar($request, "", "create");
            \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');
             return redirect($this->rota);
    }


    //Abre tela para edicao ou somente visualização dos registros
    private function exibir ($request, $id, $id_tipo_pessoa, $preview)
    {

        if($request->ajax())
        {
            return URL::to($this->rota . '/'. $id . '/edit');
        }

        //Validação de permissão
        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        //Verificar qual o tipo de pessoa para habilitar ou não abas e campos conforme o tipo
        //Ex; Pessoa fisica, habilita cpf e rg, juridica habilita CNPJ,  membros habilita dados especificos de membresia.
        $habilitar_interface = \App\Models\tipospessoas::findOrfail($id_tipo_pessoa);

        //Listagem grupos de pessoas (Para carregar dropdown )
        $grupos = \App\Models\grupospessoas::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->get();

        //preview = true, somente visualizacao, desabilita botao gravar
        $pessoas = pessoas::select('pessoas.*', 'financ_pessoas.id as id_financ', 'financ_pessoas.bancos_id', 'financ_pessoas.endereco as endereco_cobranca', 'financ_pessoas.numero as numero_cobranca', 'financ_pessoas.bairro as bairro_cobranca', 'financ_pessoas.cidade as cidade_cobranca', 'financ_pessoas.estado as estado_cobranca', 'financ_pessoas.cep as cep_cobranca', 'financ_pessoas.complemento as complemento_cobranca')
        ->leftjoin('financ_pessoas', 'pessoas.id', '=', 'financ_pessoas.pessoas_id')
        ->where('pessoas.id', $id)
        ->where('pessoas.empresas_id', $this->dados_login->empresas_id)
        ->where('pessoas.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->get();

        //Listagem de bancos (Para carregar dropdown )
        $bancos = \App\Models\bancos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

        return view($this->rota . '.edit', ['grupos' =>$grupos, 'preview' => $preview, 'interface' => $habilitar_interface, 'bancos' => $bancos, 'pessoas' => $pessoas]);

    }

    //Visualizar registro
    public function show (\Illuminate\Http\Request $request, $id, $id_tipo_pessoa)
    {
            return $this->exibir($request, $id, $id_tipo_pessoa, 'true');
    }

    //Direciona para tela de alteracao
    public function edit(\Illuminate\Http\Request $request, $id, $id_tipo_pessoa)
    {
            return $this->exibir($request, $id, $id_tipo_pessoa, 'false');
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
            $dados = pessoas::findOrfail($id);
            $dados->delete();
            return redirect($this->rota);
    }

    public function remove_image ($id)
    {

         $pessoas = pessoas::findOrfail($id);

         if(!\File::delete(public_path() . '/images/persons/' . $pessoas->caminhofoto))
         {
            \Session::flash('flash_message_erros', 'Erro ao remover imagem');
         }
         else
         {
            $pessoas->caminhofoto = '';
            $pessoas->save();

            \Session::flash('flash_message', 'Imagem Removida com Sucesso!!!');
         }

         return redirect($this->rota);

    }

}