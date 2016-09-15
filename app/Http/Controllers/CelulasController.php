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
        $this->sequencia = 0;

        /*Instancia a classe de funcoes (Data, valor, etc)*/
        $this->formatador = new  \App\Functions\FuncoesGerais();

        //Validação de permissão de acesso a pagina
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'acessar']) || Gate::allows('verifica_permissao', [\Config::get('app.controle_atividades'),'acessar'])) //
        {
            $this->dados_login = \Session::get('dados_login');

            //Verificar se usuario logado é LIDER
            $this->lider_logado = $this->formatador->verifica_se_lider();

        }


    }

    public function getEstruturas()
    {


            //Busca primeiro nivel das estruturas
            $strSql = " SELECT DISTINCT nome_1, celulas_nivel1_id, foto1  FROM view_estruturas";
            $strSql .=  " WHERE ";
            $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";

            $level1 = \DB::select($strSql);

            $linha = "<h5><ul class='treeview2'>";
            foreach ($level1 as $key => $value)
            {

                   //NIVEL1
                   $linha .= "      <li>";

                   if  ($value->foto1!="")
                   {
                          $linha .= "<img src='http://app.sigma3sistemas.com.br/images/persons/" . $value->foto1 . "' class='img-circle' width='40' height='40' alt='Pessoa' />";
                   }


                   $linha .= "             <i class='fa  fa-sitemap'></i>&nbsp;<a href='#'>" . $value->nome_1 . "</a>";
                   //$linha .= "             (<i class='fa fa-print'></i>&nbsp;<a href='#' onclick='abrir_relatorio_nivel(1, 1, " . $value->celulas_nivel1_id . ");'>Resumo</a>)";


                   $linha .= '  <select id="tiporelatorio[]"  name="tiporelatorio[]" onchange="changeFunc(this, 1, ' . $value->celulas_nivel1_id . ', \'' . $value->nome_1 . '\');"> ';
                   $linha .= '        <option  value="">Relatórios Disponíveis...</option>';
                   $linha .= '        <option  value="1">Resumo Células Geral</option>';
                   $linha .= '        <option  value="2">Batismos (Anual - Últimos 5 anos)</option>';
                   $linha .= '        <option  value="3">Batismos (Mensal - Ano Corrente)</option>';
                   $linha .= '        <option  value="4">Multiplicação (Anual - Últimos 5 anos)</option>';
                   $linha .= '        <option  value="5">Multiplicação (Mensal - Ano Corrente)</option>';
                   $linha .= '  </select>';


                           //---------------------------------------------NIVEL2-----------------------------------------------------
                           $strSql = " SELECT Distinct nome_2, celulas_nivel2_id, celulas_nivel1_id, foto2 FROM view_estruturas";
                           $strSql .=  " WHERE ";
                           $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
                           $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";
                           $strSql .=  " AND celulas_nivel1_id = " . $value->celulas_nivel1_id;
                           $level2 = \DB::select($strSql);

                            $linha .= "<ul>";
                            foreach ($level2 as $key => $value)
                            {

                                  $linha .= "      <li>";

                                 if  ($value->foto2!="")
                                 {
                                        $linha .= "<img src='http://app.sigma3sistemas.com.br/images/persons/" . $value->foto2 . "' class='img-circle' width='40' height='40' alt='Pessoa' />";
                                 }

                                  $linha .= "             <i class='fa  fa-user'></i>&nbsp;<a href='#'>" . $value->nome_2 . "</a>";
                                  //$linha .= "             (<i class='fa fa-print'></i>&nbsp;<a href='#' onclick='abrir_relatorio_nivel(1, 2, " . $value->celulas_nivel2_id . ");'>Resumo</a>)";

                                   $linha .= '  <select id="tiporelatorio[]"  name="tiporelatorio[]" onchange="changeFunc(this, 2, ' . $value->celulas_nivel2_id . ', \'' . $value->nome_2 . '\');"> ';
                                   $linha .= '        <option  value="">Relatórios Disponíveis...</option>';
                                   $linha .= '        <option  value="1">Resumo Células Geral</option>';
                                   $linha .= '        <option  value="2">Batismos (Anual - Últimos 5 anos)</option>';
                                   $linha .= '        <option  value="3">Batismos (Mensal - Ano Corrente)</option>';
                                   $linha .= '        <option  value="4">Multiplicação (Anual - Últimos 5 anos)</option>';
                                   $linha .= '        <option  value="5">Multiplicação (Mensal - Ano Corrente)</option>';
                                   $linha .= '  </select>';

                                   //NIVEL3
                                   $strSql = " SELECT Distinct nome_3, celulas_nivel3_id, celulas_nivel2_id, celulas_nivel1_id, foto3 FROM view_estruturas";
                                   $strSql .=  " WHERE ";
                                   $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
                                   $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";
                                   $strSql .=  " AND celulas_nivel2_id = " . $value->celulas_nivel2_id;

                                    $level3 = \DB::select($strSql);

                                    $linha .= "<ul>";
                                    foreach ($level3 as $key => $value)
                                    {

                                          $linha .= "      <li>";

                                         if  ($value->foto3!="")
                                         {
                                                $linha .= "<img src='http://app.sigma3sistemas.com.br/images/persons/" . $value->foto3 . "' class='img-circle' width='40' height='40' alt='Pessoa' />";
                                         }

                                          $linha .= "             <i class='fa  fa-user'></i>&nbsp;<a href='#'>" . $value->nome_3 . "</a>";
                                          //$linha .= "             (<i class='fa fa-print'></i>&nbsp;<a href='#' onclick='abrir_relatorio_nivel(1, 3, " . $value->celulas_nivel3_id . ");'>Resumo</a>)";

                                         $linha .= '  <select id="tiporelatorio[]"  name="tiporelatorio[]" onchange="changeFunc(this, 3, ' . $value->celulas_nivel3_id . ', \'' . $value->nome_3 . '\');"> ';
                                         $linha .= '        <option  value="">Relatórios Disponíveis...</option>';
                                         $linha .= '        <option  value="1">Resumo Células Geral</option>';
                                         $linha .= '        <option  value="2">Batismos (Anual - Últimos 5 anos)</option>';
                                         $linha .= '        <option  value="3">Batismos (Mensal - Ano Corrente)</option>';
                                         $linha .= '        <option  value="4">Multiplicação (Anual - Últimos 5 anos)</option>';
                                         $linha .= '        <option  value="5">Multiplicação (Mensal - Ano Corrente)</option>';
                                         $linha .= '  </select>';


                                           //NIVEL4
                                           $strSql = " SELECT Distinct nome_4, celulas_nivel4_id, celulas_nivel3_id, celulas_nivel2_id, celulas_nivel1_id,foto4 FROM view_estruturas";
                                           $strSql .=  " WHERE ";
                                           $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
                                           $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";
                                           $strSql .=  " AND celulas_nivel3_id = " . $value->celulas_nivel3_id;

                                            $level4 = \DB::select($strSql);

                                            $linha .= "<ul>";
                                            foreach ($level4 as $key => $value)
                                            {

                                                  $linha .= "      <li>";

                                                  if  ($value->foto4!="")
                                                 {
                                                        $linha .= "<img src='http://app.sigma3sistemas.com.br/images/persons/" . $value->foto4 . "' class='img-circle' width='40' height='40' alt='Pessoa' />";
                                                 }

                                                  $linha .= "             <i class='fa  fa-user'></i>&nbsp;<a href='#'>" . $value->nome_4 . "</a>";
                                                  //$linha .= "             (<i class='fa fa-print'></i>&nbsp;<a href='#' onclick='abrir_relatorio_nivel(1, 4, " . $value->celulas_nivel4_id . ");'>Resumo</a>)";

                                                  $linha .= '  <select id="tiporelatorio[]"  name="tiporelatorio[]" onchange="changeFunc(this, 4, ' . $value->celulas_nivel4_id . ', \'' . $value->nome_4 . '\');"> ';
                                                  $linha .= '        <option  value="">Relatórios Disponíveis...</option>';
                                                  $linha .= '        <option  value="1">Resumo Células Geral</option>';
                                                  $linha .= '        <option  value="2">Batismos (Anual - Últimos 5 anos)</option>';
                                                  $linha .= '        <option  value="3">Batismos (Mensal - Ano Corrente)</option>';
                                                  $linha .= '        <option  value="4">Multiplicação (Anual - Últimos 5 anos)</option>';
                                                  $linha .= '        <option  value="5">Multiplicação (Mensal - Ano Corrente)</option>';
                                                  $linha .= '  </select>';

                                                           //NIVEL5
                                                           $strSql = " SELECT Distinct nome, id, celulas_nivel4_id, celulas_nivel3_id, celulas_nivel2_id, celulas_nivel1_id,foto5 FROM view_estruturas";
                                                           $strSql .=  " WHERE ";
                                                           $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
                                                           $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";
                                                           $strSql .=  " AND celulas_nivel4_id = " . $value->celulas_nivel4_id;

                                                            $level5 = \DB::select($strSql);

                                                            $linha .= "<ul>";
                                                            foreach ($level5 as $key => $value)
                                                            {

                                                                  $linha .= "      <li>";

                                                                  if  ($value->foto5!="")
                                                                  {
                                                                        $linha .= "<img src='http://app.sigma3sistemas.com.br/images/persons/" . $value->foto5 . "' class='img-circle' width='40' height='40' alt='Pessoa' />";
                                                                  }

                                                                  $linha .= "           <i class='fa  fa-users'></i>&nbsp;<a href='#'>" . $value->nome . "</a>";
                                                                  //$linha .= "             (<i class='fa fa-print'></i>&nbsp;<a href='#' onclick='abrir_relatorio_nivel(1, 5, " . $value->id . ");'>Resumo</a>)";

                                                                   $linha .= '  <select id="tiporelatorio[]"  name="tiporelatorio[]" onchange="changeFunc(this, 1, ' . $value->id . ', \'' . $value->nome . '\');"> ';
                                                                   $linha .= '        <option  value="">Relatórios Disponíveis...</option>';
                                                                   $linha .= '        <option  value="1">Resumo Células Geral</option>';
                                                                   $linha .= '        <option  value="2">Batismos (Anual - Últimos 5 anos)</option>';
                                                                   $linha .= '        <option  value="3">Batismos (Mensal - Ano Corrente)</option>';
                                                                   $linha .= '        <option  value="4">Multiplicação (Anual - Últimos 5 anos)</option>';
                                                                   $linha .= '        <option  value="5">Multiplicação (Mensal - Ano Corrente)</option>';
                                                                   $linha .= '  </select>';

                                                                              //LIDERES
                                                                               $strSql = " SELECT celulas.nome,  lider_pessoas_id, razaosocial , caminhofoto, ";
                                                                               $strSql .=  " ( SELECT count(cp.pessoas_id) AS count ";
                                                                               $strSql .=  "     FROM celulas_pessoas cp ";
                                                                               $strSql .=  "       JOIN celulas c ON cp.celulas_id = c.id AND cp.empresas_id = c.empresas_id AND cp.empresas_clientes_cloud_id = c.empresas_clientes_cloud_id ";
                                                                               $strSql .=  "    WHERE cp.empresas_id = celulas.empresas_id AND cp.empresas_clientes_cloud_id = celulas.empresas_clientes_cloud_id AND cp.celulas_id = celulas.id) AS tot ";
                                                                               $strSql .=  "    , ";
                                                                               $strSql .=  "     ( SELECT count(mh.pessoas_id) AS count      ";
                                                                               $strSql .=  "     FROM celulas_pessoas cp          ";
                                                                               $strSql .=  "     JOIN celulas c ON cp.celulas_id = c.id AND cp.empresas_id = c.empresas_id AND cp.empresas_clientes_cloud_id = c.empresas_clientes_cloud_id     ";
                                                                               $strSql .=  "     JOIN membros_historicos mh ON mh.pessoas_id = cp.pessoas_id AND mh.empresas_id = cp.empresas_id AND mh.empresas_clientes_cloud_id = cp.empresas_clientes_cloud_id     ";
                                                                               $strSql .=  "     WHERE mh.empresas_id = celulas.empresas_id AND mh.empresas_clientes_cloud_id = celulas.empresas_clientes_cloud_id AND cp.celulas_id = celulas.id and isnull(mh.data_batismo,'') = '') AS tot_batizados  ";
                                                                               $strSql .=  " from celulas";
                                                                               $strSql .=  " inner join pessoas on pessoas.id = celulas.lider_pessoas_id ";
                                                                               $strSql .=  " WHERE ";
                                                                               $strSql .=  " celulas.empresas_id = " . $this->dados_login->empresas_id . " AND ";
                                                                               $strSql .=  " celulas.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";
                                                                               $strSql .=  " AND celulas_nivel5_id = " . $value->id;
                                                                               $strSql .=  " order by razaosocial ";

                                                                               $lideres = \DB::select($strSql);

                                                                                $linha .= "<ul>";
                                                                                foreach ($lideres as $key => $value)
                                                                                {
                                                                                      $linha .= "      <li>";

                                                                                      if  ($value->caminhofoto!="")
                                                                                      {
                                                                                             $linha .= "<img src='http://app.sigma3sistemas.com.br/images/persons/" . $value->caminhofoto . "' class='img-circle' width='40' height='40' alt='Pessoa' />";
                                                                                      }

                                                                                      $linha .= "        <a href='#' title='List: '>" . $value->nome . ' - ' . $value->razaosocial .  "<span class='pull-right badge bg-yellow'>" . $value->tot_batizados . " batizados.</span><span class='pull-right badge bg-green'>" . $value->tot . " participantes.</span></a>";
                                                                                      $linha .= "        ";
                                                                                      $linha .= "     </li>";
                                                                                }
                                                                                $linha .= "</ul>";

                                                                  $linha .= "     </li>";

                                                            }
                                                            $linha .= "</ul>";

                                                    $linha .= "     </li>";
                                            }
                                            $linha .= "</ul>";

                                         $linha .= "     </li>";
                                    }

                                    $linha .= "</ul>";
                                $linha .= "     </li>";

                            }
                            $linha .= "</ul>";

                $linha .= "     </li>";
            }

            $linha .= "</ul></h5>";

        return $linha;

    }

   //Lista celulas filhas e suas filhas,,,, enquanto houverem
   protected function buscaProximoNivel($celulas_id)
   {

            $this->gerar_proximo_nivel = "";

            //BUSCA AS CELULAS FILHOS DE UM DETERMINADO PAI
            $strSql = " SELECT celulas_pai_id, celulas.Id, nome, razaosocial , caminhofoto, origem, ";
            $strSql .= " CASE  WHEN nome <> ''::text AND razaosocial <> ''::text THEN (nome || ' - '::text) || razaosocial ";
            $strSql .= "       ELSE COALESCE(razaosocial, nome) ";
            $strSql .= "       END AS nome";
            $strSql .=  " FROM  celulas ";
            $strSql .=  " INNER JOIN pessoas on pessoas.id = celulas.lider_pessoas_id AND pessoas.empresas_id = celulas.empresas_id AND pessoas.empresas_clientes_cloud_id = celulas.empresas_clientes_cloud_id";
            $strSql .=  " WHERE ";
            $strSql .=  " isnull_int(celulas_pai_id ,0) = " . $celulas_id . " AND ";
            $strSql .=  " celulas.empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " celulas.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";

            $retornar = \DB::select($strSql);

            //ABRE NOVA TAG E CONTABILIZA SE ENCONTRAR FILHOS
            if (count($retornar)>0)
            {
                $this->linha .= "<ul>";
                $this->sequencia = $this->sequencia + 1;
            }

            foreach ($retornar as $key => $value)
            {
                  $this->linha .= "      <li>";

                  if  (rtrim(ltrim($value->caminhofoto))!="")
                  {
                         $this->linha .= "<img src='http://app.sigma3sistemas.com.br/images/persons/" . $value->caminhofoto . "' class='img-circle' width='40' height='40' alt='Pessoa' />";
                  }

                  $this->linha .= "        <a href='#'>" . $this->sequencia . ' - ' . $value->razaosocial .  ' - ' . ($value->origem==1 ? "Multiplicação" : "Vínculo (ou Célula Filha)") . "</a>";

                  //Verificar se a celula filha tem PAI
                  $this->gerar_proximo_nivel = $value->id;

            }

            //SE TIVER OUTRO FILHO, GERA NOVAMENTE (EXECUTA NOVAMENTE A FUNCTION ATÉ NAO EXISTIR MAIS FILHOS/NETOS)
            if ($this->gerar_proximo_nivel!="")
            {
               $mais = $this->buscaProximoNivel($this->gerar_proximo_nivel);
            }
            else
            {
              //NAO TEM  MAIS NIVEIS, FECHAS AS TAGS
                for ($i=$this->sequencia; $i >1 ; $i--) {
                      $this->linha .= "     </li>";
                      $this->linha .= "</ul>";
                }

                $mais="";
            }

   }

    //MONTA ARVORE HIERARQUICA DE MULTIPLICACOES E CELULAS FILHAS...
    public function getEstruturasCelulasOrigem($celulas_id)
    {


            $strSql = " SELECT caminhofoto, ";
            $strSql .= " CASE  WHEN nome <> ''::text AND razaosocial <> ''::text THEN (nome || ' - '::text) || razaosocial ";
            $strSql .= "       ELSE COALESCE(razaosocial, nome) ";
            $strSql .= "       END AS nome";
            $strSql .=  " FROM  celulas ";
            $strSql .=  " INNER JOIN pessoas on pessoas.id = celulas.lider_pessoas_id ";
            $strSql .=  " WHERE ";
            $strSql .=  " celulas.id = " . $celulas_id . " AND ";
            $strSql .=  " celulas.empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " celulas.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";

            $retornar = \DB::select($strSql);

            $this->linha = "<h3 class='box-title'>Árvore Hierárquica da Célula (Multiplicação / Vínculos)</h3>&nbsp;(<i class='text'>Clique para expandir</i>)";
            $this->linha .= "<h5><ul class='treeview2'>";

            $this->linha .= "      <li>";

            if  ($retornar[0]->caminhofoto!="")
            {
                   $this->linha .= "      <img src='http://app.sigma3sistemas.com.br/images/persons/" . $retornar[0]->caminhofoto . "' class='img-circle' width='40' height='40' alt='Pessoa' />";
            }

            $this->linha .= "                   <a href='#'>" . $retornar[0]->nome .  "</a>";

            //GERA NIVEIS FILHOS
            $niveis = $this->buscaProximoNivel($celulas_id);

            //Finaliza
            $this->linha .= "</h5>";

            //Não exibir se não houverem niveis abaixo
            if ($this->sequencia ==0)
            {
               $this->linha = '';
            }
            return $this->linha;
    }


  public function getEstruturasOrganograma()
    {


            $strSql = " SELECT Distinct nome_1, celulas_nivel1_id  FROM view_estruturas";
            $strSql .=  " WHERE ";
            $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";

            $level1 = \DB::select($strSql);

            $linha = "<ul id='org'>";

            foreach ($level1 as $key => $value)
            {

                   //NIVEL1
                   $linha .= "      <li>";
                   $linha .= "             <a href='#'>" . $value->nome_1 . "</a>";


                           //---------------------------------------------NIVEL2-----------------------------------------------------
                           $strSql = " SELECT Distinct nome_2, celulas_nivel2_id, celulas_nivel1_id FROM view_estruturas";
                           $strSql .=  " WHERE ";
                           $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
                           $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";
                           $strSql .=  " AND celulas_nivel1_id = " . $value->celulas_nivel1_id;
                           $level2 = \DB::select($strSql);

                            $linha .= "<ul>";
                            foreach ($level2 as $key => $value)
                            {

                                  $linha .= "      <li>";
                                  $linha .= "             <a href='#'>" . $value->nome_2 . "</a>";

                                   //NIVEL3
                                   $strSql = " SELECT Distinct nome_3, celulas_nivel3_id, celulas_nivel2_id, celulas_nivel1_id FROM view_estruturas";
                                   $strSql .=  " WHERE ";
                                   $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
                                   $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";
                                   $strSql .=  " AND celulas_nivel2_id = " . $value->celulas_nivel2_id;

                                    $level3 = \DB::select($strSql);

                                    $linha .= "<ul>";
                                    foreach ($level3 as $key => $value)
                                    {

                                          $linha .= "      <li>";
                                          $linha .= "             <a href='#'>" . $value->nome_3 . "</a>";


                                           //NIVEL4
                                           $strSql = " SELECT Distinct nome_4, celulas_nivel4_id, celulas_nivel3_id, celulas_nivel2_id, celulas_nivel1_id FROM view_estruturas";
                                           $strSql .=  " WHERE ";
                                           $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
                                           $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";
                                           $strSql .=  " AND celulas_nivel3_id = " . $value->celulas_nivel3_id;

                                            $level4 = \DB::select($strSql);

                                            $linha .= "<ul>";
                                            foreach ($level4 as $key => $value)
                                            {

                                                  $linha .= "      <li>";
                                                  $linha .= "             <a href='#'>" . $value->nome_4 . "</a>";

                                                           //NIVEL5
                                                           $strSql = " SELECT Distinct nome, id, celulas_nivel4_id, celulas_nivel3_id, celulas_nivel2_id, celulas_nivel1_id FROM view_estruturas";
                                                           $strSql .=  " WHERE ";
                                                           $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
                                                           $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";
                                                           $strSql .=  " AND celulas_nivel4_id = " . $value->celulas_nivel4_id;

                                                            $level5 = \DB::select($strSql);

                                                            $linha .= "<ul>";
                                                            foreach ($level5 as $key => $value)
                                                            {

                                                                  $linha .= "      <li>";
                                                                  $linha .= "           <a href='#'>" . $value->nome . "</a>";

                                                                              //LIDERES
                                                                               $strSql = " SELECT lider_pessoas_id, razaosocial  from celulas";
                                                                               $strSql .=  " inner join pessoas on pessoas.id = celulas.lider_pessoas_id ";
                                                                               $strSql .=  " WHERE ";
                                                                               $strSql .=  " celulas.empresas_id = " . $this->dados_login->empresas_id . " AND ";
                                                                               $strSql .=  " celulas.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";
                                                                               $strSql .=  " AND celulas_nivel5_id = " . $value->id;
                                                                               $strSql .=  " order by razaosocial ";

                                                                               $lideres = \DB::select($strSql);

                                                                                $linha .= "<ul>";
                                                                                foreach ($lideres as $key => $value)
                                                                                {
                                                                                      $linha .= "      <li>";
                                                                                      $linha .= "        <a href='#'>" . $value->razaosocial . "</a>";
                                                                                      $linha .= "     </li>";
                                                                                }
                                                                                $linha .= "</ul>";

                                                                  $linha .= "     </li>";

                                                            }
                                                            $linha .= "</ul>";

                                                    $linha .= "     </li>";
                                            }
                                            $linha .= "</ul>";

                                         $linha .= "     </li>";
                                    }

                                    $linha .= "</ul>";
                                $linha .= "     </li>";

                            }
                            $linha .= "</ul>";

                $linha .= "     </li>";
            }

            $linha .= "</ul>";

        return $linha;

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

 protected function participantes_presenca ()
 {

            $strSql = " SELECT * FROM view_participantes_celula_ultima_presenca";
            $strSql .=  " WHERE ";
            $strSql .=  " empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "  ";

            //SE for lider, direciona para dashboard da célula
            if ($this->lider_logado!=null)
            {
                   $strSql .=  " AND lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
            }

            $participantes_presenca = \DB::select($strSql);
            return $participantes_presenca;

 }

    protected function resumo_perguntas($mes, $ano)
    {
            //RESUMO por Respostas
            $strSql = " SELECT c.empresas_id, c.empresas_clientes_cloud_id, ca.mes, ca.ano, qe.pergunta, ";
            $strSql .=  " sum(cast(resposta as int)) as total ";
            $strSql .=  " FROM controle_atividades ca  ";
            $strSql .=  " inner join celulas c on c.id = ca.celulas_id ";
            $strSql .=  " inner join pessoas p on p.id = ca.lider_pessoas_id ";
            $strSql .=  " inner join controle_questions cq on cq.controle_atividades_id = ca.id and cq.empresas_id = ca.empresas_id and cq.empresas_clientes_cloud_id = ca.empresas_clientes_cloud_id ";
            $strSql .=  " inner join questionarios_encontros qe on qe.id = cq.questionarios_id ";
            $strSql .=  " where qe.tipo_resposta = 2  and cq.resposta is not null and cq.resposta <> '' AND ";
            $strSql .=  " ca.empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " ca.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " AND ";
            $strSql .=  " ca.mes  = '" . $mes . "' AND ";
            $strSql .=  " ca.ano  = '" . $ano . "'";

            //SE for lider, direciona para dashboard da célula
            if ($this->lider_logado!=null)
            {
                   $strSql .=  " AND ca.lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
            }

            $strSql .=  " group by c.empresas_id, c.empresas_clientes_cloud_id, ca.mes, ca.ano, qe.pergunta ";

            $resumo_perguntas = \DB::select($strSql);
            return $resumo_perguntas;
    }

    protected function resumo_tipo_pessoas($mes, $ano, $opcao)
    {

           //RESUMO POR TIPO DE PESSOA
            if ($opcao=="Geral")
            {

                $strSql = " SELECT c.empresas_id, c.empresas_clientes_cloud_id, tp.nome,  count(*) as total";
                $strSql .=  " from celulas_pessoas ca   ";
                $strSql .=  " inner join celulas c on c.id = ca.celulas_id ";
                $strSql .=  " inner join pessoas p on p.id = ca.pessoas_id ";
                $strSql .=  " inner join tipos_pessoas tp on tp.id = p.tipos_pessoas_id ";
                $strSql .=  " WHERE ";
                $strSql .=  " ca.empresas_id = " . $this->dados_login->empresas_id . " AND ";
                $strSql .=  " ca.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . "";

                //SE for lider, direciona para dashboard da célula
                if ($this->lider_logado!=null)
                {
                       $strSql .=  " AND c.lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
                }

                $strSql .=  " group by c.empresas_id, c.empresas_clientes_cloud_id, tp.nome ";

            }
            else
            {
                //POR  PESSOA MES E ANO ESPECIFICOS
                $strSql = " SELECT c.empresas_id, c.empresas_clientes_cloud_id, ca.mes, ca.ano, tp.nome, ";
                $strSql .=  " sum(total) as total ";
                $strSql .=  " from controle_atividades ca ";
                $strSql .=  " inner join celulas c on c.id = ca.celulas_id ";
                $strSql .=  " inner join pessoas p on p.id = ca.pessoas_id ";
                $strSql .=  " inner join controle_resumo_tipo_pessoa cr on cr.controle_atividades_id = ca.id ";
                $strSql .=  " inner join tipos_pessoas tp on tp.id = cr.tipos_pessoas_id ";
                $strSql .=  " WHERE ";
                $strSql .=  " ca.empresas_id = " . $this->dados_login->empresas_id . " AND ";
                $strSql .=  " ca.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " AND ";
                $strSql .=  " ca.mes  = '" . $mes . "' AND ";
                $strSql .=  " ca.ano  = '" . $ano . "'";

                //SE for lider, direciona para dashboard da célula
                if ($this->lider_logado!=null)
                {
                       $strSql .=  " AND c.lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
                }

                $strSql .=  " group by c.empresas_id, c.empresas_clientes_cloud_id, ca.mes, ca.ano, tp.nome ";
            }

            $resumo_tipo_pessoas = \DB::select($strSql);

            return $resumo_tipo_pessoas;


    }

    protected function resumo_geral($mes, $ano) {
            //RESUMO GERAL - total geral de presentes
            $strSql = " SELECT sum(total) as total ";
            $strSql .=  " FROM controle_atividades ca  ";
            $strSql .=  " inner join celulas c on c.id = ca.celulas_id ";
            $strSql .=  " inner join pessoas p on p.id = ca.lider_pessoas_id ";
            $strSql .=  " inner join controle_resumo_tipo_pessoa cr on cr.controle_atividades_id = ca.id ";
            $strSql .=  " WHERE ";
            $strSql .=  " ca.empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " ca.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " AND ";
            $strSql .=  " ca.mes  = '" . $mes . "' AND ";
            $strSql .=  " ca.ano  = '" . $ano . "'";

            //SE for lider, direciona para dashboard da célula
            if ($this->lider_logado!=null)
            {
                   $strSql .=  " AND ca.lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
            }

            $resumo_geral = \DB::select($strSql);
            //dd($strSql);
            return $resumo_geral;

    }
    protected function resumo_presencas($mes, $ano)
    {

            //RESUMO DE PRESENCAS
            $strSql = " SELECT c.empresas_id, c.empresas_clientes_cloud_id, ca.mes, ca.ano, ";
            $strSql .=  " sum(total_membros) as total_membros, sum(total_visitantes) as total_visitantes, sum(total_geral) as total_geral ";
            $strSql .=  " FROM controle_atividades ca ";
            $strSql .=  " inner join celulas c on c.id = ca.celulas_id ";
            $strSql .=  " inner join pessoas p on p.id = ca.lider_pessoas_id ";
            $strSql .=  " inner join controle_resumo cr on cr.controle_atividades_id = ca.id ";
            $strSql .=  " WHERE ";
            //$strSql .=  " ca.id = " . $id . " AND ";
            $strSql .=  " ca.empresas_id = " . $this->dados_login->empresas_id . " AND ";
            $strSql .=  " ca.empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " AND ";
            $strSql .=  " ca.mes  = '" . $mes . "' AND ";
            $strSql .=  " ca.ano  = '" . $ano . "'";

            //SE for lider, direciona para dashboard da célula
            if ($this->lider_logado!=null)
            {
                   $strSql .=  " AND ca.lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
            }

            $strSql .=  " GROUP BY c.empresas_id, c.empresas_clientes_cloud_id, ca.mes, ca.ano";

            $resumo = \DB::select($strSql);

            return $resumo;

    }

    public function grafico_mensal($opcao, $mes, $ano)
    {
        //Frequencia mes atual e ultimos meses
        //% percentual do total

        if ($opcao=="visitantes")
        {

            $retorna = array();

            //ULTIMOS 3 MESES
            $resumo = $this->resumo_presencas(($mes-2), $ano); //Mes atual menos 2

            foreach ($resumo as $item)
            {
                    $descricao_mes = $this->retorna_mes($item->mes);
                    $retorna[] = array("mes" => $descricao_mes, "total" => $item->total_visitantes);
            }

            $resumo = $this->resumo_presencas(($mes-1), $ano); //Mes atual menos 1

            foreach ($resumo as $item)
            {
                    $descricao_mes = $this->retorna_mes($item->mes);
                    $retorna[] = array("mes" => $descricao_mes, "total" => $item->total_visitantes);
            }

            $resumo = $this->resumo_presencas($mes, $ano); //Mes Atual

            foreach ($resumo as $item)
            {
                    $descricao_mes = $this->retorna_mes($item->mes);
                    $retorna[] = array("mes" => $descricao_mes, "total" => $item->total_visitantes);
            }


        }
        else if ($opcao=="frequencia")
        {

                    $retorno = \DB::select('select  fn_total_participantes(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
                    $total_participantes = $retorno[0]->fn_total_participantes;

                    $retorna = array();

                    //ULTIMOS 3 MESES
                    $resumo = $this->resumo_presencas(($mes-2), $ano); //Mes atual menos 2

                    foreach ($resumo as $item)
                    {
                            $retorna[] = array("mes" => ($item->ano . '-' . $item->mes), "total" => ($item->total_visitantes / $total_participantes * 100));
                    }

                    $resumo = $this->resumo_presencas(($mes-1), $ano); //Mes atual menos 1

                    foreach ($resumo as $item)
                    {
                            $retorna[] = array("mes" => ($item->ano . '-' . $item->mes), "total" => ($item->total_visitantes / $total_participantes * 100));
                    }

                    $resumo = $this->resumo_presencas($mes, $ano); //Mes Atual

                    foreach ($resumo as $item)
                    {
                            $retorna[] = array("mes" => ($item->ano . '-' . '08'), "total" => ($item->total_visitantes / $total_participantes * 100));
                    }


        }
        else if ($opcao=="tipo_pessoa")
        {

                    $retorna = array();

                    //ULTIMOS 3 MESES
                    $resumo = $this->resumo_tipo_pessoas($mes, $ano, "Geral");

                    foreach ($resumo as $item)
                    {
                            $retorna[] = array('label' => $item->nome, 'value' => $item->total);
                    }

        }

        return json_encode($retorna);

    }

    protected function retorna_mes($mes) {

        switch ($mes)
        {
                        case 1:
                            $descricao_mes = "Janeiro";
                            break;
                            case 2:
                            $descricao_mes = "Fevereiro";
                            break;
                            case 3:
                            $descricao_mes = "Março";
                            break;
                            case 4:
                            $descricao_mes = "Abril";
                            break;
                            case 5:
                            $descricao_mes = "Maio";
                            break;
                            case 6:
                            $descricao_mes = "Junho";
                            break;
                            case 7:
                            $descricao_mes = "Julho";
                            break;
                            case 8:
                            $descricao_mes = "Agosto";
                            break;
                            case 9:
                            $descricao_mes = "Setembro";
                            break;
                            case 10:
                            $descricao_mes = "Outubro";
                            break;
                            case 11:
                            $descricao_mes = "Novembro";
                            break;
                            case 12:
                            $descricao_mes = "Dezembro";
                            break;

                        default:
                            $descricao_mes="";
                            break;
          }

          return $descricao_mes;

    }

    public function dashboard()
    {


        if (\App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.controle_atividades')) || \App\ValidacoesAcesso::PodeAcessarPagina(\Config::get('app.celulas')))
        {
              $this->dados_login = \Session::get('dados_login');

             //Verificar se usuario logado é LIDER
             $this->lider_logado = $this->formatador->verifica_se_lider();
        }
        else
        {
                return redirect('home');
        }



        //Verificar se foi cadastrado os dados da igreja
        if (\App\Models\usuario::find(Auth::user()->id))
        {

            $publicos = \App\Models\publicos::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();
            $faixas = \App\Models\faixas::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();


            //busca da proxima multiplicacao
            $strSql = "SELECT * FROM view_lideres ";
            $strSql .=  " WHERE  empresas_id = " . $this->dados_login->empresas_id;
            $strSql .=  " AND empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id;

            //Busca LIDERES, se for lider logado retorna somente dados dele mesmo
            if ($this->lider_logado!=null)
            {
                $strSql .=  " AND id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
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

            $retorno = \DB::select('select  fn_total_celulas(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
            $total_celulas = $retorno[0]->fn_total_celulas;

            $retorno = \DB::select('select  fn_total_participantes(' . $this->dados_login->empresas_clientes_cloud_id . ', ' . $this->dados_login->empresas_id. ')');
            $total_participantes = $retorno[0]->fn_total_participantes;

            $celulas_faixas = \DB::select('select * from view_total_celulas_faixa_etaria vw where vw.empresas_id = ? and vw.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            $celulas_publicos = \DB::select('select * from view_total_celulas_publico_alvo vw where vw.empresas_id = ? and vw.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

            $resumo = $this->resumo_presencas(date('m'), date('Y'));

            $resumo_geral = $this->resumo_geral(date('m'), date('Y'));

            $resumo_tipo_pessoas = $this->resumo_tipo_pessoas(date('m'), date('Y'), 'Geral');

            $resumo_perguntas = $this->resumo_perguntas(date('m'), date('Y'));

            //AQUI
            //Busca ID do cliente cloud e ID da empresa
            $this->dados_login = \App\Models\usuario::find(Auth::user()->id);

            //SE for lider, direciona para dashboard da célula
            if ($this->lider_logado!=null)
            {
                $qual_pagina = ".dashboard_lider";
                $participantes_presenca = $this->participantes_presenca();

                //busca da proxima multiplicacao
                $strSql = "SELECT data_previsao_multiplicacao from view_celulas_simples ";
                $strSql .=  " WHERE  empresas_id = " . $this->dados_login->empresas_id;
                $strSql .=  " AND empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id;
                $strSql .=  " AND lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
                $dados = \DB::select($strSql);

                //Verifica se ultimo encontro ja foi encerrado
                $strSql = " SELECT  to_char(to_date(data_encontro, 'yyyy-MM-dd'), 'DD-MM-YYYY') AS data_encontro, id from controle_atividades ";
                $strSql .=  " WHERE ";
                $strSql .=  " lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
                $strSql .=  " AND encontro_encerrado <> 'S' and  ";
                $strSql .=  " to_char(to_date(data_encontro, 'yyyy-MM-dd'), 'DD-MM-YYYY') < to_char( now(), 'yyyy-MM-dd' ) ";
                $aberto = \DB::select($strSql);

                $gerar_treeview = '';

            }
            else
            {
                $gerar_treeview = $this->getEstruturas();
                $qual_pagina = ".dashboard";
                $participantes_presenca = '';
                $dados='';
                $aberto='';
            }


              return view($this->rota . $qual_pagina,
                 [
                 'aberto'=>$aberto,
                  'dados'=>$dados,
                  'resumo'=>$resumo,
                  'resumo_geral'=>$resumo_geral,
                  'resumo_tipo_pessoas'=>$resumo_tipo_pessoas,
                  'total_celulas'=>$total_celulas,
                  'total_participantes'=>$total_participantes,
                  'celulas_faixas'=>$celulas_faixas,
                  'celulas_publicos'=>$celulas_publicos,
                  'resumo_perguntas'=>$resumo_perguntas,
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
                   'var_mensagem'=>'',
                   'participantes_presenca'=> $participantes_presenca,
                   'gerar_treeview'=>$gerar_treeview
                ]);
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

            $strSql = "SELECT * from view_celulas_simples ";
            $strSql .=  " WHERE  empresas_id = " . $this->dados_login->empresas_id;
            $strSql .=  " AND empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id;

            //SE for lider, direciona para dashboard da célula
            if ($this->lider_logado!=null)
            {
                   $strSql .=  " AND lider_pessoas_id  = '" . $this->lider_logado[0]->lider_pessoas_id . "'";
            }

            $dados = \DB::select($strSql);

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
         $dados->data_previsao_multiplicacao = $this->formatador->FormatarData($input["data_previsao_multiplicacao"]);
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

         if (isset($input["endereco_encontro"]))
         {
               $dados->endereco_encontro = ($input['endereco_encontro']=="" ? null : $input['endereco_encontro']);
         }

         if ($input["origem"]=="1")  //Multiplicacao
         {
                $dados->data_multiplicacao = date('Y-m-d');
         }

         $dados->qual_endereco = ($input['local']=="" ? null : $input['local']);

         //Verifique qual endereco sera o encontro conforme selecao do local
         if (isset($input["endereco_encontro"]))
         {
               if ($dados->qual_endereco != "6")
               {
                        switch ($dados->qual_endereco)
                        {
                            case '1': //lider
                                $id_pessoa_endereco = $dados->lider_pessoas_id;
                                break;

                                case '2': //lider em treinamento
                                $id_pessoa_endereco = $dados->vicelider_pessoas_id;
                                break;

                                case '3': //anfitriao
                                $id_pessoa_endereco = $dados->suplente1_pessoas_id;
                                break;

                                case '4': //suplente
                                $id_pessoa_endereco = $dados->suplente2_pessoas_id;
                                break;

                            default:
                                $id_pessoa_endereco = "";
                                break;
                        }

                        if ($dados->qual_endereco=='5') //endereco igreja sede
                        {
                            $pegar_endereco = \App\Models\empresas::select('endereco', 'numero', 'bairro', 'cidade', 'estado', 'complemento')->findOrfail($this->dados_login->empresas_id);
                            $dados->endereco_encontro = $pegar_endereco->endereco . ', ' . $pegar_endereco->numero . ' - ' . $pegar_endereco->bairro . '  ' . $pegar_endereco->complemento;
                        }
                        else
                        {
                            if ($id_pessoa_endereco!="")
                            {
                                    $pegar_endereco = \App\Models\pessoas::select('endereco', 'numero', 'bairro', 'cidade', 'estado', 'complemento')->findOrfail($id_pessoa_endereco);
                                    $dados->endereco_encontro = $pegar_endereco->endereco . ', ' . $pegar_endereco->numero . ' - ' . $pegar_endereco->bairro . '  ' . $pegar_endereco->complemento;
                            }
                        }

               }

         }

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

        //Verifica se tem permissao para incluir ou alterar
        if (Gate::allows('verifica_permissao', [\Config::get('app.' . $this->rota),'incluir']) || Gate::allows('verifica_permissao', [\Config::get('app.controle_atividades'),'alterar']))
        {
              $preview = 'false'; //somente visualizacao = false
        } else
        {
              $preview = 'true'; //somente visualizacao = true
        }

        /*Busca NIVEL5*/
        $view5 = \DB::select('select * from view_celulas_nivel5 v5 where v5.empresas_id = ? and v5.empresas_clientes_cloud_id = ? ', [$this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);

        //return view($this->rota . '.registrar', ['nivel5'=>$view5, 'publicos'=>$publicos, 'faixas'=>$faixas]);
        return view($this->rota . '.atualizacao', [
          'gerar_estrutura_origem' => $vazio,
          'participantes'=>'',
          'preview'=>$preview,
          'nivel5'=>$view5,
          'publicos'=>$publicos,
          'faixas'=>$faixas,
          'tipo_operacao'=>'incluir',
          'dados'=>$vazio,
          'celulas'=>$celulas,
          'vinculos'=>$vazio,
          'total_vinculos'=>'0']);

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
        //$vinculos = \DB::select('select * from view_celulas_simples  where celulas_pai_id = ?  and empresas_id = ? and empresas_clientes_cloud_id = ? ', [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);


        $gerar_estrutura_origem = $this->getEstruturasCelulasOrigem($id);

        //if  ($vinculos==null) //Se nao encontrar, gera controller vazio
        //{
            //$vinculos = \App\Models\tabela_vazia::get();
            //$total_vinculos = 0;
        //}
        //else
        //{
            $temp = \DB::select('select count(*) as tot from view_celulas  where celulas_pai_id = ?  and empresas_id = ? and empresas_clientes_cloud_id = ? ', [$id, $this->dados_login->empresas_id, $this->dados_login->empresas_clientes_cloud_id]);
            $total_vinculos =$temp[0]->tot;
        //}
            //'vinculos'=>$vinculos,

        //return view($this->rota . '.edit', ['dados' =>$dados, 'preview' => $preview,  'nivel5' =>$view5, 'publicos'=>$publicos, 'faixas'=>$faixas]);
        return view($this->rota . '.atualizacao', [
              'gerar_estrutura_origem'=>$gerar_estrutura_origem,
              'participantes'=>$participantes,
              'dados' =>$dados,
              'preview' => $preview,
              'nivel5' =>$view5,
              'publicos'=>$publicos,
              'faixas'=>$faixas,
              'tipo_operacao'=>'editar',
              'celulas'=>$celulas,
              'total_vinculos'=>$total_vinculos
            ]);

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