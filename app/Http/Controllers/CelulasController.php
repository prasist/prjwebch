<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\celulas;
use URL;
use Auth;
use Input;
use Gate;

class CelulasController extends Controller
{

    public function __construct()
    {

        $this->rota = "celulas"; //Define nome da rota que será usada na classe
        $this->middleware('auth');

        /*Instancia a classe de funcoes (Data, valor, etc)*/
        $this->formatador = new  \App\Functions\FuncoesGerais();

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']))
        {
            $this->dados_login = \Session::get('dados_login');
        }

    }

    public function buscar_dados($id)
    {

            $buscar = \App\Models\celulas::select('dia_encontro')
            ->where('empresas_clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)
            ->where('empresas_id', $this->dados_login->empresas_id)
            ->where('id', $id)
            ->get();


            if ($buscar)
            {
                return $buscar[0]->dia_encontro;
            }
            else
            {
                return ""; //Retorna vazio
            }




    }

    public function dashboard()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        //Verificar se foi cadastrado os dados da igreja
        if (\App\Models\usuario::find(Auth::user()->id))
        {
              //Busca ID do cliente cloud e ID da empresa
              $this->dados_login = \App\Models\usuario::find(Auth::user()->id);
              return view($this->rota . '.dashboard', ['dados'=>'']);
        }

    }

   //Return all dates in a month by dayOfWeek
   public function return_dates($id, $var_month, $var_year)
   {

        $var_dayOfWeek = $this->buscar_dados($id); //pega dia do encontro da celula

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



    //Exibir listagem
    public function index()
    {

            if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
            {
                  return redirect('home');
            }

            $dados = \DB::select('select * from view_celulas_simples where  empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

            //Listagem de pessoas
            return view($this->rota . '.index',compact('dados'));

    }

  public function salvar($request, $id, $tipo_operacao)
  {
        $input = $request->except(array('_token', 'ativo')); //não levar o token

        $this->validate($request, [
            'pessoas' => 'required',
            'dia_encontro' => 'required',
            'horario' => 'required',
        ]);


        if ($tipo_operacao=="create") //novo registro
        {
             $dados = new celulas();
        }
        else //update
        {
             $dados = celulas::findOrfail($id);
        }

         $dados->dia_encontro = $input['dia_encontro'];

         if ($input["horario"]<"12:00") //bom dia
         {
                $dados->turno = "M";
         }
         else if ($input["horario"]>"12:00" && $input["horario"]<"18:00") //boa tarde
         {
                $dados->turno = "T";
         }
         else if ($input["horario"]>"18:00") //boa noite
         {
                $dados->turno = "N";
         }

         //$dados->turno = $input['turno'];
         $dados->regiao = $input['regiao'];
         $dados->horario = $input['horario'];
         $dados->horario2 = $input['horario2'];
         $dados->segundo_dia_encontro = $input['segundo_dia_encontro'];
         $dados->obs = $input['obs'];
         $dados->email_grupo = $input['email_grupo'];
         $dados->faixa_etaria_id = ($input['faixa_etaria']=="" ? null : $input['faixa_etaria']);
         $dados->publico_alvo_id = ($input['publico_alvo']=="" ? null : $input['publico_alvo']);
         $dados->nome = $input['nome'];
         $dados->cor = $input['cor'];
         $dados->data_previsao_multiplicacao = $input['data_previsao_multiplicacao'];
         $dados->celulas_nivel1_id  = ($input['nivel1']=="" ? null : $input['nivel1']);
         $dados->celulas_nivel2_id  = ($input['nivel2']=="" ? null : $input['nivel2']);
         $dados->celulas_nivel3_id  = ($input['nivel3']=="" ? null : $input['nivel3']);
         $dados->celulas_nivel4_id  = ($input['nivel4']=="" ? null : $input['nivel4']);
         $dados->celulas_nivel5_id  = ($input['nivel5']=="" ? null : $input['nivel5']);
         $dados->lider_pessoas_id  = ($input['pessoas']=="" ? null : substr($input['pessoas'],0,9));
         $dados->vicelider_pessoas_id  = ($input['vicelider_pessoas_id']=="" ? null : substr($input['vicelider_pessoas_id'],0,9));
         $dados->suplente1_pessoas_id  = ($input['suplente1_pessoas_id']=="" ? null : substr($input['suplente1_pessoas_id'],0,9));
         $dados->suplente2_pessoas_id  = ($input['suplente2_pessoas_id']=="" ? null : substr($input['suplente2_pessoas_id'],0,9));
         $dados->empresas_clientes_cloud_id = $this->dados_login->empresas_clientes_cloud_id;
         $dados->empresas_id  = $this->dados_login->empresas_id;
         $dados->celulas_pai_id = ($input['celulas_pai_id']=="" ? null : $input['celulas_pai_id']);
         $dados->origem = ($input['origem']=="" ? null : $input['origem']);

         if ($input["origem"]=="1")  //Multiplicacao
         {
                $dados->data_multiplicacao = date('Y-m-d');
         }

         $dados->qual_endereco = ($input['local']=="" ? null : $input['local']);
         $dados->data_inicio = ($input["data_inicio"]!="" ? $this->formatador->FormatarData($input["data_inicio"]) : date('Y-m-d'));
         $dados->save();
         return  $dados->id;
  }

    //Criar novo registro
    public function create()
    {

        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.' . $this->rota))==false)
        {
              return redirect('home');
        }

        $publicos = \App\Models\publicos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
        $faixas = \App\Models\faixas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
        $celulas = \DB::select('select id, descricao_concatenada as nome from view_celulas_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        $vazio = \App\Models\tabela_vazia::get();

        /*Busca NIVEL5*/
        $view5 = \DB::select('select * from view_celulas_nivel5 v5 where v5.empresas_id = ? and v5.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        //return view($this->rota . '.registrar', ['nivel5'=>$view5, 'publicos'=>$publicos, 'faixas'=>$faixas]);
        return view($this->rota . '.atualizacao', ['participantes'=>'', 'preview'=>'false', 'nivel5'=>$view5, 'publicos'=>$publicos, 'faixas'=>$faixas, 'tipo_operacao'=>'incluir', 'dados'=>$vazio, 'celulas'=>$celulas, 'vinculos'=>$vazio, 'total_vinculos'=>'0']);

    }

/*
* Grava dados no banco
*
*/
    public function store(\Illuminate\Http\Request  $request)
    {
            $id_gerado = $this->salvar($request, "", "create");
            \Session::flash('flash_message', 'Dados Atualizados com Sucesso!!!');

            if ($request["quero_incluir_participante"]=="sim")
            {
                return redirect('celulaspessoas/registrar/' . $id_gerado);
            }
            else
            {
                return redirect($this->rota);
            }

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

        $publicos = \App\Models\publicos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
        $faixas = \App\Models\faixas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

        /*Busca NIVEL5*/
        $view5  = \DB::select('select * from view_celulas_nivel5 v5 where v5.empresas_id = ? and v5.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        /*Busca */
        $celulas = \DB::select('select id, descricao_concatenada as nome, tot from view_celulas_simples  where empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        /*Busca NIVEL4*/
        $dados = \DB::select("select to_char(to_date(data_previsao_multiplicacao, 'yyyy-MM-dd'), 'DD/MM/YYYY') AS data_previsao_multiplicacao_format, to_char(to_date(data_inicio, 'yyyy-MM-dd'), 'DD/MM/YYYY') AS data_inicio_format, * from view_celulas  where id = ? and empresas_id = ? and empresas_clientes_cloud_id = ? ", [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        $participantes = \DB::select('select * from view_celulas_pessoas where celulas_id = ? and empresas_id = ? and empresas_clientes_cloud_id = ? ', [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
        //$dados = \DB::select('select distinct celulas_id, lider_pessoas_id, descricao_lider  as nome, tot from view_celulas_pessoas_participantes where  empresas_id = ? and empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        //Busca celulas filhas
        $vinculos = \DB::select('select * from view_celulas_simples  where celulas_pai_id = ?  and empresas_id = ? and empresas_clientes_cloud_id = ? ', [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        if  ($vinculos==null) //Se nao encontrar, gera controller vazio
        {
            $vinculos = \App\Models\tabela_vazia::get();
            $total_vinculos = 0;
        }
        else
        {
            $temp = \DB::select('select count(*) as tot from view_celulas  where celulas_pai_id = ?  and empresas_id = ? and empresas_clientes_cloud_id = ? ', [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            $total_vinculos =$temp[0]->tot;
        }

        //return view($this->rota . '.edit', ['dados' =>$dados, 'preview' => $preview,  'nivel5' =>$view5, 'publicos'=>$publicos, 'faixas'=>$faixas]);
        return view($this->rota . '.atualizacao', ['participantes'=>$participantes, 'dados' =>$dados, 'preview' => $preview,  'nivel5' =>$view5, 'publicos'=>$publicos, 'faixas'=>$faixas, 'tipo_operacao'=>'editar', 'vinculos'=>$vinculos, 'celulas'=>$celulas, 'total_vinculos'=>$total_vinculos]);

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

           if ($request["quero_incluir_participante"]=="sim") //quando for edicao com membros ja incluidos
            {
                return redirect('celulaspessoas/' . $id . '/edit');
            }
            else if ($request["quero_incluir_participante"]=="simnovo") //nenhum membro inserido ainda...
            {
                 return redirect('celulaspessoas/registrar/' . $id);
            }
            else //nao quer incluir participante agora
            {
                 return redirect($this->rota);
            }
    }


    /**
     * Excluir registro do banco.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $dados = celulas::findOrfail($id);
            $dados->delete();
            return redirect($this->rota);
    }

}