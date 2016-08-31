<?php

namespace App\Functions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use Auth;
use Input;
use Gate;

class FuncoesGerais extends Controller
{

    public function __construct()
    {

    }


    /**
     * Description = Retira caracteres especiais em campos com mascara, por exemplo CEP, TELEFONE, CNPJ, CPF
     * @param type $dados = Conteudo a ser formatado
     * @return type  string = Retorna conteudo sem caracteres
     */
    public function RetirarCaracteres($dados)
    {

            return preg_replace("/[^0-9]/", '', $dados);

    }


    /*
    * Recebe data d/m/y e retorna y-m-d para insert no banco de dados
    */
    public function FormatarData($valor)
    {

        if ($valor=="") /*Se data estiver em branco grava nulo no banco de dados*/
        {
            return null;
        }

            $data_formatada = \DateTime::createFromFormat('d/m/Y', $valor);

            return $data_formatada->format('Y-m-d'); //Retorna data preparada para insert
    }


    /*
    * Recebe data Y-m-d gravada no banco e retorna d/m/y para exibição correta
    */
    public function ExibirData($valor)
    {

        if ($valor==null) /*Se data estiver em branco grava nulo no banco de dados*/
        {
            return "";
        }

            $data_formatada = \DateTime::createFromFormat('Y-m-d', $valor);
            return $data_formatada->format('d/m/Y'); //Retorna data preparada para insert
    }

    public function GravarCurrency($valor)
    {

            if ($valor=="") return "0";

            $converterValor = str_replace('.','',$valor);
            $converterValor = str_replace(',','.',$converterValor);
            return $converterValor;
    }

    public function ExibirCurrency($valor)
    {
            //number_format($valor,0,",",".");
            return number_format($valor, 2, ',', '.'); // retorna R$100,000.50
    }



    //Verificar se a pessoa logada é lider de célula
    public function verifica_se_lider()
    {



        if (\App\Models\usuario::find(Auth::user()->id))
       {
            //Busca ID do cliente cloud e ID da empresa
            $this->dados_login = \App\Models\usuario::find(Auth::user()->id);
        }

       $email = Auth::user()->email;

       $strSql =  " SELECT id, lider_pessoas_id ";
       $strSql .=  " FROM celulas ";
       $strSql .=  " where ";
       $strSql .=  " (lider_pessoas_id in (select id from pessoas where upper(emailprincipal) = '" .  strtoupper($email)  . "') or vicelider_pessoas_id in (select id from pessoas where upper(emailprincipal) = '" .  strtoupper($email) . "'))";
       $strSql .=  " and empresas_id = " . $this->dados_login->empresas_id . " ";
       $strSql .=  " and empresas_clientes_cloud_id = " . $this->dados_login->empresas_clientes_cloud_id . " ";

       $lider_logado = \DB::select($strSql);

       return $lider_logado;

    }


}