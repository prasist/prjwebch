@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Estados Civis') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'civis') }}
{{ \Session::put('id_pagina', '22') }}

@include('pagina_padrao')
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_cadastros_base").addClass("treeview active");
    });
</script>
@endsection