<?php
/*
* Autor : Oscar Fabiano
* Data  : 29-01-2016
*  Consideraçoes :
*       - Poderia ser usado o método de validações do form request personalizado
*       - Também poderá ser alterado o save() para request->all(),  inclusive retirando caracteres especiais
*       - Por questões de estudo, deixaremos esse controle da forma que está para ser comparado com outro métiodos
*/
namespace App\Http\Controllers;

//use Request;
use App\Models\clientescloud;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Amranidev\Ajaxis\Ajaxis;
use URL;
use App\Models\usuario;
use App\Models\empresas;
use Auth;
use Input;
use Validator;

class ClientesCloudController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {

       /*
            Verificar se foi cadastrado os dados da igreja
            Caso encontre, busca somente os dados da empresa que o usuário pertence
       */
        $cadastrou = usuario::find(Auth::user()->id);


        if ($cadastrou)
        {
            //$clientes_cloud = clientescloud::find($cadastrou['empresas_id'])->empresas;
            //dd($cadastrou['empresas_clientes_cloud_id']);

            $clientes_cloud = clientescloud::all()->where('id', intval($cadastrou['empresas_clientes_cloud_id']));

            //$clientes_cloud = clientescloud::find($cadastrou['empresas_clientes_cloud_id']);
            //dd($clientes_cloud);
            return view('clientes.index',compact('clientes_cloud'));

        }
        else
        {
            return view('pages.dashboard_blank');  //Ainda nao cadastrou, solicitar o cadastro
        }

    }

    //
    public function create() {

        return view('clientes.registrar');

    }


/*
* ClientesCloudRequest = Validação de campos
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

        $usuarios          = new usuario();

        $clientes_cloud = new clientescloud();

        $clientes_cloud->razaosocial = $input['razaosocial'];
        $clientes_cloud->nomefantasia = $input['nomefantasia'];
        $clientes_cloud->cnpj = preg_replace("/[^0-9]/", '', $input['cnpj']);
        $clientes_cloud->inscricaoestadual = $input['inscricaoestadual'];
        $clientes_cloud->endereco = $input['endereco'];
        $clientes_cloud->numero = $input['numero'];
        $clientes_cloud->bairro = $input['bairro'];
        $clientes_cloud->cep = $input['cep'];
        $clientes_cloud->complemento = $input['complemento'];
        $clientes_cloud->cidade = $input['cidade'];
        $clientes_cloud->estado = $input['estado'];
        $clientes_cloud->foneprincipal = preg_replace("/[^0-9]/", '', $input['foneprincipal']);
        $clientes_cloud->fonesecundario = preg_replace("/[^0-9]/", '', $input['fonesecundario']);
        $clientes_cloud->emailprincipal = $input['emailprincipal'];
        $clientes_cloud->emailsecundario = $input['emailsecundario'];
        $clientes_cloud->nomecontato = $input['nomecontato'];
        $clientes_cloud->celular = $input['celular'];
        $clientes_cloud->ativo = 'S'; //Sempre ativo quando cadastrar ?
        $clientes_cloud->website = $input['website'];

        if ($image) {
            $clientes_cloud->caminhologo = $image->getClientOriginalName();
        }

        $clientes_cloud->save();

       /*
        *Busca id da tabela empresas vinculada a tabela clientes_cloud
       */
        $id_empresas = empresas::where('clientes_cloud_id', $clientes_cloud->id)->select('id')->first();

       /* Aqui faz o vinculo da usuário cadastrado na users com as tabelas do sistema
       *
       * Grava o id (users, clientes_cloud e empresas) na tabela usuarios (id, empresas_clientes_cloud_id, empresas_id)
       */
        $usuarios->id                                           =  Auth::user()->id;    //id do usuário logado (tabela users)
        $usuarios->empresas_id                          =  $id_empresas['id']; //Pegar ID do registro recém criado (clientes_cloud)
        $usuarios->empresas_clientes_cloud_id  =  $clientes_cloud->id;
        $usuarios->master = 1; //Criada a empresa a primeira vez, o usuario que cadastrou será o master e nao podera ser removido
        $usuarios->save();

       if ($image) {

                /*Regras validação imagem*/
                $rules = array(
                    'image' => 'image',
                    'image' => array('mimes:jpeg,jpg,png', 'max:200px'),
                );

                // Validar regras
                $validator = Validator::make([$image], $rules);

                // Check to see if validation fails or passes
                if ($validator->fails()) {

                    dd($validator);

                } else {

                    $destinationPath = base_path() . '/public/images/clients'; //caminho onde será gravado
                    if(!$image->move($destinationPath, $image->getClientOriginalName())) //move para pasta destino com nome fixo logo
                    {
                        return $this->errors(['message' => 'Erro ao salvar imagem.', 'code' => 400]);
                    }
                }
         }


        \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

        return redirect('clientes');

    }

    public function show(Request $request, $id)
    {
            if($request->ajax())
            {
                return URL::to ( 'clientes/'.$id);
            }

            $clientes_cloud = clientescloud::find($id);
            return view('clientes.show',compact('clientes_cloud'));
    }

    public function edit(Request $request, $id)
    {
        if($request->ajax())
        {
            return URL::to('clientes/'. $id . '/edit');
        }

        $clientes_cloud = clientescloud::findOrfail($id);
        return view('clientes.edit',compact('clientes_cloud'));
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
                'razaosocial' => 'required|max:255:min:3',
                'foneprincipal' => 'required|min:10',
                'emailprincipal' => 'email',
                'emailsecundario' => 'email',
         ]);

        $image = $request->file('caminhologo');

        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $clientes_cloud = clientescloud::findOrfail($id);

        $clientes_cloud->razaosocial  = $input['razaosocial'];
        $clientes_cloud->nomefantasia = $input['nomefantasia'];
        $clientes_cloud->cnpj  = preg_replace("/[^0-9]/", '', $input['cnpj']);
        $clientes_cloud->inscricaoestadual = $input['inscricaoestadual'];
        $clientes_cloud->endereco = $input['endereco'];
        $clientes_cloud->numero = $input['numero'];
        $clientes_cloud->bairro = $input['bairro'];
        $clientes_cloud->cep = $input['cep'];
        $clientes_cloud->complemento = $input['complemento'];
        $clientes_cloud->cidade = $input['cidade'];
        $clientes_cloud->estado = $input['estado'];
        $clientes_cloud->foneprincipal = preg_replace("/[^0-9]/", '', $input['foneprincipal']);
        $clientes_cloud->fonesecundario = preg_replace("/[^0-9]/", '', $input['fonesecundario']);
        $clientes_cloud->emailprincipal = $input['emailprincipal'];
        $clientes_cloud->emailsecundario = $input['emailsecundario'];
        $clientes_cloud->nomecontato = $input['nomecontato'];
        $clientes_cloud->celular = $input['celular'];
        //$clientes_cloud->ativo = $input['ativo'];
        $clientes_cloud->website = $input['website'];

        if ($image) {
            $clientes_cloud->caminhologo = $image->getClientOriginalName();
        }

        $clientes_cloud->save();

        if ($image) {
                /*Regras validação imagem*/
                $rules = array(
                    'image' => 'image',
                    'image' => array('mimes:jpeg,jpg,png', 'max:200px'),
                );

                // Validar regras
                $validator = Validator::make([$image], $rules);

                // Check to see if validation fails or passes
                if ($validator->fails()) {

                    dd($validator);

                } else {

                    $destinationPath = base_path() . '/public/images/clients'; //caminho onde será gravado
                    if(!$image->move($destinationPath, $image->getClientOriginalName())) //move para pasta destino com nome fixo logo
                    {
                        return $this->errors(['message' => 'Erro ao salvar imagem.', 'code' => 400]);
                    }
                }
            }

        \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

        return redirect('clientes');

    }

    /**
     * Delete confirmation message by Ajaxis
     *
     * @link  https://github.com/amranidev/ajaxis
     *
     * @return  String
     */
    public function DeleteMsg($id)
    {
        $msg = Ajaxis::MtDeleting('Aviso!!','Confirma exclusão ?','/clientes/'. $id . '/delete/');

        if(Request::ajax())
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
        $clientes_cloud = clientescloud::findOrfail($id);
        $clientes_cloud->delete();
        return URL::to('clientes');
    }

    public function remove_image ($id) {

         $clientes_cloud = clientescloud::findOrfail($id);

         if(!\File::delete(public_path() . '/images/clients/' . $clientes_cloud->caminhologo))
         {

            \Session::flash('flash_message_erros', 'Erro ao remover imagem');
         }
         else
         {

            $clientes_cloud->caminhologo = '';
            $clientes_cloud->save();

            \Session::flash('flash_message', 'Imagem Removida com Sucesso!!!');

         }

         return redirect('clientes');

    }

}