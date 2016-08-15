@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Mensagens') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'mensagens') }}
{{ \Session::put('id_pagina', '15') }}

@include('edicao_padrao')

@endsection