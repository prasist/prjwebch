@extends('principal.master')

@section('content')

	<div class="">
		<h1>Usuário Administrador cadastrado com sucesso. Para ter acesso a todos os recursos será necessário o preenchimento dos dados cadastrais da igreja sede. Clique no botão "Cadastrar Agora" e complete o cadastro.</h1>

                        <form method = 'get' class="form-horizontal" action = "{{URL::to('clientes/registrar')}}">
                            <button class = 'btn btn-success btn-flat' type ='submit'>Cadastrar Agora</button>
                      </form>

	</div>

@endsection