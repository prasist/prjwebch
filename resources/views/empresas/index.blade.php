@extends('principal.master')

@section('content')

 <div class = 'container'>

        <p>Dados Cadastrais</p>

        <div>{{{ $errors->first('erros') }}}</div>

        <div class="row">
                <div class="col-xs-2">
                  <form method = 'get' class="form-horizontal" action = {{ url('/empresas/registrar')}}>
                        <button class = 'btn btn-success btn-flat' type ='submit'>Novo Registro</button>
                  </form>
                  </div>
        </div>

        <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">

                <div class="box-body">

                    <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                        <th>Razão Social</th>
                        <th>Nome Fantasia</th>
                        <th>CNPJ</th>
                        <th>Insc. Est.</th>
                        <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emp as $value)

                        <tr>
                            <td>{{$value->razaosocial}}</td>
                            <td>{{$value->nomefantasia}}</td>
                            <td>{{$value->cnpj}}</td>
                            <td>{{$value->inscricaoestadual}}</td>

                            <td>
                                <div class = 'row'>
                                      @if ($value->igreja_sede != 1)

                                     <form id="excluir{{ $value->id }}" action="{{ URL::to('empresas/' . $value->id . '/delete') }}" method="DELETE">

                                              <button
                                                  data-toggle="tooltip"
                                                  data-placement="top" title="Excluir Ítem" type="submit"
                                                  class="btn btn-danger"
                                                  onclick="return confirm('Confirma exclusão desse ítem ?');">
                                                  <i class="fa fa-trash-o"></i> Excluir</button>

                                        </form>


                                    @endif

                                    <a href = "{{ URL::to('empresas/' . $value->id . '/edit') }}" class = 'btn btn-info' data-link = '/empresas/{{$value->id}}/edit'>Editar</a>
                                    <a href = "{{ URL::to('empresas/' . $value->id . '/preview') }}" class = 'btn btn-primary' data-link = '/empresas/{{$value->id}}'>Visualizar</a>

                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
          </div>
         </div>
        </div>

  </div>

@endsection