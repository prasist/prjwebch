<!DOCTYPE html>
<html>
<head>
    <title>Teste</title>
</head>
<body>

     <form method = 'POST'  class="form-horizontal" action = {{ url('/minhaigreja/enviar')}}>
            {!! csrf_field() !!}
            <input type="text" name="email" value="" placeholder="Informe seu e-mail">
     </form>

     @if ($conteudo!="")
            @foreach($conteudo as $item)
                        <p>{{$item->titulo}}</p>
                        <p>{{$item->descricao}}</p>
            @endforeach
     @endif

</body>
</html>