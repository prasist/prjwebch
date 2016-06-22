<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use Input;

class MinhaIgreja extends Controller
{

    public function __construct()
    {

    }


   public function enviar_email(\Illuminate\Http\Request  $request)
   {

      $input = $request->except(array('_token')); //não levar o token

      $buscar = \App\Models\pessoas::select('razaosocial', 'empresas_id', 'empresas_clientes_cloud_id')
      ->where('emailprincipal', $input["email"])
      ->get();

      if ($buscar)
      {
            $conteudo = \App\Models\conteudo::where('empresas_id', $buscar[0]->empresas_id)
            ->where('empresas_clientes_cloud_id', $buscar[0]->empresas_clientes_cloud_id)
            ->orderBy('titulo','ASC')
            ->get();
      }
      else
      {
            $conteudo = ['mensagem' => 'Lamentamos, mas não encontramos seu e-mail cadastrado nas igrejas. Por favor, entre em contato com o responsável em sua igreja. Obrigado'];
      }


        return view('tutoriais.minhaigreja', ['conteudo'=>$conteudo]);

   }

    //Exibir listagem
    public function index()
    {

        return view('tutoriais.minhaigreja', ['conteudo'=>'']);

    }

}