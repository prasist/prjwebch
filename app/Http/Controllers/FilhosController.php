<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use Auth;
use Input;
use Gate;

class FilhosController extends Controller
{

    public function __construct()
    {
          $this->rota = "pessoas"; //Define nome da rota que será usada na classe
    }

    /**
     * Excluir registro do banco.
     *
     * @param    int  $id
     * @return  \Illuminate\Http\Response
     */
    public function destroy(\Illuminate\Http\Request  $request)
    {

            dd($request);

            //$dados = \App\Models\membros_filhos::findOrfail($id);
            //$dados->delete();

            //return redirect($this->rota);
    }

}