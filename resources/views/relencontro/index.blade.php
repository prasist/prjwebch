@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Relatório de Encontros') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'relencontro') }}
{{ \Session::put('id_pagina', '65') }}

@include('celulas.filtro_rel_encontro')

@include('configuracoes.script_estruturas')
@endsection