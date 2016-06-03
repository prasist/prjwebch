@extends('principal.master')

@section('content')

@if ($tipo=="P")
    {{ \Session::put('titulo', 'Contas à Pagar') }}
@else
    {{ \Session::put('titulo', 'Contas à Receber') }}
@endif
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'titulos') }}
{{ \Session::put('id_pagina', '52') }}

        <div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
        <div>{{{ $errors->first('erros') }}}</div>


        <div class="row">
                <div class="col-xs-2">
                @can('verifica_permissao', [ \Session::get('id_pagina'),'incluir'])
                  <form method = 'get' class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/registrar/' . $tipo)}}>
                        <button class = 'btn btn-success btn-flat' type ='submit'><span class="glyphicon glyphicon-new-window"></span> Nova Despesa</button>
                  </form>
                @endcan
                </div>

               <form method = 'post' class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/filtrar/' . $tipo)}}>
               {!! csrf_field() !!}

                <div class="col-xs-3">
                        <div class="btn-group">
                          <button type="button" class="btn btn-success">Ações (Selecionados)</button>
                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Baixar</a></li>
                            <li><a href="#">Estornar</a></li>
                            <li><a href="#">Excluir</a></li>
                          </ul>
                        </div>
                </div>


                <div class="col-xs-2">
                         <select name="status" id="status" class="form-control selectpicker" data-style="btn-primary" style="width: 100%;">
                         <option  style="background: #2A4F6E; color: #fff;" value="T" {{ $post_status == 'T' ? 'selected' : ''}}>Mostrar Todos</option>
                         <option  style="background: #F1E8B8; color: #000;" value="A" {{ $post_status == 'A' ? 'selected' : ''}}>Somente em Aberto</option>
                         <option  style="background: #2A7E43; color: #fff;" value="B"{{ $post_status == 'B' ? 'selected' : ''}}>Somente Baixados</option>
                         </select>
                </div>

                <div class="col-xs-2">
                         <select name="mes" id="mes" class="form-control selectpicker" data-style="btn-info" style="width: 100%;">
                         <option  value="C" {{ $post_mes == 'C' ? 'selected' : ''}}>Mês Corrente</option>
                         <option  value="E" {{ $post_mes == 'E' ? 'selected' : ''}}>Período Específico...</option>
                         </select>
                         <div id="div_periodo" style="display: none">
                                <div class="input-group">
                                     <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                      </div>

                                      <input id ="data_inicial" name = "data_inicial" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                      <input id ="data_final" name = "data_final" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                              </div>
                         </div>
                </div>

                <div class="col-xs-2">
                        <button class = 'btn btn-default btn-flat' type ='submit'><span class="glyphicon glyphicon-new-window"></span> Aplicar Filtro</button>
                </div>

                </form>


        </div>

        <p></p>
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
                        <th>Editar</th>
                        <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dados as $value)

                        <tr>

                            <td><input  id="check_id" name="check_id" type="checkbox" /></td>
                            <td>
                                    <a href="#"
                                    class="data_venc"
                                    data-type="text"
                                    data-column="data_venc"
                                    data-url="{{ url('/titulos/' . $value->id . '/update_inline/data_venc/' . $tipo)}}"
                                    data-pk="{!!$value->id!!}"
                                    data-title="change"
                                    data-name="data_venc">
                                    {{$value->data_vencimento}}
                                    </a>

                            </td>
                            <td>
                                    <a href="#" class="descricao"  data-type="text" data-column="descricao" data-url="{{ url('/titulos/' . $value->id . '/update_inline/descricao/' . $tipo)}}" data-pk="{!!$value->id!!}" data-title="change" data-name="descricao">
                                        {{$value->descricao}}
                                    </a>
                            </td>
                            <td>
                                    <a href="#" id="valor[{!!$value->id!!}]" class="valor"  data-type="text" data-column="valor" data-url="{{ url('/titulos/' . $value->id . '/update_inline/valor/' . $tipo)}}" data-pk="{!!$value->id!!}" data-title="change" data-name="valor">
                                        {{$value->valor}}
                                    </a>
                            </td>
                            <td>
                                    <a href="#" id="data_pagto[{!!$value->id!!}]" name="data_pagto[{!!$value->id!!}]" class="data_pagto"  data-type="text" data-column="data_pagto" data-url="{{ url('/titulos/' . $value->id . '/update_inline/data_pagto/' . $tipo)}}" data-pk="{!!$value->id!!}" data-title="change" data-name="data_pagto">
                                         {{$value->data_pagamento}}
                                    </a>

                            </td>
                            <td>
                                    <a href="#" class="acrescimo"  data-type="text" data-column="acrescimo" data-url="{{ url('/titulos/' . $value->id . '/update_inline/acrescimo/' . $tipo)}}" data-pk="{!!$value->id!!}" data-title="change" data-name="acrescimo">
                                        {{$value->acrescimo}}
                                    </a>
                            </td>
                            <td>
                                    <a href="#" class="desconto"  data-type="text" data-column="desconto" data-url="{{ url('/titulos/' . $value->id . '/update_inline/desconto/' . $tipo)}}" data-pk="{!!$value->id!!}" data-title="change" data-name="desconto">
                                        {{$value->desconto}}
                                    </a>
                            </td>
                            <td>
                                    <a href="#" id="valor_pago[{!!$value->id!!}]" class="valor_pago"  data-type="text" data-column="valor_pago" data-url="{{ url('/titulos/' . $value->id . '/update_inline/valor_pago/' . $tipo)}}" data-pk="{!!$value->id!!}" data-title="change" data-name="valor_pago">
                                        {{$value->valor_pago}}
                                    </a>
                            </td>

                            <td>

                                    <a href="#" id="check_pago[{!!$value->id!!}]"
                                    class="check_pago"
                                    data-type="select" data-column="check_pago"
                                    data-url="{{ url('/titulos/' . $value->id . '/update_inline/check_pago/' . $tipo)}}"
                                    data-pk="{!!$value->id!!}"
                                    data-title="change"
                                    data-name="check_pago">
                                        @if ($value->status =="B")
                                        <i class='fa fa-thumbs-o-up'></i>
                                        @else
                                        <i class='fa fa-thumbs-o-down'></i>
                                        @endif

                                        {{($value->status =="B" ? "SIm" : "Não")}}
                                    </a>

                            </td>

                            <td class="col-xs-1">
                                      @can('verifica_permissao', [\Session::get('id_pagina') ,'alterar'])
                                            <a href = "{{ URL::to(\Session::get('route') .'/' . $value->id . '/edit/' . $tipo) }}" class = 'btn  btn-info btn-sm'><spam class="glyphicon glyphicon-pencil"></spam></a>
                                      @endcan
                            </td>

                            <td class="col-xs-1">

                                    @can('verifica_permissao', [ \Session::get('id_pagina') ,'excluir'])
                                    <form id="excluir{{ $value->id }}" action="{{ URL::to(\Session::get('route') . '/' . $value->id . '/delete/' . $tipo) }}" method="DELETE">

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


            $('#mes').change(function()
            {
                  if ($(this).prop('value')=="E")
                     $("#div_periodo").show();
                  else
                    $("#div_periodo").hide();
            });

            $('.chkpago').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
            });

            $('.check_pago').editable({
                 value: [0, 1],
                 source: [
                    {value: 0, text: 'Sim'},
                    {value: 1, text: 'Não'}
                ],
                params: function(params) {
                    // add additional params from data-attributes of trigger element
                    params.name = $(this).editable().data('check_pago');
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


            $('.descricao').editable({
                validate: function(value) {
                    if($.trim(value) == '') {
                        return 'Campo Obrigatório';
                    }
                },
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
                validate: function(value) {
                    alert($.trim(value));
                    if($.trim(value) == '') {
                        return 'Campo Obrigatório';
                    }
                },
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
            $('.data_pagto').editable({
                params: function(params) {
                    // add additional params from data-attributes of trigger element
                    params.name = $(this).editable().data('data_pagto');
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
                validate: function(value) {
                    if($.trim(value) == '') {
                        return 'Campo Obrigatório';
                    }
                },
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


            $('.valor_pago').editable({
                params: function(params) {
                    // add additional params from data-attributes of trigger element
                    params.name = $(this).editable().data('valor_pago');
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


            $('.acrescimo').editable({
                params: function(params) {
                    // add additional params from data-attributes of trigger element
                    params.name = $(this).editable().data('acrescimo');
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

            $('.desconto').editable({
                params: function(params) {
                    // add additional params from data-attributes of trigger element
                    params.name = $(this).editable().data('desconto');
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