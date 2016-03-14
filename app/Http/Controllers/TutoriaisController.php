<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use URL;
use Auth;
use Input;
use Gate;

class TutoriaisController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->dados_login = \Session::get('dados_login');
    }

    //Exibir listagem
    public function index()
    {
        return view('tutoriais.conclusao');     //ok, direciona para dashboard
    }

    public function  concluir()
    {

          \Session::put('tour_rapido', 'S'); //Atualiza session

         //------------------Atualizar tabela USUARIOS com termino do TOUR RAPIDO
        $where = ['empresas_id' => $this->dados_login->empresas_id, 'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id, 'id' => $this->dados_login->id];

        $update = \DB::table('usuarios')->where($where)
        ->update(array(
                        'tutorial'    => 'S'));

        return redirect('home');

    }

    public function  iniciar()
    {

          \Session::put('tour_rapido', 'N'); //Atualiza session

         //------------------Atualizar tabela USUARIOS com termino do TOUR RAPIDO
        $where = ['empresas_id' => $this->dados_login->empresas_id, 'empresas_clientes_cloud_id' => $this->dados_login->empresas_clientes_cloud_id, 'id' => $this->dados_login->id];

        $update = \DB::table('usuarios')->where($where)
        ->update(array(
                        'tutorial'    => 'N'));

        return redirect('home');

    }

    public function  tutorial ($id)
    {

            if ($id==1)
            {
                    return view('tutoriais.users');
            }

    }


}