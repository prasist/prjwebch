@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Bancos') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'bancos') }}
{{ \Session::put('id_pagina', '35') }}

@include('pagina_padrao')
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_cadastros_base").addClass("treeview active");
    });
</script>
@endsection