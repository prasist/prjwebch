@extends('principal.master')

@section('content')

        <p>Usuários</p>

        <div>{{{ $errors->first('erros') }}}</div>

        <div class="row">
                <div class="col-xs-2">
                @can('verifica_permissao', [5,'incluir'])
                  <form method = 'get' class="form-horizontal" action = {{ url('/usuarios/registrar')}}>
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
                        <th>Nome Usuário</th>
                        <th>Email</th>
                        <th>Igreja/Instituição</th>
                        <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $value)

                        <tr>
                              <div class = 'row'>
                                   <div class="col-xs-5">
                                        <td>{{$value->id}}</td>
                                        <td>{{$value->name}}</td>
                                        <td>{{$value->email}}</td>
                                        <td>{{$value->razaosocial}}</td>
                                   </div>
                               </div>

                            <td>

                            <div class = 'row'>
                                    <div class="col-xs-4">
                                    @if ($value->master != 1)

                                          @can('verifica_permissao', [5,'excluir'])
                                          <form id="excluir{{ $value->id }}" action="{{ URL::to('usuarios/' . $value->id . '/delete') }}" method="DELETE">

                                                <button
                                                    data-toggle="tooltip"
                                                    data-placement="top" title="Excluir Ítem" type="submit"
                                                    class="btn btn-block  btn-danger btn-sm"
                                                    onclick="return confirm('Confirma exclusão desse registro ?');">
                                                    <i class="fa fa-trash-o"></i> Excluir</button>

                                          </form>
                                          @endcan

                                    @endif
                                    </div>

                                    <div class="col-xs-4">
                                      @can('verifica_permissao', [5,'alterar'])
                                             <a href = "{{ URL::to('usuarios/' . $value->id . '/edit') }}" class = 'btn btn-block btn-info btn-sm' data-link = '/users/{{$value->id}}/edit'><i class="fa fa-edit"></i> Editar</a>
                                      @endcan
                                    </div>

                                    <div class="col-xs-4">
                                      @can('verifica_permissao', [5,'visualizar'])
                                          <a href = "{{ URL::to('usuarios/' . $value->id . '/preview') }}" class = 'btn  btn-block btn-primary btn-sm'><i class="fa fa-search-plus"></i> Visualizar</a>
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