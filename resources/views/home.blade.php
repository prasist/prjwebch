@extends('layouts.app')

@section('content')
<div class="container">

 <div class="row">

         <br/>
        <center>
        <img src="{{ url('/images/clients/logo.png') }}" class="user-image" alt="Usuário Logado" width="100" height="30" />
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
                                <a  href="{{ url('http://177.101.149.118') }}">Retonar ao site</a>
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
