@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Contas à Pagar') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'titulos') }}
{{ \Session::put('id_pagina', '52') }}

        <div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
        <div>{{{ $errors->first('erros') }}}</div>

        <div class="row">
                <div class="col-xs-2">
                @can('verifica_permissao', [ \Session::get('id_pagina'),'incluir'])
                  <form method = 'get' class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/registrar')}}>
                        <button class = 'btn btn-success btn-flat' type ='submit'><span class="glyphicon glyphicon-new-window"></span> Novo Pagamento</button>
                  </form>
                @endcan
                </div>
        </div>

        <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">

                <div class="box-body">

                    <table id="example" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                        <th><input  id="check_todos" name="check_todos" type="checkbox" /></th>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Data Pagto.</th>
                        <th>Acrésc.</th>
                        <th>Desc.</th>
                        <th>Valor Pago.</th>
                        <th>Pago</th>
                        <th>Alterar</th>
                        <th>Visualizar</th>
                        <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dados as $value)

                        <tr>

                            <td><input  id="check_id" name="check_id" type="checkbox" /></td>
                            <td>
                                    <a href="#" class="data_venc"  data-type="text" data-column="data_venc" data-url="{{ url('/titulos/{!!$value->id!!}/update_inline')}}" data-pk="{!!$value->id!!}" data-title="change" data-name="data_venc">
                                        {{$value->data_vencimento}}
                                    </a>
                            </td>
                            <td>
                                    <a href="#" class="descricao"  data-type="text" data-column="descricao" data-url="{{ url('/titulos/{!!$value->id!!}/update_inline')}}" data-pk="{!!$value->id!!}" data-title="change" data-name="descricao">
                                        {{$value->descricao}}
                                    </a>
                            </td>
                            <td>
                                    <a href="#" class="valor"  data-type="text" data-column="valor" data-url="{{ url('/titulos/{!!$value->id!!}/update_inline')}}" data-pk="{!!$value->id!!}" data-title="change" data-name="valor">
                                        {{$value->valor}}
                                    </a>
                            </td>
                            <td>{{$value->data_pagamento}}</td>
                            <td>{{$value->acrescimo}}</td>
                            <td>{{$value->desconto}}</td>
                            <td></td>
                            <td><input  id="check_pago[]" name="check_pago[]" type="checkbox" value="{{$value->id}}" class="chkpago" /></td>

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
                                              data-toggle="tooltip"
                                              data-placement="top"
                                              title="Excluir Ítem"
                                              type="submit"
                                              class="btn btn-danger btn-sm"
                                              onclick="return confirm('Confirma exclusão desse registro : {{ $value->descricao }} ?');">
                                              <spam class="glyphicon glyphicon-trash"></spam>
                                          </button>

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

        $.fn.editable.defaults.mode = 'inline';

        $(document).ready(function() {

            $('.chkpago').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
            });

            $('.descricao').editable({
                params: function(params) {
                    // add additional params from data-attributes of trigger element
                    params.name = $(this).editable().data('descricao');
                    params._token = $("#_token").data("token");
                    return params;
                },
                error: function(response, newValue) {
                    if(response.status === 500) {
                        return 'Server error. Check entered data.';
                    } else {
                        return response.responseText;
                        // return "Error.";
                    }
                }
            });

            /*Tabela editavel - colunas*/
            $('.data_venc').editable({
                params: function(params) {
                    // add additional params from data-attributes of trigger element
                    params.name = $(this).editable().data('data_venc');
                    params._token = $("#_token").data("token");
                    return params;
                },
                error: function(response, newValue) {
                    if(response.status === 500) {
                        return 'Server error. Check entered data.';
                    } else {
                        return response.responseText;
                        // return "Error.";
                    }
                }
            });

            /*Tabela editavel - colunas*/
            $('.valor').editable({
                params: function(params) {
                    // add additional params from data-attributes of trigger element
                    params.name = $(this).editable().data('valor');
                    params._token = $("#_token").data("token");
                    return params;
                },
                error: function(response, newValue) {
                    if(response.status === 500) {
                        return 'Server error. Check entered data.';
                    } else {
                        return response.responseText;
                        // return "Error.";
                    }
                }
            });

        });

</script>

@endsection