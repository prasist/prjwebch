<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use Auth;
use Input;
use Gate;

class RelEncontroController extends Controller
{

    public function __construct()
    {

        $this->rota = "relencontro"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');

           /*Instancia a classe de funcoes (Data, valor, etc)*/
           $this->formatador = new  \App\Functions\FuncoesGerais();

            //Verificar se usuario logado é LIDER
            $this->lider_logado = $this->formatador->verifica_se_lider();


            //Verifica se é alguém da liderança (Lider de Rede, Area, Coordenador, Supervisor, etc)
            $this->lideranca = $this->formatador->verifica_se_lideranca();

            $this->id_lideres="";

            //Preenche variavel com os lideres abaixo da hierarquia
            if ($this->lideranca!=null)
            {
                 foreach ($this->lideranca as $item) {
                    if ($this->id_lideres=="") {
                       $this->id_lideres =  $item->id_lideres;
                    } else {
                       $this->id_lideres .=  ", " . $item->id_lideres;
                    }
                 }
            }
        }

    }

    //Exibir listagem
    public function index()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

            $publicos = \App\Models\publicos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
            $faixas = \App\Models\faixas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

            /*Busca Lideres*/
            //$lideres = \DB::select('select * from view_lideres where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

           $strSql  = " SELECT * FROM view_lideres ";
           $strSql .= " WHERE  empresas_id = " . $this->dados_login->empresas_id;
           $strSql .= " AND empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id;

           //Trazer somente celula do lider logado... ou
            if ($this->lider_logado!=null) {
                  if ($this->id_lideres!="") {
                      $strSql .= " AND id IN (" . $this->lider_logado[0]->lider_pessoas_id . ", " . $this->id_lideres . ")";
                  } else {
                      $strSql .= " AND id IN (" . $this->lider_logado[0]->lider_pessoas_id . ")";
                  }
            } else { //verificar se é alguém da lideranca (supervisor, coordenador, etc) e trazer somente as celulas subordinadas

                  if ($this->id_lideres!="") {
                      $strSql .= " AND id IN (" . $this->id_lideres . ")";
                  }
            }

           $lideres = \DB::select($strSql);


            /*Busca vice - Lideres*/
            $vice_lider = \DB::select('select * from view_vicelideres where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

            $var_download="";
            $var_mensagem="";

            /*Busca Niveis*/
            $view1 = \DB::select('select * from view_celulas_nivel1 v1 where v1.empresas_id = ? and v1.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            $view2 = \DB::select('select * from view_celulas_nivel2 v2 where v2.empresas_id = ? and v2.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            $view3 = \DB::select('select * from view_celulas_nivel3 v3 where v3.empresas_id = ? and v3.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            $view4 = \DB::select('select * from view_celulas_nivel4 v4 where v4.empresas_id = ? and v4.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            $view5 = \DB::select('select * from view_celulas_nivel5 v5 where v5.empresas_id = ? and v5.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

            $celulas_faixas = \DB::select('select * from view_total_celulas_faixa_etaria vw where vw.empresas_id = ? and vw.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            $celulas_publicos = \DB::select('select * from view_total_celulas_publico_alvo vw where vw.empresas_id = ? and vw.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

              //Busca ID do cliente cloud e ID da empresa
              $this->dados_login = \App\Models\usuario::find(Auth::user()->id);
              return view($this->rota . '.index',
                 [
                  'dados'=>'',
                  'celulas_faixas'=>$celulas_faixas,
                  'celulas_publicos'=>$celulas_publicos,
                  'vice_lider'=>$vice_lider,
                   'nivel1'=>$view1,
                   'nivel2'=>$view2,
                   'nivel3'=>$view3,
                   'nivel4'=>$view4,
                   'nivel5'=>$view5,
                   'publicos'=>$publicos,
                   'faixas'=>$faixas,
                   'lideres'=>$lideres,
                   'var_download'=>'',
                   'var_mensagem'=>''
                ]);
    }

}