@extends('principal.master')

@section('content')

<div class = 'row'>

    <div class="col-md-12">

      <div>
            <a href="{{ url('/permissoes')}}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
      </div>

        <form method = 'POST'  class="form-horizontal" action = {{ url('/permissoes/update')}}>
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
                                                 <p><input  id= "selecionar_todos" name="selecionar_todos" type="checkbox" />  Selecionar todos</p>

                                                    <table id="paginas" class="table table-bordered table-hover">
                                                          <thead>
                                                              <tr>
                                                              <th>ID</th>
                                                              <th>Página</th>
                                                              <th><input  id= "selecionar_acessar" name="selecionar_acessar" type="checkbox" class="selecionar_acessar" /> Acessar</th>
                                                              <th><input  id= "selecionar_incluir" name="selecionar_incluir" type="checkbox"  class="selecionar_incluir" /> Incluir</th>
                                                              <th><input  id= "selecionar_alterar" name="selecionar_alterar" type="checkbox" class="selecionar_alterar"/> Alterar</th>
                                                              <th><input  id= "selecionar_excluir" name="selecionar_excluir" type="checkbox" class="selecionar_excluir"/> Excluir</th>
                                                              <th><input  id= "selecionar_visualizar" name="selecionar_visualizar" type="checkbox" class="selecionar_visualizar"/> Visualizar</th>
                                                              <th><input  id= "selecionar_exportar" name="selecionar_exportar" type="checkbox" class="selecionar_exportar"/> Exportar</th>
                                                              <th><input  id= "selecionar_imprimir" name="selecionar_imprimir" type="checkbox" class="selecionar_imprimir"/> Imprimir</th>
                                                              </tr>
                                                          </thead>
                                                          <tbody>
                                                              @foreach($paginas as $value)

                                                                <tr>
                                                                            <td> <input name="pagina[{{ $value->id }}]" type="text" value="{{ $value->id }}" hidden>{{ $value->id }}</td>
                                                                            <td>{{ $value->nome }}</td>
                                                                            <td>
                                                                                <input  name="acessar[{{ $value->id }}]" type="hidden"  value="0" />
                                                                                <input  name="acessar[{{ $value->id }}]" type="checkbox" class="acessar" value="1" {{ ($value->acessar != 0 ? 'checked' : '') }} />
                                                                            </td>
                                                                            <td>
                                                                                <input  name="incluir[{{ $value->id }}]" type="hidden" value="0" />
                                                                                <input  name="incluir[{{ $value->id }}]" type="checkbox" class="incluir" value="1" {{ ($value->incluir != 0 ? 'checked' : '') }} />
                                                                            </td>
                                                                            <td>
                                                                            <input  name="alterar[{{ $value->id }}]" type="hidden" value="0" />
                                                                            <input  name="alterar[{{ $value->id }}]" type="checkbox" class="alterar"  value="1" {{ ($value->alterar != 0 ? 'checked' : '') }} /></td>
                                                                            <td>
                                                                            <input  name="excluir[{{ $value->id }}]" type="hidden" value="0" />
                                                                            <input  name="excluir[{{ $value->id }}]" type="checkbox" class="excluir" value="1" {{ ($value->excluir != 0 ? 'checked' : '') }} /></td>
                                                                            <td>
                                                                            <input  name="visualizar[{{ $value->id }}]" type="hidden" value="0" />
                                                                            <input  name="visualizar[{{ $value->id }}]" type="checkbox" class="visualizar"  value="1"  {{ ($value->visualizar != 0 ? 'checked' : '') }}/></td>
                                                                            <td>
                                                                            <input  name="exportar[{{ $value->id }}]" type="hidden" value="0" />
                                                                            <input  name="exportar[{{ $value->id }}]" type="checkbox" class="exportar" value="1" {{ ($value->exportar != 0 ? 'checked' : '') }}/></td>
                                                                            <td>
                                                                            <input  name="imprimir[{{ $value->id }}]" type="hidden" value="0" />
                                                                            <input  name="imprimir[{{ $value->id }}]" type="checkbox" class="imprimir" value="1" {{ ($value->imprimir != 0 ? 'checked' : '') }} /></td>

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
            <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}>Gravar</button>
            <a href="{{ url('/permissoes')}}" class="btn btn-default">Cancelar</a>
        </div>

        </form>

    </div>

</div>


@endsection