@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Graus de Instrução') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'graus') }}
{{ \Session::put('id_pagina', '11') }}

@include('pagina_padrao')

@endsection