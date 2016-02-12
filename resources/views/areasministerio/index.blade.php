@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Àreas de Ministério') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'areasministerio') }}
{{ \Session::put('id_pagina', '15') }}

@include('pagina_padrao')

@endsection