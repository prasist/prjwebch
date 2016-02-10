<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\usuario;
use Auth;

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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //Verificar se foi cadastrado os dados da igreja
        if (usuario::find(Auth::user()->id))
        {
            //Busca ID do cliente cloud e ID da empresa
            $dados_login = usuario::find(Auth::user()->id);

            \Session::put('dados_login', $dados_login);
            return view('pages.dashboard');     //ok, direciona para dashboard
        }
        else
        {
            return view('pages.dashboard_blank');  //Ainda nao cadastrou, solicitar o cadastro
        }


    }
}
