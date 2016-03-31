<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\pessoas;
use App\Functions;
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


    /**//**
     * Description = Listagem de Pessoas cadastradas
     */
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
        ->where('empresas_id', $this->dados_login->empresas_id)
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


        if ($habilitar_interface->membro) //Somente se no cadastro de tipos de pessoas estiver marcado MEMBRO
        {

            /*
            Para preencher combos Dados eclesiasticos
            */
            $familias = \App\Models\pessoas::select('razaosocial as nome', 'id')->where(['empresas_id' => $this->dados_login->empresas_id, 'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id])->orderBy('razaosocial','ASC')->get();
            $igrejas = \App\Models\igrejas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
            $situacoes = \App\Models\situacoes::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
            $idiomas = \App\Models\idiomas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
            $status = \App\Models\status::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
            $profissoes = \App\Models\profissoes::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
            $ramos = \App\Models\ramos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
            $cargos = \App\Models\cargos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
            $graus = \App\Models\graus::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
            $formacoes = \App\Models\areas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
            $estadoscivis = \App\Models\civis::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
            $disponibilidades = \App\Models\disponibilidades::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
            $dons = \App\Models\dons::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
            $habilidades = \App\Models\habilidades::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
            $religioes = \App\Models\religioes::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
            $atividades = \App\Models\atividades::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
            $ministerios = \App\Models\ministerios::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
            $motivos = \App\Models\tiposmovimentacao::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
            /* FIM Para preencher combos Dados eclesiasticos*/

            /*Inicializa variaveis vazias dos dados eclesiasticos*/
            $membros_dados_pessoais =  $religioes; //array('0' => ['0'  => 'membros_dados']);
            $membros_situacoes =  "";
            $membros_dons =  "";
            $membros_habilidades =  "";
            $membros_formacoes =  "";
            $membros_idiomas =  "";
            $membros_familiares = $religioes;
            $membros_filhos = $religioes;
            $membros_atividades =  "";
            $membros_ministerios =  "";
            $membros_historico =  $religioes;
            $membros_profissionais =  $religioes; //array('0' => ['0'  => 'membros_profissionais']);


            return view($this->rota . '.registrar',
            [
                'dados'=> $dados,
                'interface' => $habilitar_interface,
                'bancos' => $bancos,
                'igrejas' => $igrejas,
                'situacoes' => $situacoes,
                'status' => $status,
                'familias' => $familias,
                'pessoas' => $familias,
                'idiomas' => $idiomas,
                'profissoes' => $profissoes,
                'ramos' => $ramos,
                'graus' => $graus,
                'formacoes' => $formacoes,
                'religioes' => $religioes,
                'disponibilidades' => $disponibilidades,
                'dons' => $dons,
                'habilidades' => $habilidades,
                'estadoscivis' => $estadoscivis,
                'motivos' => $motivos,
                'atividades' => $atividades,
                'ministerios' => $ministerios,
                'cargos' => $cargos,
                'membros_dados_pessoais' => $membros_dados_pessoais,
                'membros_situacoes' => $membros_situacoes,
                'membros_dons' => $membros_dons,
                'membros_filhos' => $membros_filhos,
                'membros_atividades' => $membros_atividades,
                'membros_ministerios' => $membros_ministerios,
                'membros_habilidades' => $membros_habilidades,
                'membros_familiares' => $membros_familiares,
                'membros_historico' => $membros_historico,
                'membros_formacoes' => $membros_formacoes,
                'membros_idiomas' => $membros_idiomas,
                'membros_profissionais' => $membros_profissionais
            ]);

        }
        else
        {

            return view($this->rota . '.registrar',
            [
                'dados'=> $dados,
                'interface' => $habilitar_interface,
                'bancos' => $bancos
            ]);

        }


    }


/*
* Grava dados no banco
*
*/
public function salvar($request, $id, $tipo_operacao) {

    /*Clausula where padrao para as tabelas auxiliares*/
    $where =
    [
        'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
        'empresas_id' =>  $this->dados_login->empresas_id,
        'pessoas_id' => $id
    ];

    /*
        Se for UPDATE (houver conteudo variavel $id), exclui as tabelas auxiliares antes da TRANSACTION
    */
    if ($id!="")
    {
            /*Excluir antes atualizar*/
            $excluir = \App\Models\membros_dons::where($where)->delete();
            $excluir = \App\Models\membros_profissionais::where($where)->delete();
            $excluir = \App\Models\financpessoas::where($where)->delete();
            $excluir = \App\Models\membros_dados::where($where)->delete();
            $excluir = \App\Models\membros_familiares::where($where)->delete();
            $excluir = \App\Models\membros_situacoes::where($where)->delete();
            $excluir = \App\Models\membros_formacoes::where($where)->delete();
            $excluir = \App\Models\membros_idiomas::where($where)->delete();
            $excluir = \App\Models\membros_habilidades::where($where)->delete();
            $excluir = \App\Models\membros_atividades::where($where)->delete();
            $excluir = \App\Models\membros_filhos::where($where)->delete();
            $excluir = \App\Models\membros_ministerios::where($where)->delete();
            $excluir = \App\Models\membros_hist_eclesiasticos::where($where)->delete();
    }


/* ------------------ INICIA TRANSACTION -----------------------*/
        \DB::transaction(function() use ($request, $id, $tipo_operacao, $where)
        {

            /*Instancia biblioteca de funcoes globais*/
            $formatador = new  \App\Functions\FuncoesGerais();

                /*Validação de campos - request*/
                $this->validate($request, [
                        'razaosocial' => 'required|max:255:min:3',
                        'emailprincipal' => 'email',
                        'emailsecundario' => 'email',
                        'opPessoa' => 'required',
                        'cpf'       => 'cpf',
                        'cnpj'      => 'cnpj',
                 ]);

                $image = $request->file('caminhologo'); //Imagem / Logo
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
                $pessoas->cnpj_cpf = $formatador->RetirarCaracteres(($input['cnpj']!="" ? $input['cnpj'] : $input['cpf']));
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
                $pessoas->fone_principal = $formatador->RetirarCaracteres($input['foneprincipal']); //preg_replace("/[^0-9]/", '', $input['foneprincipal']);
                $pessoas->fone_secundario = $formatador->RetirarCaracteres($input['fonesecundario']);//preg_replace("/[^0-9]/", '', $input['fonesecundario']);
                $pessoas->fone_recado = $input['fonerecado'];
                $pessoas->fone_celular = $input['celular'];
                $pessoas->emailprincipal = $input['emailprincipal'];
                $pessoas->emailsecundario = $input['emailsecundario'];
                $pessoas->ativo = ($input['opStatus'] ? 1 : 0);
                $pessoas->tipos_pessoas_id = $input['tipos_pessoas_id'];
                $pessoas->datanasc = $formatador->FormatarData($input['datanasc']);
                $pessoas->tipopessoa = $input['opPessoa'];
                $pessoas->website = $input['website'];
                $pessoas->empresas_clientes_cloud_id = $this->dados_login->empresas_clientes_cloud_id;
                $pessoas->empresas_id = $this->dados_login->empresas_id;

                if ($image) //Imagem Enviada computador
                {
                    //$pessoas->caminhofoto = $image->getClientOriginalName();
                    $pessoas->caminhofoto = str_replace(" ","", $input['razaosocial']) . '.' . $image->getClientOriginalExtension();
                }

                if ($input['mydata']!="") //Imagem tirada pela webcam
                {

                    $pessoas->caminhofoto = str_replace(" ","", $input['razaosocial']) . '_webcam.jpg';
                }

                $pessoas->save();
                /*------------------------------FIM  CADASTRO DE PESSOAS------------------- */


                /*------------------------------DADOS FINANCEIROS------------------------------*/

                if ($input['banco']!="" || $input['endereco_cobranca']!="") {

                        if ($tipo_operacao=="create")  //novo registro
                        {
                            $financ = new \App\Models\financpessoas();
                        }
                        else //Alteracao
                        {
                            $financ = \App\Models\financpessoas::firstOrNew($where);
                        }


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
                    }
                /*------------------------------FIM - DADOS FINANCEIROS------------------------------*/



              /*Verifica o cadastro do tipo de pessoa (campo MEMBRO) para saber se grava dados eclesiasticos*/
              $habilitar_interface = \App\Models\tipospessoas::findOrfail($input['tipos_pessoas_id']);


              //Somente se for tipo MEMBRO
              if ($habilitar_interface->membro)
              {

                        /*------------------------------DADOS ECLESIASTICOS------------------------------*/

                        if ($input['opSexo']!="" || $input['status']!="" || $input['graus']!="" || $input['lingua']!="" || $input['igreja']!=""
                            || $input['familia']!="" || $input['opDoadorSangue']!="" || $input['opDoadorOrgaos']!="" || $input['naturalidade']!=""
                            || $input['ufnaturalidade']!="" || $input['nacionalidade']!="" || $input['grpsangue']!="" || $input['necessidades']!=""
                            || $input['facebook']!="" || $input['google']!="" || $input['instagram']!="" || $input['linkedin']!="")

                        {

                                if ($tipo_operacao=="create")  //novo registro
                                {
                                    $eclesiasticos = new \App\Models\membros_dados();
                                }
                                else //Alteracao
                                {
                                    $eclesiasticos = \App\Models\membros_dados::firstOrNew($where);
                                }

                                $valores =
                                [
                                    'pessoas_id' => $pessoas->id,
                                    'empresas_id' =>  $this->dados_login->empresas_id,
                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                    'status_id' => ($input['status']=="" ? null : $input['status']),
                                    'idiomas_id' => ($input['lingua']=="" ? null : $input['lingua']),
                                    'igrejas_id' => ($input['igreja']=="" ? null : $input['igreja']),
                                    'estadoscivis_id' => ($input['estadoscivis']=="" ? null : $input['estadoscivis']),
                                    'disponibilidades_id' => ($input['disponibilidades']=="" ? null : $input['disponibilidades']),
                                    'graus_id' => ($input['graus']=="" ? null : $input['graus']),
                                    'familias_id' => ($input['familia']=="" ? null : $input['familia']),
                                    'sexo' => ($input['opSexo']=="" ? null : $input['opSexo']),
                                    'prefere_trabalhar_com' => ($input['prefere_trabalhar_com']=="" ? null : $input['prefere_trabalhar_com']),
                                    'considera_se' => ($input['considera_se']=="" ? null : $input['considera_se']),
                                    'doador_sangue' => ($input['opDoadorSangue']=="" ? null : $input['opDoadorSangue']),
                                    'doador_orgaos' => ($input['opDoadorOrgaos']=="" ? null : $input['opDoadorOrgaos']),
                                    'naturalidade' => $input['naturalidade'],
                                    'uf_naturalidade' => $input['ufnaturalidade'],
                                    'nacionalidade' => $input['nacionalidade'],
                                    'grupo_sanguinio' => ($input['grpsangue']=="" ? null : $input['grpsangue']),
                                    'possui_necessidades_especiais' => ($input['ck_necessidades']=="" ? 0 : $input['ck_necessidades']),
                                    'descricao_necessidade_especial' => $input['necessidades'],
                                    'link_facebook' => $input['facebook'],
                                    'link_google' => $input['google'],
                                    'link_instagram' => $input['instagram'],
                                    'link_outros' => '',
                                    'link_linkedin' => $input['linkedin']
                                ];

                                $eclesiasticos->fill($valores)->save();
                                $eclesiasticos->save();
                            }
                        /*------------------------------FIM - DADOS ECLESIASTICOS------------------------------*/



                        /*------------------------------MEMBROS FILHOS (SEM CADASTRO)------------------------------*/

                        if ($input['inc_filhos']!="") /*Se for inclusão sem cadastro vinculado*/
                        {

                            $i_index=0; /*Inicia sequencia*/

                            /*Pode ser um ou vários, por isso percorre array de inputs gerados*/
                            foreach($input['inc_filhos'] as $selected)
                                {
                                        if ($selected!="")
                                        {

                                                $whereForEach =
                                                [
                                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                    'empresas_id' =>  $this->dados_login->empresas_id,
                                                    'pessoas_id' => $pessoas->id,
                                                    'nome_filho' => $selected
                                                ];

                                                if ($tipo_operacao=="create")  //novo registro
                                                {
                                                    $filhos = new \App\Models\membros_filhos();
                                                }
                                                else //Alteracao
                                                {
                                                    $filhos = \App\Models\membros_filhos::firstOrNew($whereForEach);
                                                }

                                                $valores =
                                                [
                                                    'pessoas_id' => $pessoas->id,
                                                    'empresas_id' =>  $this->dados_login->empresas_id,
                                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                    'nome_filho' => $input['inc_filhos'][$i_index],
                                                    'status_id' => ($input['hidden_status'][$i_index]=="" ? null : $input['hidden_status'][$i_index]),
                                                    'estadocivil_id' => ($input['hidden_estadocivl'][$i_index]=="" ? null : $input['hidden_estadocivl'][$i_index]),
                                                    'sexo' => ($input['hidden_sexo'][$i_index]=="" ? null : $input['hidden_sexo'][$i_index]),
                                                    'data_nasc' => $formatador->FormatarData($input['inc_datanasc'][$i_index]),
                                                    'data_falecimento' => $formatador->FormatarData($input['inc_datafalec'][$i_index])
                                                ];

                                                $filhos->fill($valores)->save();
                                                $filhos->save();

                                                $i_index = $i_index + 1; //Incrementa sequencia do array para pegar proximos campos (se houver)
                                        }
                                }


                            }
                        /*------------------------------FIM - MEMBROS FILHOS (SEM CADASTRO) ------------------------------*/




                        /*------------------------------FIM - MEMBROS FILHOS ------------------------------*/
                        if ($input['filhos']!="") /*Se foi informado um ou varios na combo (do cadastro de pessoas)*/
                        {

                            /*Pode ser um ou vários, por isso percorre array de inputs gerados*/
                            foreach($input['filhos'] as $selected)
                                {
                                        if ($selected!="")
                                        {

                                                $whereForEach =
                                                [
                                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                    'empresas_id' =>  $this->dados_login->empresas_id,
                                                    'pessoas_id' => $pessoas->id,
                                                    'filhos_id' => $selected
                                                ];

                                                if ($tipo_operacao=="create")  //novo registro
                                                {
                                                    $filhos = new \App\Models\membros_filhos();
                                                }
                                                else //Alteracao
                                                {
                                                    $filhos = \App\Models\membros_filhos::firstOrNew($whereForEach);
                                                }

                                                $valores =
                                                [
                                                    'pessoas_id' => $pessoas->id,
                                                    'empresas_id' =>  $this->dados_login->empresas_id,
                                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                    'filhos_id' => $selected,
                                                ];

                                                $filhos->fill($valores)->save();
                                                $filhos->save();

                                        }
                                }


                            }
                        /*------------------------------FIM - MEMBROS FILHOS------------------------------*/




                        /*------------------------------ DADOS PROFISSIONAIS ------------------------------*/

                        if ($input['nome_empresa']!="" || $input['endereco_prof']!=""
                            || $input['numero_prof']!="" || $input['bairro_prof']!="" || $input['cep_prof']!="" || $input['complemento_prof']!=""
                            || $input['cidade_prof']!="" || $input['estado_prof']!="" || $input['cargos']!="" || $input['ramos']!=""
                            || $input['profissoes']!="" || $input['emailprofissional']!="")

                        {

                                if ($tipo_operacao=="create")  //novo registro
                                {
                                    $profissionais = new \App\Models\membros_profissionais();
                                }
                                else //Alteracao
                                {
                                    $profissionais = \App\Models\membros_profissionais::firstOrNew($where);
                                }


                                $valores =
                                [
                                    'pessoas_id' => $pessoas->id,
                                    'empresas_id' =>  $this->dados_login->empresas_id,
                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                    'nome_empresa' => $input['nome_empresa'],
                                    'endereco' => $input['endereco_prof'],
                                    'numero' => $input['numero_prof'],
                                    'bairro' => $input['bairro_prof'],
                                    'cep' => $input['cep_prof'],
                                    'complemento' => $input['complemento_prof'],
                                    'cidade' => $input['cidade_prof'],
                                    'estado' => $input['estado_prof'],
                                    'cargos_id' => ($input['cargos']=="" ? null : $input['cargos']),
                                    'ramos_id' => ($input['ramos']=="" ? null : $input['ramos']),
                                    'profissoes_id' => ($input['profissoes']=="" ? null : $input['profissoes']),
                                    'emailprofissional' => $input['emailprofissional']
                                ];

                                $profissionais->fill($valores)->save();
                                $profissionais->save();
                            }
                        /*------------------------------ FIM - DADOS PROFISSIONAIS ------------------------------*/




                        /*------------------------------ DADOS FAMILIARES ------------------------------*/

                        if ($input['conjuge']!="" || $input['nome_conjuge']!=""
                            || $input['datanasc_conjuge']!="" || $input['datafalecimento']!="" || $input['datacasamento']!="" || $input['igrejacasamento']!="" || $input['pai']!="" || $input['mae']!=""
                            || $input['nome_pai']!="" || $input['nome_mae']!="" || $input['status_pai']!="" || $input['status_mae']!=""  || $input['datafalecimento_pai']!="" || $input['datafalecimento_mae']!="")

                        {

                                if ($tipo_operacao=="create")  //novo registro
                                {
                                    $familiares = new \App\Models\membros_familiares();
                                }
                                else //Alteracao
                                {
                                    $familiares = \App\Models\membros_familiares::firstOrNew($where);
                                }

                                $valores =
                                [
                                    'pessoas_id' => $pessoas->id,
                                    'empresas_id' =>  $this->dados_login->empresas_id,
                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                    'conjuge_id'=> ($input['conjuge']=="" ? null : $input['conjuge']),
                                    'nome_conjuge' => $input['nome_conjuge'],
                                    'data_nasc' => $formatador->FormatarData($input['datanasc_conjuge']),
                                    'data_falecimento' => $formatador->FormatarData($input['datafalecimento']),
                                    'data_casamento' => $formatador->FormatarData($input['datacasamento']),
                                    'data_falecimento_pai' => $formatador->FormatarData($input['datafalecimento_pai']),
                                    'data_falecimento_mae' => $formatador->FormatarData($input['datafalecimento_mae']),
                                    'status_id' => ($input['status_conjuge']=="" ? null : $input['status_conjuge']),
                                    'profissoes_id' => ($input['profissao_conjuge']=="" ? null : $input['profissao_conjuge']),
                                    'igreja_casamento' => $input['igrejacasamento'],
                                    'pai_id' => ($input['pai']=="" ? null : $input['pai']),
                                    'mae_id' => ($input['mae']=="" ? null : $input['mae']),
                                    'nome_pai' => $input['nome_pai'],
                                    'nome_mae' => $input['nome_mae'],
                                    'status_pai_id' => ($input['status_pai']=="" ? null : $input['status_pai']),
                                    'status_mae_id' => ($input['status_mae']=="" ? null : $input['status_mae'])
                                ];

                                $familiares->fill($valores)->save();
                                $familiares->save();
                            }
                        /*------------------------------ FIM - DADOS FAMILIARES ------------------------------*/




                        /*------------------------------ Tabela MEMBROS_SITUACOES---------------------------*/

                        if ($input['situacoes']!="")  /*Array combo multiple*/
                        {
                                foreach($input['situacoes'] as $selected)
                                {
                                        if ($selected!="")
                                        {
                                                $whereForEach =
                                                [
                                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                    'empresas_id' =>  $this->dados_login->empresas_id,
                                                    'pessoas_id' => $pessoas->id,
                                                    'situacoes_id' => $selected
                                                ];

                                                if ($tipo_operacao=="create")  //novo registro
                                                {
                                                    $situacoes = new \App\Models\membros_situacoes();
                                                }
                                                else //Alteracao
                                                {
                                                    $situacoes = \App\Models\membros_situacoes::firstOrNew($whereForEach);
                                                }


                                                $valores =
                                                [
                                                    'pessoas_id' => $pessoas->id,
                                                    'situacoes_id' => $selected,
                                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                    'empresas_id' =>  $this->dados_login->empresas_id
                                                ];

                                                $situacoes->fill($valores)->save();
                                                $situacoes->save();
                                        }
                                }
                        }
                        /*------------------------------ FIM Tabela MEMBROS_SITUACOES---------------------------*/





                        /*------------------------------ Tabela MEMBROS_FORMAÇÕES ---------------------------*/

                        if ($input['formacoes']!="")  /*Array combo multiple*/
                        {
                                foreach($input['formacoes'] as $selected)
                                {
                                        if ($selected!="")
                                        {
                                                $whereForEach =
                                                [
                                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                    'empresas_id' =>  $this->dados_login->empresas_id,
                                                    'pessoas_id' => $pessoas->id,
                                                    'formacoes_id' => $selected
                                                ];

                                                 if ($tipo_operacao=="create")  //novo registro
                                                {
                                                    $formacoes = new \App\Models\membros_formacoes();
                                                }
                                                else //Alteracao
                                                {
                                                    $formacoes = \App\Models\membros_formacoes::firstOrNew($whereForEach);
                                                }


                                                $valores =
                                                [
                                                    'pessoas_id' => $pessoas->id,
                                                    'formacoes_id' => $selected,
                                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                    'empresas_id' =>  $this->dados_login->empresas_id
                                                ];

                                                $formacoes->fill($valores)->save();
                                                $formacoes->save();
                                        }
                                }
                        }
                        /*------------------------------ FIM Tabela MEMBROS_SITUACOES---------------------------*/





                        /*------------------------------ Tabela MEMBROS_IDIOMAS ---------------------------*/

                        if ($input['idiomas']!="")  /*Array combo multiple*/
                        {
                                foreach($input['idiomas'] as $selected)
                                {
                                        if ($selected!="")
                                        {
                                                $whereForEach =
                                                [
                                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                    'empresas_id' =>  $this->dados_login->empresas_id,
                                                    'pessoas_id' => $pessoas->id,
                                                    'idiomas_id' => $selected
                                                ];

                                                if ($tipo_operacao=="create")  //novo registro
                                                {
                                                    $idiomas = new \App\Models\membros_idiomas();
                                                }
                                                else //Alteracao
                                                {
                                                    $idiomas = \App\Models\membros_idiomas::firstOrNew($whereForEach);
                                                }


                                                $valores =
                                                [
                                                    'pessoas_id' => $pessoas->id,
                                                    'idiomas_id' => $selected,
                                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                    'empresas_id' =>  $this->dados_login->empresas_id
                                                ];

                                                $idiomas->fill($valores)->save();
                                                $idiomas->save();
                                        }
                                }
                        }
                        /*------------------------------ FIM Tabela MEMBROS_IDIOMAS---------------------------*/





                        /*------------------------------ Tabela MEMBROS_DONS ---------------------------*/


                        if ($input['dons']!="")  /*Array combo multiple*/
                        {
                                foreach($input['dons'] as $selected)
                                {
                                        if ($selected!="")
                                        {
                                                $whereForEach =
                                                [
                                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                    'empresas_id' =>  $this->dados_login->empresas_id,
                                                    'pessoas_id' => $pessoas->id,
                                                    'dons_id' => $selected
                                                ];

                                                if ($tipo_operacao=="create")  //novo registro
                                                {
                                                    $dons = new \App\Models\membros_dons();
                                                }
                                                else //Alteracao
                                                {
                                                    $dons = \App\Models\membros_dons::firstOrNew($whereForEach);
                                                }


                                                $valores =
                                                [
                                                    'pessoas_id' => $pessoas->id,
                                                    'dons_id' => $selected,
                                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                    'empresas_id' =>  $this->dados_login->empresas_id
                                                ];

                                                $dons->fill($valores)->save();
                                                $dons->save();

                                        }
                                }

                        }
                        /*------------------------------ FIM Tabela MEMBROS_DONS---------------------------*/





                        /*------------------------------ Tabela MEMBROS_HABILIDADES ---------------------------*/

                        if ($input['habilidades']!="")  /*Array combo multiple*/
                        {
                                foreach($input['habilidades'] as $selected)
                                {
                                        if ($selected!="")
                                        {
                                                $whereForEach =
                                                [
                                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                    'empresas_id' =>  $this->dados_login->empresas_id,
                                                    'pessoas_id' => $pessoas->id,
                                                    'habilidades_id' => $selected
                                                ];

                                                if ($tipo_operacao=="create")  //novo registro
                                                {
                                                    $habilidades = new \App\Models\membros_habilidades();
                                                }
                                                else //Alteracao
                                                {
                                                    $habilidades = \App\Models\membros_habilidades::firstOrNew($whereForEach);
                                                }

                                                $valores =
                                                [
                                                    'pessoas_id' => $pessoas->id,
                                                    'habilidades_id' => $selected,
                                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                    'empresas_id' =>  $this->dados_login->empresas_id
                                                ];

                                                $habilidades->fill($valores)->save();
                                                $habilidades->save();
                                        }
                                }
                        }
                        /*------------------------------ FIM Tabela MEMBROS_HABILIDADES---------------------------*/






                        /*------------------------------ Tabela MEMBROS_ATIVIDADES ---------------------------*/

                        if ($input['atividades']!="")  /*Array combo multiple*/
                        {
                                foreach($input['atividades'] as $selected)
                                {
                                        if ($selected!="")
                                        {
                                                $whereForEach =
                                                [
                                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                    'empresas_id' =>  $this->dados_login->empresas_id,
                                                    'pessoas_id' => $pessoas->id,
                                                    'atividades_id' => $selected
                                                ];

                                                if ($tipo_operacao=="create")  //novo registro
                                                {
                                                    $atividades = new \App\Models\membros_atividades();
                                                }
                                                else //Alteracao
                                                {
                                                    $atividades = \App\Models\membros_atividades::firstOrNew($whereForEach);
                                                }


                                                $valores =
                                                [
                                                    'pessoas_id' => $pessoas->id,
                                                    'atividades_id' => $selected,
                                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                    'empresas_id' =>  $this->dados_login->empresas_id
                                                ];

                                                $atividades->fill($valores)->save();
                                                $atividades->save();
                                        }
                                }
                        }
                        /*------------------------------ FIM Tabela MEMBROS_ATIVIDADES---------------------------*/





                        /*------------------------------ Tabela MEMBROS_MINISTERIOS ---------------------------*/

                        if ($input['ministerios']!="")  /*Array combo multiple*/
                        {
                                foreach($input['ministerios'] as $selected)
                                {
                                        if ($selected!="")
                                        {
                                                $whereForEach =
                                                [
                                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                    'empresas_id' =>  $this->dados_login->empresas_id,
                                                    'pessoas_id' => $pessoas->id,
                                                    'ministerios_id' => $selected
                                                ];

                                                if ($tipo_operacao=="create")  //novo registro
                                                {
                                                    $ministerios = new \App\Models\membros_ministerios();
                                                }
                                                else //Alteracao
                                                {
                                                    $ministerios = \App\Models\membros_ministerios::firstOrNew($whereForEach);
                                                }

                                                $valores =
                                                [
                                                    'pessoas_id' => $pessoas->id,
                                                    'ministerios_id' => $selected,
                                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                                    'empresas_id' =>  $this->dados_login->empresas_id
                                                ];

                                                $ministerios->fill($valores)->save();
                                                $ministerios->save();
                                        }
                                }
                        }
                        /*------------------------------ FIM Tabela MEMBROS_MINISTERIOS---------------------------*/




                        /*------------------------------ DADOS HIST. ECLESIASTICOS ------------------------------*/

                        if ($input['igreja_anterior']!="" || $input['fone_igreja_anterior']!=""
                            || $input['religioes']!="" || $input['cep_igreja_anterior']!="" || $input['endereco_igreja_anterior']!="" || $input['numero_igreja_anterior']!=""
                            || $input['cidade_igreja_anterior']!="" || $input['estado_igreja_anterior']!="" || $input['bairro_igreja_anterior']!="" || $input['data_batismo']!=""
                            || $input['igreja_batismo']!="" || $input['celebrador']!="" || $input['data_entrada']!="" || $input['data_saida']!="")

                        {

                                if ($tipo_operacao=="create")  //novo registro
                                {
                                    $historico = new \App\Models\membros_hist_eclesiasticos();
                                }
                                else //Alteracao
                                {
                                    $historico = \App\Models\membros_hist_eclesiasticos::firstOrNew($where);
                                }

                                $valores =
                                [
                                    'pessoas_id' => $pessoas->id,
                                    'empresas_id' =>  $this->dados_login->empresas_id,
                                    'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                    'igreja_anterior'  => $input['igreja_anterior'],
                                    'fone_igreja_anterior' => $input['fone_igreja_anterior'],
                                    'religioes_id' => ($input['religioes']=="" ? null : $input['religioes']),
                                    'cep_igreja_anterior' => $input['cep_igreja_anterior'],
                                    'endereco_igreja_anterior' => $input['endereco_igreja_anterior'],
                                    'numero_igreja_anterior' => $input['numero_igreja_anterior'],
                                    'bairro_igreja_anterior' => $input['bairro_igreja_anterior'],
                                    'complemento_igreja_anterior' => $input['complemento_igreja_anterior'],
                                    'cidade_igreja_anterior' => $input['cidade_igreja_anterior'],
                                    'estado_igreja_anterior' => $input['estado_igreja_anterior'],
                                    'data_batismo' => $formatador->FormatarData($input['data_batismo']),
                                    'igreja_batismo' => $input['igreja_batismo'],
                                    'celebrador' => $input['celebrador'],
                                    'data_entrada' => $formatador->FormatarData($input['data_entrada']),
                                    'data_saida'  => $formatador->FormatarData($input['data_saida']),
                                    'ata_entrada' => $input['ata_entrada'],
                                    'ata_saida' => $input['ata_saida'],
                                     'motivos_saida_id' => ($input['motivosaida']=="" ? null : $input['motivosaida']),
                                     'motivos_entrada_id' => ($input['motivo_entrada']=="" ? null : $input['motivo_entrada']),
                                     'observacoes_hist' => $input['observacoes_hist']

                                ];

                                $historico->fill($valores)->save();
                                $historico->save();
                            }
                        /*------------------------------ FIM - HIST. ECLESIASTICO ------------------------------*/

                  }

                  dd(base_path());

               /*-------------------------------------------------- UPLOAD IMAGEM */
               if ($image) //Imagem enviada
               {
                        /*Regras validação imagem*/
                        $rules = array (
                            'image' => 'image',
                            'image' => array('mimes:jpeg,jpg,png', 'max:2000kb'),
                        );

                        // Validar regras
                        $validator = \Validator::make([$image], $rules);

                        // Check to see if validation fails or passes
                        if ($validator->fails())
                        {
                            \Session::flash('flash_message_erro', 'Os dados foram salvos, porém houve erro no envio da imagem.');
                            return redirect($this->rota);
                        }
                        else
                        {

                            //caminho onde será gravado
                            $destinationPath = base_path() . '/public/images/persons';

                            // Cria uma instancia
                            $img = \Image::make($image->getRealPath());

                            //redimenciolna a imagem
                            $img->resize(320, 240);

                            //Salva a imagem no path definido, criando com nome da pessoa e a extencao original do arquivo
                            $img->save($destinationPath . '/' . str_replace(" ","", $input['razaosocial']) . '.' . $image->getClientOriginalExtension());

                        }
                 }

                 if ($input['mydata']!="") //Imagem da webcam
                 {
                     $encoded_data = $input['mydata'];

                     $binary_data = base64_decode($encoded_data);

                     //caminho onde será gravado
                     $destinationPath = base_path() . '/public/images/persons';

                     // Salva no path definido, alterando o nome da imagem com o nome da pessoa
                     $result = file_put_contents( $destinationPath . '/' . str_replace(" ","", $input['razaosocial']) . '_webcam.jpg', $binary_data );
                 }

                 /*-------------------------------------------------- FIM UPLOAD IMAGEM */

         });// ------------ FIM TRANSACTION

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
        //Ex; Pessoa fisica, habilita cpf e rg, juridica habilita CNPJ,  MEMBRO habilita dados especificos de membresia.
        $habilitar_interface = \App\Models\tipospessoas::findOrfail($id_tipo_pessoa);

        //Listagem grupos de pessoas (Para carregar dropdown )
        $grupos = \App\Models\grupospessoas::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->get();

        //Listagem de bancos (Para carregar dropdown )
        $bancos = \App\Models\bancos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome')->get();


        /*Pessoas e dados financeiros*/
        /*Usado dessa forma para formatar a data de nascimento */
        $sQuery = "select to_char(datanasc, 'DD-MM-YYYY') AS datanasc_formatada, pessoas.*, financ_pessoas.id as id_financ, financ_pessoas.bancos_id, financ_pessoas.endereco as endereco_cobranca, financ_pessoas.numero as numero_cobranca, financ_pessoas.bairro as bairro_cobranca, financ_pessoas.cidade as cidade_cobranca, financ_pessoas.estado as estado_cobranca, financ_pessoas.cep as cep_cobranca, financ_pessoas.complemento as complemento_cobranca";
        $sQuery .= " from pessoas left join financ_pessoas on financ_pessoas.pessoas_id = pessoas.id";
        $sQuery .= " where pessoas.id = ? ";
        $sQuery .= " and pessoas.empresas_id = ? ";
        $sQuery .= " and pessoas.empresas_clientes_cloud_id = ? ";
        $sQuery .= " order by razaosocial";

        $pessoas = \DB::select($sQuery, [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        /* FORMA ANTERIOR
        $pessoas = pessoas::select('pessoas.*', 'financ_pessoas.id as id_financ', 'financ_pessoas.bancos_id', 'financ_pessoas.endereco as endereco_cobranca', 'financ_pessoas.numero as numero_cobranca', 'financ_pessoas.bairro as bairro_cobranca', 'financ_pessoas.cidade as cidade_cobranca', 'financ_pessoas.estado as estado_cobranca', 'financ_pessoas.cep as cep_cobranca', 'financ_pessoas.complemento as complemento_cobranca')
        ->leftjoin('financ_pessoas', 'pessoas.id', '=', 'financ_pessoas.pessoas_id')
        ->where('pessoas.id', $id)
        ->where('pessoas.empresas_id', $this->dados_login->empresas_id)
        ->where('pessoas.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->get();
        */

        /*Se for MEMBRO, busca informacoes em tabelas especificas*/
        if ($habilitar_interface->membro)
        {
            /*Dados complementares de membros*/
            $membros_dados_pessoais  = \App\Models\membros_dados::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('pessoas_id', $id)
            ->get();

            /*Se nao retornar dados, inicializar variavel com uma colection qualquer*/
            if ($membros_dados_pessoais->count()==0)
            {
                $membros_dados_pessoais = $bancos; //Artificio para nao ter que tratar array vazia nas views
            }

            /* Membros Historico Eclesiastico */
            $sQuery  = " select pessoas_id, empresas_id, empresas_clientes_cloud_id, ";
            $sQuery .= " igreja_anterior, fone_igreja_anterior, religioes_id, cep_igreja_anterior, endereco_igreja_anterior, ";
            $sQuery .= " numero_igreja_anterior, bairro_igreja_anterior, complemento_igreja_anterior, cidade_igreja_anterior, estado_igreja_anterior, ";
            $sQuery .= " igreja_batismo, celebrador, ata_entrada, ata_saida, motivos_saida_id, motivos_entrada_id, observacoes_hist, ";
            $sQuery .= " to_char(data_entrada, 'DD-MM-YYYY') AS data_entrada, ";
            $sQuery .= " to_char(data_saida, 'DD-MM-YYYY') AS data_saida, ";
            $sQuery .= " to_char(data_batismo, 'DD-MM-YYYY') AS data_batismo ";
            $sQuery .= " from membros_historicos ";
            $sQuery .= " where membros_historicos.pessoas_id = ? ";
            $sQuery .= " and membros_historicos.empresas_id = ? ";
            $sQuery .= " and membros_historicos.empresas_clientes_cloud_id = ? ";

            $membros_historico  = \DB::select($sQuery, [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

            /*Se nao retornar dados, inicializar variavel com uma colection qualquer*/
            if ($membros_historico==null)
            {
                $membros_historico = $bancos; //Artificio para nao ter que tratar array vazia nas views
            }

            /*
            $membros_filhos  = \App\Models\membros_filhos::select('filhos_id as id', 'filhos_id', 'nome_filho', 'sexo', 'data_nasc', 'data_falecimento', 'status_id', 'estadocivil_id')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('pessoas_id', $id)
            ->get();
            */

            /*Membros Filhos*/
            $sQuery  = " select membros_filhos.id as id_seq,  filhos_id as id, filhos_id, nome_filho, sexo, status_id, estadocivil_id, estados_civis.id as id_estadocivil,  estados_civis.nome as desc_estcivil, status.id as id_status, status.nome as desc_status, ";
            $sQuery .= " to_char(data_nasc, 'DD/MM/YYYY') AS data_nasc, ";
            $sQuery .= " to_char(data_falecimento, 'DD/MM/YYYY') AS data_falecimento ";
            $sQuery .= " from membros_filhos ";
            $sQuery .= " left join estados_civis on estados_civis.id = membros_filhos.estadocivil_id and estados_civis.clientes_cloud_id = membros_filhos.empresas_clientes_cloud_id";
            $sQuery .= " left join status on status.id = membros_filhos.status_id and status.clientes_cloud_id = membros_filhos.empresas_clientes_cloud_id";
            $sQuery .= " where membros_filhos.pessoas_id = ? ";
            $sQuery .= " and membros_filhos.empresas_id = ? ";
            $sQuery .= " and membros_filhos.empresas_clientes_cloud_id = ? ";

            $membros_filhos = \DB::select($sQuery, [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

            /*Se nao retornar dados, inicializar variavel com uma colection qualquer*/
            //if ($membros_filhos==null)
            //{
                //$membros_filhos = $bancos; //Artificio para nao ter que tratar array vazia nas views
            //}


            /*Situacoes Membros*/
            $membros_situacoes  = \App\Models\membros_situacoes::select('situacoes_id as id')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('pessoas_id', $id)
            ->get();


            /*Dados Profissionais Membros*/
            $membros_profissionais  = \App\Models\membros_profissionais::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('pessoas_id', $id)
            ->get();

            /*Se nao retornar dados, inicializar variavel com uma colection qualquer*/
            if ($membros_profissionais->count()==0)
            {
                $membros_profissionais = $bancos; //Artificio para nao ter que tratar array vazia nas views
            }

            /*Dados de Familiares*/
            /*
            $membros_familiares  = \App\Models\membros_familiares::where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('pessoas_id', $id)
            ->get();
            */
            $sQuery = " select pessoas_id, empresas_id, empresas_clientes_cloud_id, conjuge_id, nome_conjuge, ";
            $sQuery .= " to_char(data_falecimento, 'DD-MM-YYYY') AS data_falecimento, ";
            $sQuery .= " to_char(data_casamento, 'DD-MM-YYYY') AS data_casamento, ";
            $sQuery .= " to_char(data_nasc, 'DD-MM-YYYY') AS data_nasc,";
            $sQuery .= " to_char(data_falecimento_pai, 'DD-MM-YYYY') AS data_falecimento_pai, ";
            $sQuery .= " to_char(data_falecimento_mae, 'DD-MM-YYYY') AS data_falecimento_mae, ";
            $sQuery .= " status_id, profissoes_id, igreja_casamento, pai_id, mae_id, nome_pai, nome_mae, status_pai_id, status_mae_id ";
            $sQuery .= " from membros_familiares";
            $sQuery .= " where membros_familiares.pessoas_id = ? ";
            $sQuery .= " and membros_familiares.empresas_id = ? ";
            $sQuery .= " and membros_familiares.empresas_clientes_cloud_id = ? ";

            $membros_familiares  = \DB::select($sQuery, [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

            /*Se nao retornar dados, inicializar variavel com uma colection qualquer*/
            if ($membros_familiares==null)
            {
                $membros_familiares = $bancos; //Artificio para nao ter que tratar array vazia nas views
            }

            /*Dados Formacoes*/
            $membros_formacoes  = \App\Models\membros_formacoes::select('formacoes_id as id')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('pessoas_id', $id)
            ->get();


            /*Dados idiomas*/
            $membros_idiomas  = \App\Models\membros_idiomas::select('idiomas_id as id')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('pessoas_id', $id)
            ->get();


           /*Dons*/
            $membros_dons  = \App\Models\membros_dons::select('dons_id as id')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('pessoas_id', $id)
            ->get();


            /*habilidades*/
            $membros_habilidades  = \App\Models\membros_habilidades::select('habilidades_id as id')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('pessoas_id', $id)
            ->get();

            /*atividades*/
            $membros_atividades  = \App\Models\membros_atividades::select('atividades_id as id')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('pessoas_id', $id)
            ->get();

            /*ministerios*/
            $membros_ministerios  = \App\Models\membros_ministerios::select('ministerios_id as id')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('pessoas_id', $id)
            ->get();

        }


        if ($habilitar_interface->membro) /*Somente se tipo de pessoa for MEMBRO*/
        {
                /*
                Para preencher combos Dados eclesiasticos
                */
                $familias = \App\Models\pessoas::select('razaosocial as nome', 'id')->where(['empresas_id' => $this->dados_login->empresas_id, 'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id])->orderBy('razaosocial','ASC')->get();
                $igrejas = \App\Models\igrejas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
                $situacoes = \App\Models\situacoes::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
                $idiomas = \App\Models\idiomas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
                $status = \App\Models\status::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
                $profissoes = \App\Models\profissoes::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
                $ramos = \App\Models\ramos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
                $cargos = \App\Models\cargos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
                $graus = \App\Models\graus::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
                $formacoes = \App\Models\areas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
                $estadoscivis = \App\Models\civis::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
                $disponibilidades = \App\Models\disponibilidades::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
                $dons = \App\Models\dons::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
                $habilidades = \App\Models\habilidades::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
                $religioes = \App\Models\religioes::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
                $atividades = \App\Models\atividades::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
                $ministerios = \App\Models\ministerios::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
                $motivos = \App\Models\tiposmovimentacao::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->orderBy('nome','ASC')->get();
                /* FIM Para preencher combos Dados eclesiasticos*/


                return view($this->rota . '.edit',
                [
                    'grupos' =>$grupos,
                    'preview' => $preview,
                    'interface' => $habilitar_interface,
                    'bancos' => $bancos,
                    'membros_dados_pessoais' => $membros_dados_pessoais,
                    'pessoas' => $pessoas,
                    'igrejas' => $igrejas,
                    'situacoes' => $situacoes,
                    'status' => $status,
                    'familias' => $familias,
                    'idiomas' => $idiomas,
                    'profissoes' => $profissoes,
                    'ramos' => $ramos,
                    'graus' => $graus,
                    'formacoes' => $formacoes,
                    'religioes' => $religioes,
                    'disponibilidades' => $disponibilidades,
                    'dons' => $dons,
                    'habilidades' => $habilidades,
                    'estadoscivis' => $estadoscivis,
                    'motivos' => $motivos,
                    'atividades' => $atividades,
                    'ministerios' => $ministerios,
                    'cargos' => $cargos,
                    'membros_situacoes' =>$membros_situacoes,
                    'membros_formacoes' =>$membros_formacoes,
                    'membros_idiomas' =>$membros_idiomas,
                    'membros_atividades' =>$membros_atividades,
                    'membros_historico' =>$membros_historico,
                    'membros_ministerios' =>$membros_ministerios,
                    'membros_familiares' =>$membros_familiares,
                    'membros_dons' =>$membros_dons,
                    'membros_filhos' => $membros_filhos,
                    'membros_habilidades' =>$membros_habilidades,
                    'membros_profissionais' => $membros_profissionais
                ]);

        }
        else
        {

                return view($this->rota . '.edit',
                [
                    'grupos' =>$grupos,
                    'preview' => $preview,
                    'interface' => $habilitar_interface,
                    'bancos' => $bancos,
                    'pessoas' => $pessoas
                ]);

        }

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
            /*Excluirá também todas tabelas relacionadas, pois existe integridade referencial e DELETE CASCADE ativada*/
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