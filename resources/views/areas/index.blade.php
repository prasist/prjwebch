@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Àreas de Formação') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'areas') }}
{{ \Session::put('id_pagina', '13') }}

@include('pagina_padrao')

@endsection