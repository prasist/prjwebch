@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Disponiblidades de Tempo') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'disponibilidades') }}
{{ \Session::put('id_pagina', '25') }}

@include('pagina_padrao')
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_cadastros_base").addClass("treeview active");
    });
</script>
@endsection