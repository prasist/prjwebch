@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Células') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'celulas') }}
{{ \Session::put('id_pagina', '42') }}


        <div>{{{ $errors->first('erros') }}}</div>

        <div class="row">
                <div class="col-xs-2">
                @can('verifica_permissao', [ \Session::get('id_pagina'),'incluir'])
                  <form method = 'get' class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/registrar')}}>
                        <button class = 'btn btn-success btn-flat' type ='submit'><i class="fa fa-file-text-o"></i> Criar Nova Célula</button>
                  </form>
                @endcan
                </div>
        </div>

        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">

                <div class="box-body">

                    <table id="table_celulas" class="table table-responsive table-hover">
                    <thead>
                        <tr>
                        <th>Líder / Nome Célula</th>
                        <th>Dia Encontro</th>
                        <th>Região</th>
                        <th>Horário</th>
                        <th>Cor</th>
                        <th>Alterar</th>
                        <th>Visualizar</th>
                        <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dados as $value)

                        <tr>
                            <td>
                                  @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                  <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/edit') }}" data-toggle="tooltip" data-placement="top" title="Clique para Alterar">
                                       {!! $value->razaosocial . ($value->nome!="" ? ' - ' : ''). $value->nome !!} <span class="badge bg-blue">{!!$value->tot!!}</span>
                                  </a>
                                  @else
                                        @can('verifica_permissao', [\Session::get('id_pagina') ,'visualizar'])
                                                <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/preview') }}" >
                                                      {!! $value->razaosocial . ($value->nome!="" ? ' - ' : ''). $value->nome !!} <span class="badge bg-blue">{!!$value->tot!!}</span>
                                                </a>
                                        @else
                                                {!! $value->razaosocial . ($value->nome!="" ? ' - ' : ''). $value->nome !!} <span class="badge bg-blue">{!!$value->tot!!}</span>
                                        @endcan
                                  @endcan

                            </td>
                            <td>{!! $value->descricao_dia_encontro !!}</td>
                            <td>{!! $value->regiao !!}</td>
                            <td>{!! $value->horario !!}</td>
                            <td style="color: #{!! rtrim(ltrim($value->cor)) !!};  background-color:#{!! rtrim(ltrim($value->cor)) !!};">
                                  {!! rtrim(ltrim($value->cor)) !!}
                            </td>

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

                            <td class="col-xs-1">

                                                @can('verifica_permissao', [ \Session::get('id_pagina') ,'excluir'])
                                                <form id="excluir{{ $value->id }}" action="{{ URL::to(\Session::get('route') . '/' . $value->id . '/delete') }}" method="DELETE">

                                                      <button
                                                          data-toggle="tooltip" data-placement="top" title="Excluir Registro" type="submit"
                                                          class="btn btn-danger btn-sm"
                                                          onclick="return confirm('Confirma exclusão do registro ?');">
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

<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_celulas").addClass("treeview active");
    });
</script>
@endsection