@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Grupos de Pessoas') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'grupospessoas') }}
{{ \Session::put('id_pagina', '31') }}

@include('pagina_padrao')
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_cadastros_base").addClass("treeview active");
    });
</script>
@endsection