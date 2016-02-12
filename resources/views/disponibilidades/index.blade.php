@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Disponiblidades de Tempo') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'disponibilidades') }}
{{ \Session::put('id_pagina', '26') }}

@include('pagina_padrao')

@endsection