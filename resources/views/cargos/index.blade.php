@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Cargos / Funções') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'cargos') }}
{{ \Session::put('id_pagina', '20') }}

@include('pagina_padrao')
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_cadastros_base").addClass("treeview active");
    });
</script>
@endsection