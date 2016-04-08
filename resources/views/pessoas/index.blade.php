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

        <div class="row">
          <div class="col-md-12">
              <div>
                  <a href="{{ URL::to(\Session::get('route') .'/A/buscar_nome') }}" class="btn btn-default">A</a><a href="{{ URL::to(\Session::get('route') .'/B/buscar_nome') }}" class="btn btn-default">B</a><a href="{{ URL::to(\Session::get('route') .'/C/buscar_nome') }}" class="btn btn-default">C</a><a href="{{ URL::to(\Session::get('route') .'/D/buscar_nome') }}" class="btn btn-default">D</a><a href="{{ URL::to(\Session::get('route') .'/E/buscar_nome') }}" class="btn btn-default">E</a><a href="{{ URL::to(\Session::get('route') .'/F/buscar_nome') }}" class="btn btn-default">F</a><a href="{{ URL::to(\Session::get('route') .'/G/buscar_nome') }}" class="btn btn-default">G</a><a href="{{ URL::to(\Session::get('route') .'/H/buscar_nome') }}" class="btn btn-default">H</a><a href="{{ URL::to(\Session::get('route') .'/I/buscar_nome') }}" class="btn btn-default">I</a><a href="{{ URL::to(\Session::get('route') .'/J/buscar_nome') }}" class="btn btn-default">J</a><a href="{{ URL::to(\Session::get('route') .'/K/buscar_nome') }}" class="btn btn-default">K</a><a href="{{ URL::to(\Session::get('route') .'/L/buscar_nome') }}" class="btn btn-default">L</a><a href="{{ URL::to(\Session::get('route') .'/M/buscar_nome') }}" class="btn btn-default">M</a><a href="{{ URL::to(\Session::get('route') .'/N/buscar_nome') }}" class="btn btn-default">N</a><a href="{{ URL::to(\Session::get('route') .'/O/buscar_nome') }}" class="btn btn-default">O</a><a href="{{ URL::to(\Session::get('route') .'/P/buscar_nome') }}" class="btn btn-default">P</a><a href="{{ URL::to(\Session::get('route') .'/Q/buscar_nome') }}" class="btn btn-default">Q</a><a href="{{ URL::to(\Session::get('route') .'/R/buscar_nome') }}" class="btn btn-default">R</a><a href="{{ URL::to(\Session::get('route') .'/S/buscar_nome') }}" class="btn btn-default">S</a><a href="{{ URL::to(\Session::get('route') .'/T/buscar_nome') }}" class="btn btn-default">T</a><a href="{{ URL::to(\Session::get('route') .'/U/buscar_nome') }}" class="btn btn-default">U</a><a href="{{ URL::to(\Session::get('route') .'/V/buscar_nome') }}" class="btn btn-default">V</a><a href="{{ URL::to(\Session::get('route') .'/X/buscar_nome') }}" class="btn btn-default">X</a><a href="{{ URL::to(\Session::get('route') .'/Y/buscar_nome') }}" class="btn btn-default">Y</a><a href="{{ URL::to(\Session::get('route') .'/W/buscar_nome') }}" class="btn btn-default">W</a><a href="{{ URL::to(\Session::get('route') .'/Z/buscar_nome') }}" class="btn btn-default">Z</a>
              </div>
          </div>
      </div>

        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header" data-original-title>
                <div class="box-body table-responsive no-padding">

                    <table id="example2" class="table table-hover">
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
                                                  onclick="return confirm('Confirma exclusão desse registro : {!! $value->nome !!} ?');">
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

@section('data_table_custom')
<script type="text/javascript">

        $(function ()
        {
                  $("#example2").DataTable({
                      language: {
                      searchPlaceholder: "Nome, CNPJ, CPF, Telefone..."
                      }
                  });

        });

</script>
@endsection