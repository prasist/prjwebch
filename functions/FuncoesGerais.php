<?php

namespace App\Http\Controllers;

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

    public function Testar() {
        echo "teste";
    }

    public function CriarCombo($tabela, $id, $nome, $label, $multiple)
    {

        echo "teset";
        /*//Lista tipos de pessoas, será usado no botão novo registro para indicar qual tipo de cadastro efetuar
        $dados = \App\Models\$tabela::where('clientes_cloud_id', $this->dados_login->empresas_clientes_cloud_id)->get();

        $varMontaHtml =  "<label for='" . $label . "' class='control-label'>". $label . "</label>";
        $varMontaHtml .=  "<select name='" . $label . "'  data-placeholder='Selecionar' class='form-control select2' style='width: 100%;'>";
        $varMontaHtml .=  "<option  value=''>(Selecionar)</option>";
        $varMontaHtml .=  "    @foreach(" . $dados . " as $item) ";
        $varMontaHtml .=  "        <option  value='{{$item->id}}'>{{$item->nome}}</option>";
        $varMontaHtml .=  "    @endforeach ";
        $varMontaHtml .=  "    </select> ";

        echo $varMontaHtml;*/

    }

}