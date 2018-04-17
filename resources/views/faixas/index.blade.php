@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Faixas Etárias') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'faixas') }}
{{ \Session::put('id_pagina', '44') }}

@include('pagina_padrao')
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_cadastros_base").addClass("treeview active");
    });
</script>
@endsection