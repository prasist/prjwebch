@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Status') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'status') }}
{{ \Session::put('id_pagina', '9') }}

@include('pagina_padrao')

@endsection