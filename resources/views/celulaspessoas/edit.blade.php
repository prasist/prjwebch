@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Células / Participantes') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'celulaspessoas') }}
{{ \Session::put('id_pagina', '45') }}

<div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href={{ url('/' . \Session::get('route')) }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

    <form method = 'POST' class="form-horizontal"  action = {{ url('/' . \Session::get('route') . '/' . $dados[0]->celulas_id . '/update')}}>

    {!! csrf_field() !!}

    <div class="box box-default">

          <div class="box-body">

                  <div class="row">

                        <div class="col-xs-11 {{ $errors->has('celulas') ? ' has-error' : '' }}">

                                <label for="celulas" class="control-label">Célula</label>
                                <select id="celulas" placeholder="(Selecionar)" name="celulas" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;" disabled=disabled>
                                <option  value="0"></option>
                                @foreach($celulas as $item)
                                       <option  value="{{$item->id}}" {{ ($dados[0]->celulas_id== $item->id ? 'selected' : '') }}>{{$item->nome}}</option>
                                @endforeach
                                </select>
                        </div>

                        <!-- se houver erros na validacao do form request -->
                        @if ($errors->has('celulas'))
                        <span class="help-block">
                            <strong>{{ $errors->first('celulas') }}</strong>
                        </span>
                        @endif

                  </div>

                  <div class="row">

                        <div class="col-xs-11 {{ $errors->has('pessoas') ? ' has-error' : '' }}">
                                <label for="pessoas" class="control-label">Localizar Participante :</label>
                                <div class="input-group">
                                         <div class="input-group-addon">
                                            <button  id="buscarpessoa2" type="button"  data-toggle="modal" data-target="#modal_pessoas" >
                                                   <i class="fa fa-search"></i> ...
                                             </button>
                                         </div>

                                          @include('modal_buscar_pessoas', array('qual_campo'=>'pessoas', 'modal' => 'modal_pessoas'))

                                          <input id="pessoas"  name = "pessoas" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >

                                          <!-- se houver erros na validacao do form request -->
                                           @if ($errors->has('pessoas'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('pessoas') }}</strong>
                                            </span>
                                           @endif

                                  </div>
                         </div>

                  </div>

                  <div class="row">
                     <div class="col-xs-11">
                        <br/>
                        <button onclick="AddTableRow()" type="button" class="btn btn-info" {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-user-plus"></i> Incluir Participante na Célula</button>
                        <br/>
                        <br/>

                        <table id="example" class="table table-bordered table-hover">
                            <tbody>
                             <tr>
                               <!--<th>Célula</th>-->
                               <th>Pessoa</th>
                               <th>Remover</th>
                             </tr>

                            @foreach($dados as $item)
                             <tr>
                               <!--<td>{!! $item->descricao_concatenada !!}</td>-->
                               <td>{!! $item->descricao_pessoa !!}</td>
                               <td>

                                  <!--
                                    <a href="#" class="btn btn-danger btn-sm" onclick="RemoveTableRow(this)" {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><spam class="glyphicon glyphicon-trash"></spam></a>
                                    <input id="hidden_celulas[]"  name = "hidden_celulas[]" type="hidden" value="{!! $item->celulas_id !!}">
                                    <input id="hidden_pessoas[]"  name = "hidden_pessoas[]" type="hidden" value="{!! $item->pessoas_id !!}">
                                    <input id="hidden_lider_celulas[]"  name = "hidden_lider_celulas[]" type="hidden" value="{!! $item->descricao_concatenada !!}">
                                  -->
                                    @can('verifica_permissao', [ \Session::get('id_pagina') ,'excluir'])
                                    <form id="excluir{{ $item->celulas_id }}" action="{{ URL::to(\Session::get('route') . '/' . $item->celulas_id . '/remover_membro/' . $item->pessoas_id) }}" method="DELETE">

                                          <button
                                              data-toggle="tooltip" data-placement="top" title="Remover Participante" type="submit"
                                              class="btn btn-danger btn-sm"
                                              onclick="return confirm('Deseja remover : {{ $item->descricao_pessoa }} da Célula ?');">
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

            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-save"></i> Salvar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>

        </form>

    </div>

</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_celulas").addClass("treeview active");
    });
</script>

@include('celulaspessoas.script_table')

@endsection