@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Grupos de Usuário') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'grupos') }}

@include('pagina_padrao')
<<<<<<< HEAD

=======
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_seguranca").addClass("treeview active");
    });
</script>
>>>>>>> 120dea74f7aae4b7cf0346eef1fc6007bb8de774
@endsection