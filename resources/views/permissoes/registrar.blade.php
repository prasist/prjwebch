@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Permissões do Grupo') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'permissoes') }}


<div class = 'row'>

    <div class="col-md-12">

      <div>
            <a href="{{ url('/permissoes')}}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
      </div>

        <form method = 'POST'  class="form-horizontal" action = {{ url('/permissoes/gravar')}}>
            <!--<input type = 'hidden' name = '_token' value = '{{Session::token()}}'>-->
            {!! csrf_field() !!}

        <div class="box box-primary">

                 <div class="box-body">

                            <div class="row{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="nome" class="control-label">Grupo</label>

                                          <select name="nome" class="form-control select2" style="width: 100%;">

                                          @foreach($dados as $item)
                                                <option  value="{{$item->id}}">{{$item->nome}}</option>
                                          @endforeach
                                          </select>
                                    </div>
                            </div>

                            <div class="row">

                                  <div class="box-header">

                                                <div class="box-body">

                                                <div id="tour6"></div>

                                                 <p><input  id= "selecionar_todos" name="selecionar_todos" type="checkbox" checked />  Selecionar todos</p>

                                                    <table id="paginas" class="table table-bordered table-hover">
                                                          <thead>
                                                              <tr>
                                                              <th>ID</th>
                                                              <th>Página</th>
                                                              <th><input  id= "selecionar_acessar" name="selecionar_acessar" type="checkbox" class="selecionar_acessar" checked/> Acessar</th>
                                                              <th><input  id= "selecionar_incluir" name="selecionar_incluir" type="checkbox"  class="selecionar_incluir" checked/> Incluir</th>
                                                              <th><input  id= "selecionar_alterar" name="selecionar_alterar" type="checkbox" class="selecionar_alterar" checked/> Alterar</th>
                                                              <th><input  id= "selecionar_excluir" name="selecionar_excluir" type="checkbox" class="selecionar_excluir" checked/> Excluir</th>
                                                              <th><input  id= "selecionar_visualizar" name="selecionar_visualizar" type="checkbox" class="selecionar_visualizar" checked/> Visualizar</th>
                                                              <th><input  id= "selecionar_exportar" name="selecionar_exportar" type="checkbox" class="selecionar_exportar" checked/> Exportar</th>
                                                              <th><input  id= "selecionar_imprimir" name="selecionar_imprimir" type="checkbox" class="selecionar_imprimir" checked/> Imprimir</th>
                                                              </tr>
                                                          </thead>
                                                          <tbody>
                                                              @foreach($paginas as $value)

                                                                <tr>
                                                                            <td> <input name="pagina[{{ $value->id }}]" type="text" value="{{ $value->id }}" hidden>{{ $value->id }}</td>
                                                                            <td>{{ $value->nome }}</td>
                                                                            <td>
                                                                                <input  name="acessar[{{ $value->id }}]" type="hidden"  value="0" />
                                                                                <input  name="acessar[{{ $value->id }}]" type="checkbox" class="acessar" value="1" checked />
                                                                            </td>
                                                                            <td>
                                                                                <input  name="incluir[{{ $value->id }}]" type="hidden" value="0" />
                                                                                <input  name="incluir[{{ $value->id }}]" type="checkbox" class="incluir" value="1" checked />
                                                                            </td>
                                                                            <td>
                                                                            <input  name="alterar[{{ $value->id }}]" type="hidden" value="0" />
                                                                            <input  name="alterar[{{ $value->id }}]" type="checkbox" class="alterar"  value="1" checked /></td>
                                                                            <td>
                                                                            <input  name="excluir[{{ $value->id }}]" type="hidden" value="0" />
                                                                            <input  name="excluir[{{ $value->id }}]" type="checkbox" class="excluir" value="1" checked /></td>
                                                                            <td>
                                                                            <input  name="visualizar[{{ $value->id }}]" type="hidden" value="0" />
                                                                            <input  name="visualizar[{{ $value->id }}]" type="checkbox" class="visualizar"  value="1"  checked /></td>
                                                                            <td>
                                                                            <input  name="exportar[{{ $value->id }}]" type="hidden" value="0" />
                                                                            <input  name="exportar[{{ $value->id }}]" type="checkbox" class="exportar" value="1" checked /></td>
                                                                            <td>
                                                                            <input  name="imprimir[{{ $value->id }}]" type="hidden" value="0" />
                                                                            <input  name="imprimir[{{ $value->id }}]" type="checkbox" class="imprimir" value="1" checked /></td>

                                                               </tr>

                                                              @endforeach

                                                          </tbody>
                                                    </table>
                                                </div>
                                  </div>

                            </div>

            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit'>Gravar</button>
            <a href="{{ url('/permissoes')}}" class="btn btn-default">Cancelar</a>
        </div>

        </form>

    </div>

</div>

@endsection

@section('tela_permissoes')

<script type="text/javascript">

                  $(function () {

                          $('#selecionar_todos').click(function() {

                            if ($(this).prop('checked')) {
                                $('.acessar').prop('checked', true);
                            } else {
                                $('.acessar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.incluir').prop('checked', true);
                            } else {
                                $('.incluir').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.alterar').prop('checked', true);
                            } else {
                                $('.alterar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.excluir').prop('checked', true);
                            } else {
                                $('.excluir').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.visualizar').prop('checked', true);
                            } else {
                                $('.visualizar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.exportar').prop('checked', true);
                            } else {
                                $('.exportar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.imprimir').prop('checked', true);
                            } else {
                                $('.imprimir').prop('checked', false);
                            }

                             if ($(this).prop('checked')) {
                                $('.selecionar_acessar').prop('checked', true);
                            } else {
                                $('.selecionar_acessar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.selecionar_incluir').prop('checked', true);
                            } else {
                                $('.selecionar_incluir').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.selecionar_alterar').prop('checked', true);
                            } else {
                                $('.selecionar_alterar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.selecionar_excluir').prop('checked', true);
                            } else {
                                $('.selecionar_excluir').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.selecionar_visualizar').prop('checked', true);
                            } else {
                                $('.selecionar_visualizar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.selecionar_exportar').prop('checked', true);
                            } else {
                                $('.selecionar_exportar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.selecionar_imprimir').prop('checked', true);
                            } else {
                                $('.selecionar_imprimir').prop('checked', false);
                            }

                        });

                        $('#selecionar_acessar').click(function() {
                            if ($(this).prop('checked')) {
                                $('.acessar').prop('checked', true);
                            } else {
                                $('.acessar').prop('checked', false);
                            }
                        });

                        $('#selecionar_incluir').click(function() {
                            if ($(this).prop('checked')) {
                                $('.incluir').prop('checked', true);
                            } else {
                                $('.incluir').prop('checked', false);
                            }
                        });

                        $('#selecionar_alterar').click(function() {
                            if ($(this).prop('checked')) {
                                $('.alterar').prop('checked', true);
                            } else {
                                $('.alterar').prop('checked', false);
                            }
                        });

                        $('#selecionar_excluir').click(function() {
                            if ($(this).prop('checked')) {
                                $('.excluir').prop('checked', true);
                            } else {
                                $('.excluir').prop('checked', false);
                            }
                        });

                        $('#selecionar_visualizar').click(function() {
                            if ($(this).prop('checked')) {
                                $('.visualizar').prop('checked', true);
                            } else {
                                $('.visualizar').prop('checked', false);
                            }
                        });

                        $('#selecionar_exportar').click(function() {
                            if ($(this).prop('checked')) {
                                $('.exportar').prop('checked', true);
                            } else {
                                $('.exportar').prop('checked', false);
                            }
                        });

                        $('#selecionar_imprimir').click(function() {
                            if ($(this).prop('checked')) {
                                $('.imprimir').prop('checked', true);
                            } else {
                                $('.imprimir').prop('checked', false);
                            }
                        });

               });

   </script>
@endsection