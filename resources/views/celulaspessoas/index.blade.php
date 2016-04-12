@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Células / Pessoas') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'celulaspessoas') }}
{{ \Session::put('id_pagina', '45') }}

        <div>{{{ $errors->first('erros') }}}</div>

        <div class="row">
                <div class="col-xs-2">
                @can('verifica_permissao', [ \Session::get('id_pagina'),'incluir'])
                  <form method = 'get' class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/registrar')}}>
                        <button class = 'btn btn-success btn-flat' type ='submit'><span class="glyphicon glyphicon-new-window"></span> Novo </button>
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
                        <!--<th>ID</th>-->
                        <th>Célula / Qtd. Participantes</th>
                        <th>Alterar</th>
                        <th>Visualizar</th>
                        <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($dados as $value)

                        <tr>

                            <!--<td>{{$value->celulas_id}}</td>-->
                            <td>{!! $value->nome !!} <span class="badge bg-blue">{!!$value->tot!!}</span></td>

                            <td class="col-xs-1">
                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                            <a href = "{{ URL::to(\Session::get('route') .'/' . $value->celulas_id . '/edit') }}" class = 'btn  btn-info btn-sm'><spam class="glyphicon glyphicon-pencil"></spam></a>
                                      @endcan
                            </td>

                            <td class="col-xs-1">
                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                               <a href = "{{ URL::to(\Session::get('route') .'/' . $value->celulas_id . '/preview') }}" class = 'btn btn-primary btn-sm'><span class="glyphicon glyphicon-zoom-in"></span></a>
                                      @endcan
                            </td>
                            <td class="col-xs-1">

                                    @can('verifica_permissao', [ \Session::get('id_pagina') ,'excluir'])
                                    <form id="excluir{{ $value->celulas_id }}" action="{{ URL::to(\Session::get('route') . '/' . $value->celulas_id . '/delete') }}" method="DELETE">

                                          <button
                                              data-toggle="tooltip" data-placement="top" title="Excluir Ítem" type="submit"
                                              class="btn btn-danger btn-sm"
                                              onclick="return confirm('Confirma exclusão desse registro : {{ $value->nome }} ?');">
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