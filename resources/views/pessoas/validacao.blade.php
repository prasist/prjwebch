@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Pessoas') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'pessoas') }}
{{ \Session::put('id_pagina', '28') }}


        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header" data-original-title>
                <div class="box-body table-responsive no-padding">

                 <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                        <!--<th>ID</th>-->
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Alterar</th>
                        <th>Visualizar</th>
                        <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dados as $value)

                        <tr>

                            <td>{{$value->id}}</td>
                            <td>
                                  @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                  <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/edit') }}" data-toggle="tooltip" data-placement="top" title="Clique para Alterar">
                                        {{$value->razaosocial}}
                                  </a>
                                  @else
                                        @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                                <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/preview') }}" >
                                                      {{$value->razaosocial}}
                                                </a>
                                        @else
                                                {{$value->razaosocial}}
                                        @endcan
                                  @endcan
                            </td>

                            <td>{{$value->tipo}}</td>

                            <td class="col-xs-1">
                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                            <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/edit') }}" class = 'btn  btn-info btn-sm' data-toggle="tooltip" data-placement="top" title="Alterar Registro"><spam class="glyphicon glyphicon-pencil"></spam></a>
                                      @endcan
                            </td>

                            <td class="col-xs-1">
                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                               <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/preview') }}" class = 'btn btn-primary btn-sm' data-toggle="tooltip" data-placement="top" title="Visualizar Registro"><span class="glyphicon glyphicon-zoom-in"></span></a>
                                      @endcan
                            </td>
                            <td class="col-xs-1">
                                        @can('verifica_permissao', [ \Session::get('id_pagina') ,'excluir'])
                                        <form id="excluir{{ $value->id }}" action="{{ URL::to(\Session::get('route') . '/' . $value->id . '/delete') }}" method="DELETE">

                                              <button
                                                  data-toggle="tooltip" data-placement="top" title="Excluir Registro" type="submit"
                                                  class="btn btn-danger btn-sm"
                                                  onclick="return confirm('Confirma exclusão desse registro : {{ $value->razaosocial }} ?');">
                                                  <spam class="glyphicon glyphicon-trash"></spam></button>

                                        </form>
                                        @endcan
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