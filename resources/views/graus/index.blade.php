@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Graus de Instrução') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'graus') }}
{{ \Session::put('id_pagina', '10') }}

@include('pagina_padrao')
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_cadastros_base").addClass("treeview active");
    });
</script>
@endsection