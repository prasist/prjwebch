@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Tipos de Telefones') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'tipostelefones') }}
{{ \Session::put('id_pagina', '33') }}

        <div>{{{ $errors->first('erros') }}}</div>
@include('pagina_padrao')

@endsection