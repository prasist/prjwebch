@extends('principal.master')

@section('content')


{{ \Session::put('titulo', 'Graus de Parentesco') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'grausparentesco') }}
{{ \Session::put('id_pagina', '19') }}

@include('pagina_padrao')
<<<<<<< HEAD

=======
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_cadastros_base").addClass("treeview active");
    });
</script>
>>>>>>> 120dea74f7aae4b7cf0346eef1fc6007bb8de774
@endsection