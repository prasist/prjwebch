@extends('principal.master')

@section('content')

 <div class = 'container'>

        <p>Dados Cadastrais</p>

        <div>{{{ $errors->first('erros') }}}</div>

        <div class="row">
                <div class="col-xs-2">
                  <form method = 'get' class="form-horizontal" action = {{ url('/usuarios/registrar')}}>
                        <button class = 'btn btn-success btn-flat' type ='submit'><i class="fa fa-file-text-o"></i> Novo Registro</button>
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
                        <th>ID</th>
                        <th>Nome Usuário</th>

                        <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $value)

                        <tr>
                        <div class = 'row'>

                              <div class="col-xs-3">
                                    <td>{{$value->id}}</td>
                                    <td>{{$value->name}}</td>
                              </div>
                         </div>

                            <td>
                                <div class = 'row'>

                                              <div class="col-xs-2">
                                              @if ($value->master != 1)

                                                    <form id="excluir{{ $value->id }}" action="{{ URL::to('usuarios/' . $value->id . '/delete') }}" method="DELETE">

                                                          <button
                                                              data-toggle="tooltip"
                                                              data-placement="top" title="Excluir Ítem" type="submit"
                                                              class="btn btn-danger"
                                                              onclick="return confirm('Confirma exclusão desse registro ?');">
                                                              <i class="fa fa-trash-o"></i> Excluir</button>

                                                    </form>

                                              @endif
                                              </div>

                                              <div class="col-xs-2">
                                                    <a href = "{{ URL::to('usuarios/' . $value->id . '/edit') }}" class = 'btn btn-info' data-link = '/users/{{$value->id}}/edit'><i class="fa fa-edit"></i> Editar</a>
                                              </div>

                                              <div class="col-xs-2">
                                                   <a href = "{{ URL::to('usuarios/' . $value->id . '/preview') }}" class = 'btn btn-primary'><i class="fa fa-search-plus"></i> Visualizar</a>
                                              </div>
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