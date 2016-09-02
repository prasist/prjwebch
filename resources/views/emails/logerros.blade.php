<div>
<h2>Log de Erros</h2>
@if (\Session::has('nome_igreja'))
<p>Igreja: {!! \Session::get('nome_igreja') !!}</p>
<p>Usuário : {!!Auth::user()->name!!}</p>
<p>
    {!! $msg_erros !!}
</p>
@endif
</div>