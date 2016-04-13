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
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"><span class="fa fa-user-plus"></span>  Novo Registro
                        <span class="fa fa-caret-down"></span></button>
                        <ul class="dropdown-menu">

                          <!-- Carrega todos os tipos de pessoas, cria uma rota passando o ID do tipo de pessoa. Com esse ID a interface habilitara ou nao campos -->
                          @foreach($tipos as $item)
                              <li><a href={{ url('/' . \Session::get('route') . '/registrar/' . $item->id )}}>{{ $item->nome }}</a></li>
                          @endforeach

                        </ul>
                  </div>
                  <br/>
              </div>

                @endcan
                </div>
        </div>


@include('pessoas.filtros_pesquisa')


        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header" data-original-title>
                <div class="box-body table-responsive no-padding">

                    <table id="tab_pessoas" class="table table-hover">
                    <thead>
                        <tr>
                        <th>Nome</th>
                        <th>Abrev.</th>
                        <th>Tipo Pessoa</th>
                        <th>CNPJ/CPF</th>
                        <th>Telefone</th>
                        <th>Alterar</th>
                        <th>Visualizar</th>
                        <th>Excluir</th>

                        </tr>
                    </thead>
                    <tbody>


                         @foreach($dados as $value)

                        <tr>

                            <td>{!!$value->razaosocial!!}</td>
                            <td>{!!$value->nomefantasia!!}</td>
                            <td>{!!$value->nome_tipo_pessoa!!}</td>
                            <td>{!!$value->cnpj_cpf!!}</td>
                            <td>{!! "(".substr($value->fone_principal, 0, 2).") ".substr($value->fone_principal, 2, 10) !!}</td>

                            <td class="col-xs-1">
                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                            <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/edit/' . $value->id_tipo_pessoa) }}" class = 'btn  btn-info btn-sm'><spam class="glyphicon glyphicon-pencil"></spam></a>
                                      @endcan
                            </td>

                            <td class="col-xs-1">
                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                               <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/preview/' . $value->id_tipo_pessoa) }}" class = 'btn btn-primary btn-sm'><span class="glyphicon glyphicon-zoom-in"></span></a>
                                      @endcan
                            </td>
                            <td class="col-xs-1">

                                        @can('verifica_permissao', [ \Session::get('id_pagina') ,'excluir'])
                                        <form id="excluir{{ $value->id }}" action="{{ URL::to(\Session::get('route') . '/' . $value->id . '/delete') }}" method="DELETE">

                                              <button
                                                  data-toggle="tooltip" data-placement="top" title="Excluir Ítem" type="submit"
                                                  class="btn btn-danger btn-sm"
                                                  onclick="return confirm('Confirma exclusão desse registro : {!! $value->razaosocial !!} ?');">
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