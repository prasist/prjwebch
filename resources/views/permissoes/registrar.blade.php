@extends('principal.master')

@section('content')

<div class = 'row'>

    <div class="col-md-12">

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
                                                <option value="{{$item->id}}">{{$item->nome}}</option>
                                          @endforeach
                                          </select>
                                    </div>
                            </div>

                            <div class="row">

                                  <div class="box-header">

                                                <div class="box-body">

                                                    <table id="paginas" class="table table-bordered table-hover">
                                                          <thead>
                                                              <tr>
                                                              <th>ID</th>
                                                              <th>Página</th>
                                                              <th>Acessar</th>
                                                              <th>Incluir</th>
                                                              <th>Alterar</th>
                                                              <th>Excluir</th>
                                                              <th>Visualizar</th>
                                                              <th>Exportar</th>
                                                              <th>Imprimir</th>
                                                              </tr>
                                                          </thead>
                                                          <tbody>
                                                              @foreach($paginas as $value)

                                                                <tr>
                                                                            <td> <input name="pagina[{{ $value->id }}]" type="text" value="{{ $value->id }}">{{ $value->id }}</td>
                                                                            <td>{{ $value->nome }}</td>
                                                                            <td><input  name="acessar[{{ $value->id }}]" type="checkbox" class="minimal" checked></td>
                                                                            <td><input  name="incluir[{{ $value->id }}]" type="checkbox" class="minimal" checked></td>
                                                                            <td><input  name="alterar[{{ $value->id }}]" type="checkbox" class="minimal" checked></td>
                                                                            <td><input  name="excluir[{{ $value->id }}]" type="checkbox" class="minimal" checked></td>
                                                                            <td><input  name="visualizar[{{ $value->id }}]" type="checkbox" class="minimal" checked></td>
                                                                            <td><input  name="exportar[{{ $value->id }}]" type="checkbox" class="minimal" checked></td>
                                                                            <td><input  name="imprimir[{{ $value->id }}]" type="checkbox" class="minimal" checked></td>

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
        </div>

        </form>

    </div>

</div>

@endsection