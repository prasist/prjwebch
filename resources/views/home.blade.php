@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Mensagens</div>

                <div class="panel-body">

                <ul>
                        <li>Você encerrou sua sessão</li>

                        <li>
                                <a  href="{{ url('http://177.101.149.118') }}">Retonar ao site SIGMA3</a>
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
