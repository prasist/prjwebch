<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Functions;
use URL;
use Auth;
use DB;
use Input;
use Gate;

class CadastrarController extends Controller
{

        public function __construct()
        {

            if (\App\Models\usuario::find(Auth::user()->id))
            {
                //Busca ID do cliente cloud e ID da empresa
                $this->dados_login = \App\Models\usuario::find(Auth::user()->id);
            }

        }

       /*Busca pela inicial do nome (alfabeto)*/
       public function cadastrar($conteudo)
       {

            if ($conteudo!="")
            {
                $array_parametros = explode("&", htmlspecialchars_decode($conteudo));
                \DB::insert("insert into " . $array_parametros[0] . " (nome, clientes_cloud_id) values('" . $array_parametros[1] . "', " . $this->dados_login->empresas_clientes_cloud_id . " ) ");
            }

       }

          /*Busca pela inicial do nome (alfabeto)*/
       public function carregar_tabela($tabela)
       {

                $view = \DB::select('select * from ' . $tabela . ' where clientes_cloud_id = ? ', [$this->dados_login->empresas_clientes_cloud_id]);

                $options = array();

                foreach ($view as $item)
                {
                    $options += array($item->id => $item->nome);
                }

                return \Response::json($options);

       }

}