@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Células / Pessoas') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'celulaspessoas') }}
{{ \Session::put('id_pagina', '45') }}

@include('edicao_padrao')

@endsection