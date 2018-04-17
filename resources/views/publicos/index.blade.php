@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Públicos Alvos') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'publicos') }}
{{ \Session::put('id_pagina', '43') }}

@include('pagina_padrao')
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_cadastros_base").addClass("treeview active");
    });
</script>
@endsection