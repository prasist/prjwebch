<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\controle_atividades;
use URL;
use Auth;
use Input;
use Gate;

class ControleAtividadesController extends Controller
{

    public function __construct()
    {

        $this->rota = "controle_atividades"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        /*Instancia a classe de funcoes (Data, valor, etc)*/
        $this->formatador = new  \App\Functions\FuncoesGerais();

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

        $celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view($this->rota . '.atualizacao',
            [
                'preview'=>'false',
                'tipo_operacao'=>'incluir',
                'celulas'=>$celulas,
                'participantes'=>''
             ]);

    }

  public function salvar($request, $id, $tipo_operacao)
  {
        $input = $request->except(array('_token')); //não levar o token

/*

     controle_questions

      empresas_id
      empresas_clientes_cloud_id
      controle_atividades_id
      questionarios_id
      resposta


      controle_visitantes

      empresas_id
      empresas_clientes_cloud_id
      controle_atividades_id
      nome
      fone
      email
      pessoas_id

*/

        $this->validate($request, [
            'celulas' => 'required',
            'mes' => 'required',
            'ano' => 'required',
            'data_encontro' => 'required',
        ]);


         $descricao_celula = explode("|", $input["celulas"]);

         $dados = controle_atividades::firstOrNew(['id'=>$id]);
         $dados->empresas_clientes_cloud_id = $this->dados_login->empresas_clientes_cloud_id;
         $dados->empresas_id = $this->dados_login->empresas_id;
         $dados->celulas_id = $descricao_celula[0];
         $dados->dia = $input['data_encontro'];
         $dados->mes = $input['mes'];
         $dados->ano = $input['ano'];
         $dados->hora_inicio = $input['hora_inicio'];
         $dados->hora_fim = $input['hora_fim'];
         $dados->valor_oferta = ($input['valor_oferta']=="" ? null : $input['valor_oferta']);
         $dados->obs = $input['observacao'];
         $dados->lider_pessoas_id = substr($descricao_celula[1],0,9);
         $dados->save();

         $id_atividade = $dados->id; //Pega ID recem criado

         //Controle de presenca
         if ($id_atividade!="")
         {

                $i_index=0; /*initialize*/

                foreach($input['id_obs_membro'] as $selected)
                {

                            $whereForEach =
                            [
                                'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                'empresas_id' =>  $this->dados_login->empresas_id,
                                'controle_atividades_id' => $id_atividade,
                                'pessoas_id' => $selected
                            ];

                            $controle_presencas = \App\Models\controle_presencas::firstOrNew($whereForEach);

                            //find if the current index exists in array of presenca
                            //if found, set presenca "S" (Yes)
                            if (array_key_exists($i_index, $input['presenca']))
                            {
                                $presenca = "S"; //Yes
                            }
                            else
                            {
                                $presenca = "N"; //No
                            }


                            $valores =
                            [
                                'pessoas_id' => $selected,
                                'empresas_id' =>  $this->dados_login->empresas_id,
                                'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id,
                                'controle_atividades_id' => $id_atividade,
                                'presenca_simples' => $presenca,
                                'observacao' => ($input['obs_membro'][$i_index]=="" ? null : $input['obs_membro'][$i_index])
                            ];

                            $controle_presencas->fill($valores)->save();
                            $controle_presencas->save();

                            $i_index = $i_index + 1; //Incrementa sequencia do array para pegar proximos campos (se houver)

                }

          }

          return  $id_atividade;

  }

  public function buscar($cell_id, $day, $month, $year)
  {

        $dados = controle_atividades::select('id', 'celulas_id', 'hora_inicio', 'hora_fim', 'valor_oferta', 'obs')
        ->where('empresas_id', $this->dados_login->empresas_id)
        ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('celulas_id', $cell_id)
        ->where('dia', $day)
        ->where('mes', $month)
        ->where('ano', $year)
        ->get();

        //return \Datatables::of($dados)->make(true);
        return $dados;

  }

    //Criar novo registro
    public function create()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        $controle_atividades = \DB::select('select id, descricao_concatenada as nome from view_controle_atividades_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        $celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view($this->rota . '.atualizacao',
            [
                'preview'=>'false',
                'tipo_operacao'=>'incluir',
                'celulas'=>$celulas,
                'controle_atividades'=>$controle_atividades,
                'participantes'=>''
            ]);

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

        //Controle de Atividades
        $dados = controle_atividades::select('controle_atividades.id', 'celulas_id', 'hora_inicio', 'hora_fim', 'valor_oferta', 'controle_atividades.obs', 'dia', 'mes', 'ano', 'celulas.dia_encontro', 'encontro_encerrado')
        ->join('celulas', 'celulas.id', '=', 'controle_atividades.celulas_id')
        ->where('controle_atividades.empresas_id', $this->dados_login->empresas_id)
        ->where('controle_atividades.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('controle_atividades.id', $id)
        ->get();

        //members of cell
        $participantes = \App\Models\celulaspessoas::select('pessoas.id', 'pessoas.razaosocial', 'controle_presencas.observacao', 'controle_presencas.presenca_simples')
        ->join('pessoas', 'pessoas.id', '=', 'celulas_pessoas.pessoas_id')
        ->leftjoin('controle_presencas', 'controle_presencas.pessoas_id', '=', 'celulas_pessoas.pessoas_id')
        ->leftjoin('controle_atividades', 'controle_atividades.id', '=', 'controle_presencas.controle_atividades_id')
        ->where('celulas_pessoas.empresas_id', $this->dados_login->empresas_id)
        ->where('celulas_pessoas.empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
        ->where('celulas_pessoas.celulas_id', $dados[0]->celulas_id)
        ->orderBy('pessoas.razaosocial')
        ->get();


        //Load all dates by day of week (mondays, tuesdays, etc)
        $dates_of_meeting = $this->return_dates($dados);

        $celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        return view($this->rota . '.atualizacao',
            [
                'preview'=>'false',
                'tipo_operacao'=>'editar',
                'celulas'=>$celulas,
                'dados'=>$dados,
                'dates_of_meeting'=>$dates_of_meeting,
                'participantes'=>$participantes
             ]);

    }


   //Return all dates in a month by dayOfWeek
   private function return_dates($dados)
   {

        $var_month = $dados[0]->mes;
        $var_year = $dados[0]->ano;
        $var_dayOfWeek = $dados[0]->dia_encontro;
        $var_counting_days = cal_days_in_month(CAL_GREGORIAN, $var_month, $var_year); //days of month

        $dini = mktime(0,0,0,$var_month,1,$var_year);
        $dfim = mktime(0,0,0,$var_month,$var_counting_days,$var_year);

        $return_d = array();

        while($dini <= $dfim) //Enquanto uma data for inferior a outra
        {
            $dt = date("d/m/Y",$dini); //Convertendo a data no formato dia/mes/ano
            $diasemana = date("w", $dini);

            if($diasemana == $var_dayOfWeek)
            { // [0 Domingo] - [1 Segunda] - [2 Terca] - [3 Quarta] - [4 Quinta] - [5 Sexta] - [6 Sabado]
                array_push($return_d, $dt);
            }

            $dini += 86400; // Adicionando mais 1 dia (em segundos) na data inicial
        }

        return ($return_d);

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
            $dados = controle_atividades::findOrfail($id);
            $dados->delete();
            return redirect($this->rota);
    }

}