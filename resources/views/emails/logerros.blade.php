<div>
<h2>Log de Erros</h2>
<p>Igreja: {!! \Session::get('nome_igreja') !!}</p>
<p>Usuário : {!!Auth::user()->name!!}</p>
<p>
    {!! $msg_erros !!}
</p>
</div>