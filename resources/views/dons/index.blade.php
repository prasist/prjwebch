@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Dons Espirituais') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'dons') }}
{{ \Session::put('id_pagina', '17') }}

@include('pagina_padrao')

@endsection