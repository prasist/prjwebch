@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Profissões') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'profissoes') }}
{{ \Session::put('id_pagina', '12') }}

@include('pagina_padrao')

@endsection