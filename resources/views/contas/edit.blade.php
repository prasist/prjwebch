@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Contas Correntes') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'contas') }}
{{ \Session::put('id_pagina', '48') }}

@include('edicao_padrao')

@endsection