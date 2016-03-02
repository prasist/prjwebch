@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Tipos de Pessoas') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'tipospessoas') }}
{{ \Session::put('id_pagina', '33') }}

        <div>{{{ $errors->first('erros') }}}</div>
@include('pagina_padrao')

@endsection