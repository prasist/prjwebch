@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Idiomas') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'idiomas') }}
{{ \Session::put('id_pagina', '10') }}

@include('pagina_padrao')

@endsection