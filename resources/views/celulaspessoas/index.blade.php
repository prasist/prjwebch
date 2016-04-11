@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Células / Pessoas') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'celulaspessoas') }}
{{ \Session::put('id_pagina', '45') }}

@include('pagina_padrao')

@endsection