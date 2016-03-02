@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Pessoas') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'pessoas') }}
{{ \Session::put('id_pagina', '28') }}

        <div>{{{ $errors->first('erros') }}}</div>

        <div class="row">
                <div class="col-xs-2">
                @can('verifica_permissao', [ \Session::get('id_pagina'),'incluir'])

              <div class="input-group margin">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-new-window"></span>  Novo Registro
                        <span class="fa fa-caret-down"></span></button>
                        <ul class="dropdown-menu">

                          @foreach($tipos as $item)
                              <li><a href={{ url('/' . \Session::get('route') . '/registrar/' . $item->id )}}>{{ $item->nome }}</a></li>
                          @endforeach

                          <!--
                          <li><a href={{ url('/' . \Session::get('route') . '/registrar')}}>Membro</a></li>
                          <li class="divider"></li>
                          <li><a href={{ url('/' . \Session::get('route') . '/registrar')}}>Pessoa</a></li>
                          -->

                        </ul>
                  </div>
                  <br/>
              </div>

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
                        <th>Nome</th>
                        <th>Abrev.</th>
                        <th>Alterar</th>
                        <th>Visualizar</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach($dados as $value)

                        <tr>

                            <td>{{$value->razaosocial}}</td>
                            <td>{{$value->nomefantasia}}</td>

                            <td class="col-xs-1">
                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                            <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/edit') }}" class = 'btn  btn-info btn-sm'><spam class="glyphicon glyphicon-pencil"></spam></a>
                                      @endcan
                            </td>

                            <td class="col-xs-1">
                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                               <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/preview') }}" class = 'btn btn-primary btn-sm'><span class="glyphicon glyphicon-zoom-in"></span></a>
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