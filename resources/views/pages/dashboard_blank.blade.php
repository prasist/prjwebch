@extends('principal.master')

@section('content')

	<div class="">
		<h1>Não foram gravados os dados da Igreja Sede. Para ter acesso a todos os recursos deverá ser preenchido os dados.</h1>

                        <form method = 'get' class="form-horizontal" action = "{{URL::to('clientes/registrar')}}">
                            <button class = 'btn btn-success btn-flat' type ='submit'>Cadastrar Agora</button>
                      </form>

	</div>

@endsection