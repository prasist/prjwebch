<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\usuario;
use App\Http\Controllers\Controller;
use URL;
use Auth;
use Input;
use Gate;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->rota = "home"; //Define nome da rota que será usada na classe
        //retirado gate
    }


     public function confirm($codigo)
    {

        if(!$codigo)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user = User::whereConfirmationCode($codigo)->first();

        if ( ! $user)
        {
            throw new InvalidConfirmationCodeException;
        }

        $user->confirmed = 1;
        $user->confirmation_code = null;
        $user->save();

        \Session::flash('flash_message', 'Conta Verificada com Sucesso!');

        return redirect('home');  //Ainda nao cadastrou, solicitar o cadastro

    }

    public function jalogado()
    {
            Auth::logout();
            \Session::flush();
            return view('home', ['erros'=>'Usuário já logado em outra máquina']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(\Illuminate\Http\Request  $request)
    {

        //retirado da construct
        //Validação de permissão de acesso a pagina
        //if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        //{
            //$this->dados_login = \Session::get('dados_login');
        //}

        //Verificar se foi cadastrado os dados da igreja
        if (usuario::find(Auth::user()->id))
       {

            //Busca ID do cliente cloud e ID da empresa
            $this->dados_login = usuario::find(Auth::user()->id);


            /*VALIDAÇÃO PARA LOGIN UNICO.*/
            $log = \App\Models\log_users::find(Auth::user()->id);

            if($log) //Achou
            {

               \Session::put('ultimo_acesso', $log->data_acesso);
               \Session::put('ip', $log->ip);

               if (\Session::get('token')=="")
               {
                   $token_acesso = str_random(30);
                   $log->token = $token_acesso;
                   \Session::put('token', $token_acesso);
               }
               else if (\Session::get('token')!=$log->token)
               {
                    //dd('já logado :' . \Session::get('token'));
                    return redirect('userlogged')->withErrors(['msg', 'Usuário já logado em outra máquina.']);
               }

               $log->data_acesso =  date('Y-m-d h:i:s');
               $log->ip = $request->ip();
               $log->save();

            }
            else //Primeiro acesso
            {
                $token_acesso = str_random(30);

                $log = new \App\Models\log_users();
                $log->id = Auth::user()->id;
                $log->token = $token_acesso;
                $log->data_acesso =  date('Y-m-d h:i:s');
                $log->empresas_id = $this->dados_login->empresas_id;
                $log->empresas_clientes_cloud_id = $this->dados_login->empresas_clientes_cloud_id;
                $log->ip = $request->ip();
                $log->save();
                \Session::put('token', $token_acesso);
                \Session::put('ultimo_acesso', $log->data_acesso);
                \Session::put('ip', $log->ip);
            }


            \Session::put('titulo', 'Home | Dashboard');
            \Session::put('subtitulo', '');
            \Session::put('route', '');
            \Session::put('dados_login', $this->dados_login);
            \Session::put('tour_rapido', $this->dados_login->tutorial);
            \Session::put('tour_visaogeral', $this->dados_login->tutorial_visaogeral);
            \Session::put('admin', $this->dados_login->admin);

            if (Auth::user()->membro!="S")
            {
                        /*
                        Busca Configuracao de labels para menu de estrutura de celulas
                        */
                        $menu_celulas = \App\Models\configuracoes::select('id', 'celulas_nivel1_label', 'celulas_nivel2_label', 'celulas_nivel3_label', 'celulas_nivel4_label', 'celulas_nivel5_label')
                                ->where('empresas_id', $this->dados_login->empresas_id)
                                ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
                                ->get();

                        if ($menu_celulas)
                        {
                             \Session::put('nivel1', $menu_celulas[0]->celulas_nivel1_label);
                             \Session::put('nivel2', $menu_celulas[0]->celulas_nivel2_label);
                             \Session::put('nivel3', $menu_celulas[0]->celulas_nivel3_label);
                             \Session::put('nivel4', $menu_celulas[0]->celulas_nivel4_label);
                             \Session::put('nivel5', $menu_celulas[0]->celulas_nivel5_label);
                        }

                        $where =
                        [
                            'empresas_id' => $this->dados_login->empresas_id,
                            'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id
                        ];

                        //-------------------Functions no POSTGRES
                        //Total de registro na tabela pessoas
                        $retorno = \DB::select('select  fn_total_pessoas(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
                        $total_pessoas = $retorno[0]->fn_total_pessoas;

                        //Total de membros. Verifica-se no cadastro de tipo de pessoas o registro que contenha a aba membros configurada
                        $retorno = \DB::select('select  fn_total_membros(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
                        $total_membros = $retorno[0]->fn_total_membros;

                        //Total de aniversariantes no mes
                        $retorno = \DB::select('select  fn_total_niver(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
                        $total_aniversariantes = $retorno[0]->fn_total_niver;

                        $retorno = \DB::select('select  fn_total_inativos(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
                        $total_inativos = $retorno[0]->fn_total_inativos;

                        $retorno = \DB::select('select  fn_total_celulas(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
                        $total_celulas = $retorno[0]->fn_total_celulas;

                        $retorno = \DB::select('select  fn_total_participantes(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
                        $total_participantes = $retorno[0]->fn_total_participantes;

                        $retorno = \DB::select('select  fn_total_familias(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
                        $total_familias = $retorno[0]->fn_total_familias;

                        //----------------- FIM Functions POSTGRES

                        $pessoas_tipos = \DB::select('select * from view_total_pessoas_tipo vw where vw.empresas_id = ? and vw.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
                        $pessoas_sexo = \DB::select('select * from view_total_pessoas_sexo vw where vw.empresas_id = ? and vw.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

                        $pessoas_status = \DB::select('select * from view_total_pessoas_status vw where vw.empresas_id = ? and vw.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
                        $pessoas_estadoscivis = \DB::select('select * from view_total_pessoas_estadoscivis vw where vw.empresas_id = ? and vw.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

                        $celulas_faixas = \DB::select('select * from view_total_celulas_faixa_etaria vw where vw.empresas_id = ? and vw.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
                        $celulas_publicos = \DB::select('select * from view_total_celulas_publico_alvo vw where vw.empresas_id = ? and vw.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

            }
            else
            {
                    //busca informacoes do membro
                    $membro = \DB::select('select * from view_celulas_pessoas vp where email_membro = ? and vp.empresas_id = ? and vp.empresas_clientes_cloud_id = ? ', [Auth::user()->email, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

                    $vazio = \App\Models\tabela_vazia::get();

                    if ($membro)
                    {
                          $materiais = \DB::select('select * from controle_atividades ca inner join controle_materiais cm on ca.id = cm.controle_atividades_id and ca.empresas_id = cm.empresas_id and ca.empresas_clientes_cloud_id = cm.empresas_clientes_cloud_id where ca.celulas_id = ? and ca.empresas_id = ? and ca.empresas_clientes_cloud_id = ? ', [$membro[0]->id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
                    }else {
                        $materiais = $vazio;
                    }

            }

            if (Auth::user()->membro=="S")
            {
                  return view('pages.membros', ['membro'=>$membro, 'materiais'=>$materiais]);
            }
            else
            {

                return view('pages.dashboard',
                    [
                        'total_pessoas' => $total_pessoas,
                        'total_membros' => $total_membros,
                        'total_aniversariantes' => $total_aniversariantes,
                        'total_inativos' => $total_inativos,
                        'pessoas_tipos'=>$pessoas_tipos,
                        'total_celulas'=>$total_celulas,
                        'total_participantes'=>$total_participantes,
                        'total_familias'=>$total_familias,
                        'pessoas_sexo'=>$pessoas_sexo,
                        'pessoas_status'=>$pessoas_status,
                        'pessoas_estadoscivis'=>$pessoas_estadoscivis,
                        'celulas_faixas'=>$celulas_faixas,
                        'celulas_publicos'=>$celulas_publicos
                    ]);
            }

        }
        else
        {
            return view('pages.dashboard_blank');  //Ainda nao cadastrou, solicitar o cadastro
        }

    }
}
