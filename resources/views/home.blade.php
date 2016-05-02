<?php \Session::flush()?>

@extends('layouts.app')

@section('content')

<!-- retirdado composer.json "barryvdh/laravel-debugbar": "^2.1",-->
<div class="container">

 <div class="row">

         <br/>
        <center>
        <a  href="{{ url('http://sigma3sistemas.com.br') }}"><img src="{{ url('/images/clients/logo.png') }}" class="user-image" alt="Usuário Logado" width="100" height="30" /></a>
        <p>Sistema de Gestão para Igrejas</p>
        </center>

    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Mensagens</div>

                <div class="panel-body">

                <ul>
                        <li>
                               <a  href="{{ url('/home') }}">Retonar ao SIGMA3</a>
                        </li>

                        <li>
                                <a  href="{{ url('http://sigma3sistemas.com.br') }}">Retonar ao site</a>
                        </li>

                        <li>
                                <a  href="{{ url('/login') }}">Logar Novamente</a>
                        </li>

                </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
