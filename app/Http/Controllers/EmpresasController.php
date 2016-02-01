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

class EmpresasController extends Controller
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
            //$emp = empresas::find($cadastrou['empresas_clientes_cloud_id']);

            $emp = empresas::all()->where('clientes_cloud_id', $cadastrou['empresas_clientes_cloud_id']);

            return view('empresas.index',compact('emp'));
        }
        else
        {
            return view('pages.dashboard_blank');  //Ainda nao cadastrou, solicitar o cadastro
        }

    }

    //
    public function create() {

        return view('empresas.registrar');

    }


/*
* ClientesCloudRequesempresas = Validação de campos
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

        $empresas = new empresas();

        $empresas->razaosocial = $input['razaosocial'];
        $empresas->nomefantasia = $input['nomefantasia'];
        $empresas->cnpj = preg_replace("/[^0-9]/", '', $input['cnpj']);
        $empresas->inscricaoestadual = $input['inscricaoestadual'];
        $empresas->endereco = $input['endereco'];
        $empresas->numero = $input['numero'];
        $empresas->bairro = $input['bairro'];
        $empresas->cep = $input['cep'];
        $empresas->complemento = $input['complemento'];
        $empresas->cidade = $input['cidade'];
        $empresas->estado = $input['estado'];
        $empresas->foneprincipal = preg_replace("/[^0-9]/", '', $input['foneprincipal']);
        $empresas->fonesecundario = preg_replace("/[^0-9]/", '', $input['fonesecundario']);
        $empresas->emailprincipal = $input['emailprincipal'];
        $empresas->emailsecundario = $input['emailsecundario'];
        $empresas->nomecontato = $input['nomecontato'];
        $empresas->celular = $input['celular'];
        $empresas->ativo = 'S'; //Sempre ativo quando cadastrar ?
        $empresas->website = $input['website'];

        $cadastrou = usuario::find(Auth::user()->id);

        if ($cadastrou)
        {
            $empresas->clientes_cloud_id = $cadastrou['empresas_clientes_cloud_id'];
        }


        if ($image) {
            $empresas->caminhologo = $image->getClientOriginalName();
        }

        $empresas->save();

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

        return redirect('empresas');

    }

    public function show(Request $request, $id)
    {
            if($request->ajax())
            {
                return URL::to ( 'empresas/'.$id);
            }

            $empresas = empresas::find($id);
            return view('empresas.show',compact('clientes_cloud'));
    }

    public function edit(Request $request, $id)
    {
        if($request->ajax())
        {
            return URL::to('empresas/'. $id . '/edit');
        }

        $empresas = empresas::findOrfail($id);
        return view('empresas.edit',compact('empresas'));
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

        $empresas = empresas::findOrfail($id);

        $empresas->razaosocial  = $input['razaosocial'];
        $empresas->nomefantasia = $input['nomefantasia'];
        $empresas->cnpj  = preg_replace("/[^0-9]/", '', $input['cnpj']);
        $empresas->inscricaoestadual = $input['inscricaoestadual'];
        $empresas->endereco = $input['endereco'];
        $empresas->numero = $input['numero'];
        $empresas->bairro = $input['bairro'];
        $empresas->cep = $input['cep'];
        $empresas->complemento = $input['complemento'];
        $empresas->cidade = $input['cidade'];
        $empresas->estado = $input['estado'];
        $empresas->foneprincipal = preg_replace("/[^0-9]/", '', $input['foneprincipal']);
        $empresas->fonesecundario = preg_replace("/[^0-9]/", '', $input['fonesecundario']);
        $empresas->emailprincipal = $input['emailprincipal'];
        $empresas->emailsecundario = $input['emailsecundario'];
        $empresas->nomecontato = $input['nomecontato'];
        $empresas->celular = $input['celular'];
        //$empresas->ativo = $input['ativo'];
        $empresas->website = $input['website'];

        if ($image) {
            $empresas->caminhologo = $image->getClientOriginalName();
        }

        $empresas->save();

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

        return redirect('empresas');

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
        $msg = Ajaxis::MtDeleting('Aviso!!','Confirma exclusão ?','/empresas/'. $id . '/delete/');

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
        $empresas = empresas::findOrfail($id);
        $empresas->delete();
        return redirect('empresas');
    }

    public function remove_image ($id) {

         $empresas = empresas::findOrfail($id);

         if(!\File::delete(public_path() . '/images/clients/' . $empresas->caminhologo))
         {

            \Session::flash('flash_message_erros', 'Erro ao remover imagem');
         }
         else
         {

            $empresas->caminhologo = '';
            $empresas->save();

            \Session::flash('flash_message', 'Imagem Removida com Sucesso!!!');

         }

         return redirect('empresas');

    }

}