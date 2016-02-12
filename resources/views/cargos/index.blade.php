@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Cargos / Funções') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'cargos') }}
{{ \Session::put('id_pagina', '21') }}

@include('pagina_padrao')

@endsection