@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Contas Correntes') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'contas') }}
{{ \Session::put('id_pagina', '48') }}

@include('pagina_padrao')

@endsection