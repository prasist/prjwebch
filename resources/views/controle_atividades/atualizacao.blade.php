@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Controle Atividades') }}

@if ($tipo_operacao=="incluir")
    {{ \Session::put('subtitulo', 'Inclusão') }}
@else
    {{ \Session::put('subtitulo', 'Alteração / Visualização') }}
@endif

{{ \Session::put('route', 'controle_atividades') }}
{{ \Session::put('id_pagina', '58') }}

<div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href={{ url('/' . \Session::get('route')) }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>



    @if ($tipo_operacao=="incluir")
          <form method = 'POST' class="form-horizontal" action = {{ url('/clientes/gravar')}}>
    @else
          <form method = 'POST' class="form-horizontal"  action = {{ url('/' . \Session::get('route') . '/' . $dados[0]->celulas_id . '/update')}}>
    @endif

    {!! csrf_field() !!}

    <div class="box box-default">

          <div class="box-body">

                  <div class="row">

                        <div class="col-xs-9 {{ $errors->has('celulas') ? ' has-error' : '' }}">

                                <label for="celulas" class="control-label">Célula</label>
                                <select id="celulas" placeholder="(Selecionar)" name="celulas" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                <option  value="0"></option>
                                @foreach($celulas as $item)
                                       @if ($tipo_operacao=="incluir")
                                              <option  value="{{$item->id}}">{{$item->nome}}</option>
                                       @else
                                              <option  value="{{$item->id}}" {{ ($dados[0]->celulas_id== $item->id ? 'selected' : '') }}>{{$item->nome}}</option>
                                       @endif
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
                        <p id="reune_sempre"></p>
                  </div>

                  <div class="row">
                        <div class="col-xs-3">
                                <label for="mes" class="control-label">Mês</label>
                                <select id="mes" name="mes" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                    <option  value=""></option>
                                    <option  value="01" {{ (date('m')==1 ? 'selected' : '') }} >Janeiro</option>
                                    <option  value="02" {{ (date('m')==2 ? 'selected' : '') }} >Fevereiro</option>
                                    <option  value="03" {{ (date('m')==3 ? 'selected' : '') }} >Março</option>
                                    <option  value="04" {{ (date('m')==4 ? 'selected' : '') }} >Abril</option>
                                    <option  value="05" {{ (date('m')==5 ? 'selected' : '') }} >Maio</option>
                                    <option  value="06" {{ (date('m')==6 ? 'selected' : '') }} >Junho</option>
                                    <option  value="07" {{ (date('m')==7 ? 'selected' : '') }} >Julho</option>
                                    <option  value="08" {{ (date('m')==8 ? 'selected' : '') }} >Agosto</option>
                                    <option  value="09" {{ (date('m')==9 ? 'selected' : '') }} >Setembro</option>
                                    <option  value="10" {{ (date('m')==10 ? 'selected' : '') }} >Outubro</option>
                                    <option  value="11" {{ (date('m')==11 ? 'selected' : '') }} >Novembro</option>
                                    <option  value="12" {{ (date('m')==12 ? 'selected' : '') }} >Dezembro</option>
                                </select>
                        </div>

                        <div class="col-xs-3">
                            <label for="ano" class="control-label">Ano</label>
                            <input id="ano"  id="ano" name = "mes" type="text" class="form-control" value="{{date('Y')}}">
                        </div>

                        <div class="col-xs-3">
                                <label for="data_encontro" class="control-label">Datas de Encontros</label>
                                <select id="data_encontro" name="data_encontro" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                    <option  value=""></option>
                                    <option  value="1">Teste</option>
                                    <option  value="2">Teste</option>
                                </select>
                         </div>
                   </div>


                  <div class="row">
                     <div class="col-xs-11">
                     <br/>
                        <table id="tab_participantes" class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Participantes</th>
                                <th>Presença</th>
                                <th>Observação</th>
                            </tr>
                        </thead>
                        <tbody>
                          <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                          </tr>
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

  function vai()
  {
       $("[name='presenca']").bootstrapSwitch();
  }

    $(document).ready(function(){

        $("#celulas").change(function()
        {

             var id_celula = $(this).val(); //pegar ID celula
             var urlRoute = "{!! url('/celulaspessoas/participantes/" + id_celula + "') !!}"; //Rota para consulta

                    $('#tab_participantes').dataTable({
                          "bDeferRender": true,
                          "deferRender": true,
                          "pagingType": "full_numbers",
                          'iDisplayLength': 25,
                          "bProcessing": true,
                          "processing": true,
                          "aaSorting": [[ 1, "asc" ]],
                          language:
                          {
                              searchPlaceholder: "Pesquisar...",
                              processing:     "Aguarde...Carregando",
                              paginate: {
                                                first:      "Primeira",
                                                previous:   "Anterior",
                                                next:       "Próxima",
                                                last:       "Última"}
                          },
                          "serverSide": true,
                          "ajax": urlRoute,
                          "columnDefs":
                          [
                             {"targets": [2], "sortable": false}
                          ],
                          "columns": [
                                  { data: "razaosocial" },
                                  {"mRender": function(data, type, full) {

                                            return '<input name="presenca" type="checkbox" class="incluir" data-group-cls="btn-group-sm" value="' + full['pessoas_id'] + '"  data-off-text="Não" data-on-text="Sim" />';

                                    }},
                                    {"mRender": function(data, type, full) {

                                          return '<input  name="obs_membro[' + full['pessoas_id'] + ']" type="text" class="form-control"  value="" />';

                                    }}
                              ],
                   }).after(alert('Selecione agora a Data do Encontro para marcar as presenças')); //datatable

            }); //fim change celulas

          $("#data_encontro").change(function()
          {
                $("[name='presenca']").bootstrapSwitch();
          });

    });

</script>

@endsection