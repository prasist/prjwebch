@extends('principal.master')

@section('content')


        <p>Igrejas / Instituições</p>

        <div>{{{ $errors->first('erros') }}}</div>

        <div class="row">
                <div class="col-xs-2">
                @can('verifica_permissao', [7,'incluir'])
                  <form method = 'get' class="form-horizontal" action = {{ url('/empresas/registrar')}}>
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

                    <table id="example1" class="table table-bordered table-striped">
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
                          <div class = 'row'>
                                <div class="col-xs-5">
                                      <td>{{$value->razaosocial}}</td>
                                      <td>{{$value->nomefantasia}}</td>
                                      <td>{{$value->cnpj}}</td>
                                      <td>{{$value->inscricaoestadual}}</td>
                                </div>
                          </div>

                            <td>

                                  <div class = 'row'>

                                    <div class="col-xs-3">
                                     @if ($value->igreja_sede != 1)

                                           @can('verifica_permissao', [7,'excluir'])
                                           <form id="excluir{{ $value->id }}" action="{{ URL::to('empresas/' . $value->id . '/delete') }}" method="DELETE">

                                                  <button data-toggle="tooltip" data-placement="top" title="Excluir" type="submit"
                                                      class="btn btn-danger btn-sm"
                                                      onclick="return confirm('Confirma exclusão desse ítem ?');">
                                                      <i class="fa fa-trash-o"></i> Excluir</button>
                                            </form>
                                           @endcan

                                     @endif
                                    </div>

                                     <div class="col-xs-3">
                                      @can('verifica_permissao', [7,'alterar'])
                                             <a href = "{{ URL::to('empresas/' . $value->id . '/edit') }}" data-toggle="tooltip" data-placement="top" title="Editar" class = 'btn btn-info btn-sm' data-link = '/empresas/{{$value->id}}/edit'><i class="fa fa-edit"></i> Alterar</a>
                                      @endcan
                                      </div>

                                      <div class="col-xs-3">
                                      @can('verifica_permissao', [7,'visualizar'])
                                            <a href = "{{ URL::to('empresas/' . $value->id . '/preview') }}" data-toggle="tooltip" data-placement="top" title="Visualizar" class = 'btn btn-primary btn-sm' data-link = '/empresas/{{$value->id}}'><i class="fa fa-search-plus"></i> Ver</a>
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