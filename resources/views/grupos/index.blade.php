@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Grupos de Usuário') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'grupos') }}

@include('pagina_padrao')
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_seguranca").addClass("treeview active");
    });
</script>
@endsection