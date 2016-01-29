@extends('principal.master')

@section('content')

	<div class="">
		<h1>Não foram gravados os dados da Igreja Sede. Para ter acesso a todos os recursos deverá ser preenchido os dados.</h1>
		<a href="{{URL::to('cliente/registrar')}}"> Cadastrar Agora </a>
	</div>

@endsection