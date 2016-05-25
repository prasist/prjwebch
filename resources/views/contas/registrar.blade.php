@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Contas Correntes') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'contas') }}
{{ \Session::put('id_pagina', '48') }}

@include('inclusao_padrao')

@endsection