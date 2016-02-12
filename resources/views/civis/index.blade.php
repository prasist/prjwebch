@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Estados Civis') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'civis') }}
{{ \Session::put('id_pagina', '23') }}

@include('pagina_padrao')

@endsection