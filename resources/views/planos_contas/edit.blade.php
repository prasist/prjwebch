@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Planos de Contas') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'planos_contas') }}
{{ \Session::put('id_pagina', '49') }}

@include('edicao_padrao')

@endsection