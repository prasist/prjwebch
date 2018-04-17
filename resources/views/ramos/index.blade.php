@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Ramos de Atividades') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'ramos') }}
{{ \Session::put('id_pagina', '21') }}

@include('pagina_padrao')
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_cadastros_base").addClass("treeview active");
    });
</script>
@endsection