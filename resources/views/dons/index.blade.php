@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Dons Espirituais') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'dons') }}
{{ \Session::put('id_pagina', '16') }}

@include('pagina_padrao')
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_cadastros_base").addClass("treeview active");
    });
</script>
@endsection