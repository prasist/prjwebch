@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Atividades') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'atividades') }}
{{ \Session::put('id_pagina', '16') }}

@include('pagina_padrao')

@endsection