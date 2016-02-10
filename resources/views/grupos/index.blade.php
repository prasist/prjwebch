@extends('principal.master')

@section('content')


        <p>Grupos de Usuário</p>

        <div>{{{ $errors->first('erros') }}}</div>

        <div class="row">
                <div class="col-xs-2">
                @can('verifica_permissao', [2,'incluir'])
                  <form method = 'get' class="form-horizontal" action = {{ url('/grupos/registrar')}}>
                        <button class = 'btn btn-success btn-flat' type ='submit'><i class="fa fa-file-text-o"></i> Novo Registro</button>
                  </form>
                 @endcan
                  </div>
        </div>

        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">

                <div class="box-body">

                    <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Nome Grupo</th>
                        <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dados as $value)

                        <tr>
                        <div class = 'row'>

                              <div class="col-xs-5">
                                    <td>{{$value->id}}</td>
                                    <td>{{$value->nome}}</td>
                              </div>
                         </div>

                            <td>
                                <div class = 'row'>

                                              <div class="col-xs-3">
                                              @if ($value->default != 1)

                                                    @can('verifica_permissao', [2,'excluir'])
                                                    <form id="excluir{{ $value->id }}" action="{{ URL::to('grupos/' . $value->id . '/delete') }}" method="DELETE">

                                                          <button
                                                              data-toggle="tooltip" data-placement="top" title="Excluir Ítem" type="submit"
                                                              class="btn btn-block btn-danger btn-sm"
                                                              onclick="return confirm('Confirma exclusão desse ítem ?');">
                                                              <i class="fa fa-trash-o"></i> Excluir</button>

                                                    </form>
                                                    @endcan

                                              @endif
                                              </div>

                                              <div class="col-xs-3">
                                              @can('verifica_permissao', [2,'alterar'])
                                                    <a href = "{{ URL::to('grupos/' . $value->id . '/edit') }}" class = 'btn btn-block  btn-info btn-sm' data-link = '/gupos/{{$value->id}}/edit'><i class="fa fa-edit"></i> Editar</a>
                                              @endcan
                                              </div>

                                              <div class="col-xs-3">
                                              @can('verifica_permissao', [2,'visualizar'])
                                                   <a href = "{{ URL::to('grupos/' . $value->id . '/preview') }}" class = 'btn btn-block btn-primary btn-sm'><i class="fa fa-search-plus"></i> Ver</a>
                                              @endcan
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


@endsection