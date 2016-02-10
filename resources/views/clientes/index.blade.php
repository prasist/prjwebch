@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Igreja Sede') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'clientes') }}

        <div>{{{ $errors->first('erros') }}}</div>
        <div class="row">
        <div class="col-md-12">
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

                        @foreach($clientes_cloud as $value)

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
                                    <div class="col-xs-5">
                                    @can('verifica_permissao', [1, 'alterar'])
                                          <a href = "{{ URL::to('clientes/' . $value->id . '/edit') }}" class = 'btn btn-block btn-info btn-sm' data-link = '/cliente/{{$value->id}}/edit'><i class="fa fa-edit"></i> Editar</a>
                                    @endcan
                                    </div>

                                    <div class="col-xs-5">
                                    @can('verifica_permissao', ['1', 'visualizar'])
                                            <a href = "{{ URL::to('clientes/' . $value->id . '/preview') }}" class = 'btn btn-block btn-primary btn-sm' data-link = '/cliente/{{$value->id}}'><i class="fa fa-search-plus"></i> Visualizar</a>
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


    <div id="modal1" class="modal">
        <div class = "row AjaxisModal">
        </div>
    </div>

@endsection