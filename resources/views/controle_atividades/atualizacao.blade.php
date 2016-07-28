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
 </div>

@if ($tipo_operacao=="incluir")
      <form method = 'POST' class="form-horizontal"  action = {{ url('/' . \Session::get('route') . '/gravar')}}>
@else
      <form method = 'POST' class="form-horizontal"  action = {{ url('/' . \Session::get('route') . '/' . $dados[0]->id . '/update')}}>
@endif

{!! csrf_field() !!}

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->

        <div class="col-md-6">

              <!-- INICIO CONTEUDO -->

                <!-- Horizontal Form -->
                <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Selecionar Célula e Data do Encontro</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="form-horizontal">
                    <div class="box-body">

                      <div class="row">
                            <div class="col-xs-12 {{ $errors->has('celulas') ? ' has-error' : '' }}">

                            @if ($tipo_operacao=="editar")
                                  <input type="hidden" name="hidden_id" id="hidden_id" value="{{$dados[0]->id}}">
                            @else
                                  <input type="hidden" name="hidden_id" id="hidden_id" value="">
                            @endif

                            <label for="celulas" class="control-label">Célula</label>
                                    <select id="celulas" placeholder="(Selecionar)" name="celulas" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                    <option  value="0"></option>
                                    @foreach($celulas as $item)
                                           @if ($tipo_operacao=="incluir")
                                                  <option  value="{{$item->id . '|' . $item->nome}}" {{ (old('celulas')== $item->id ? 'selected' : '') }}>{{$item->nome}}</option>
                                           @else
                                                  <option  value="{{$item->id . '|' . $item->nome}}" {{ ($dados[0]->celulas_id== $item->id ? 'selected' : '') }}>{{$item->nome}}</option>
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
                          <div class="col-xs-12">
                                <input id="dia_encontro"  name = "dia_encontro" type="hidden" class="form-control" value="{{old('dia_encontro')}}">
                          </div>
                      </div>
                      <div class="row">

                            <div class="col-xs-4  {{ $errors->has('mes') ? ' has-error' : '' }}">
                                    <label for="mes" class="control-label">Mês</label>
                                    <select id="mes" name="mes" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                        <option  value=""></option>

                                        @if ($tipo_operacao=="incluir")
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
                                        @else
                                             <option  value="01" {{ ($dados[0]->mes==1 ? 'selected' : '') }} >Janeiro</option>
                                             <option  value="02" {{ ($dados[0]->mes==2 ? 'selected' : '') }} >Fevereiro</option>
                                             <option  value="03" {{ ($dados[0]->mes==3 ? 'selected' : '') }} >Março</option>
                                             <option  value="04" {{ ($dados[0]->mes==4 ? 'selected' : '') }} >Abril</option>
                                             <option  value="05" {{ ($dados[0]->mes==5 ? 'selected' : '') }} >Maio</option>
                                             <option  value="06" {{ ($dados[0]->mes==6 ? 'selected' : '') }} >Junho</option>
                                             <option  value="07" {{ ($dados[0]->mes==7 ? 'selected' : '') }} >Julho</option>
                                             <option  value="08" {{ ($dados[0]->mes==8 ? 'selected' : '') }} >Agosto</option>
                                             <option  value="09" {{ ($dados[0]->mes==9 ? 'selected' : '') }} >Setembro</option>
                                             <option  value="10" {{ ($dados[0]->mes==10 ? 'selected' : '') }} >Outubro</option>
                                             <option  value="11" {{ ($dados[0]->mes==11 ? 'selected' : '') }} >Novembro</option>
                                             <option  value="12" {{ ($dados[0]->mes==12 ? 'selected' : '') }} >Dezembro</option>
                                        @endif

                                    </select>

                                    <!-- se houver erros na validacao do form request -->
                                    @if ($errors->has('mes'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mes') }}</strong>
                                    </span>
                                    @endif
                            </div>


                            <div class="col-xs-4 {{ $errors->has('ano') ? ' has-error' : '' }}">
                                  <label for="ano" class="control-label">Ano</label>
                                  @if ($tipo_operacao=="incluir")
                                        <input id="ano"  name = "ano" type="text" class="form-control" value="{{date('Y')}}">
                                  @else
                                        <input id="ano"  name = "ano" type="text" class="form-control" value="{{$dados[0]->ano}}">
                                  @endif

                                    <!-- se houver erros na validacao do form request -->
                                    @if ($errors->has('ano'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ano') }}</strong>
                                    </span>
                                    @endif

                            </div>

                            <div class="col-xs-4 {{ $errors->has('data_encontro') ? ' has-error' : '' }}">
                                <label for="data_encontro" class="control-label">Data do Encontro</label>
                                <!--<select id="data_encontro" name="data_encontro" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">-->
                                <select id="data_encontro" name="data_encontro" class="form-control">
                                      @if ($tipo_operacao=="incluir")
                                          <option value=""></option>
                                      @else
                                          @foreach($dates_of_meeting as $item)
                                                  <option value='{{$dados[0]->dia==substr($item,0,2) ? $dados[0]->dia : "" }}' {{$dados[0]->dia==substr($item,0,2) ? "selected" : "" }}>{{$item}}</option>
                                          @endforeach
                                      @endif
                                </select>

                                <!-- se houver erros na validacao do form request -->
                                @if ($errors->has('data_encontro'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('data_encontro') }}</strong>
                                </span>
                                @endif
                          </div>


                      </div>
                      <div class="row">
                            <div class="col-xs-5">
                                      <label for="ckEstruturas" class="control-label">Encontro Encerrado ?</label>
                                      <div class="input-group">
                                             <div class="input-group-addon">
                                                  <input  id= "ckFinalizar" name="ckFinalizar" data-group-cls="btn-group-sm" type="checkbox" class="ckFinalizar" {{ ($tipo_operacao=="incluir" ? "" : ($dados[0]->encontro_encerrado=="S" ? "checked" : "") )  }}/>
                                             </div>
                                      </div>
                            </div>

                      </div>


                 </div>
                    <!-- /.box-body -->
                    <!-- /.box-footer -->
                  </div>
                </div>
                <!-- /.box -->
              <!-- FIM CONTEUDO -->


        </div>

        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">


               <!-- INICIO CONTEUDO -->
                <!-- Horizontal Form -->
            <div class="box box-info" id="box_mais" style="display: none">
                  <div class="box-header with-border">
                    <h3 class="box-title">Encerramento Encontro</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="form-horizontal">
                    <div class="box-body">
                      <div class="row">

                                <div class="col-xs-4">
                                    <label for="hora_inicio" class="control-label">Horário Inicio</label>
                                    <input type="text" name="hora_inicio" id="hora_inicio"  data-inputmask='"mask": "99:99"' data-mask  class="form-control input-small" value='{{ ($tipo_operacao=="incluir" ? "" : $dados[0]->hora_inicio) }}'>
                                </div>

                                <div class="col-xs-4">
                                    <label for="hora_fim" class="control-label">Horário Término</label>
                                    <input type="text" name="hora_fim" id="hora_fim"  data-inputmask='"mask": "99:99"' data-mask  class="form-control input-small" value='{{ ($tipo_operacao=="incluir" ? "" : $dados[0]->hora_fim) }}'>
                                </div>

                                <div class="col-xs-4">
                                   <label for="valor_oferta" class="control-label">Valor Oferta</label>
                                   <input type="text" name="valor_oferta" id="valor_oferta"  class="form-control" value='{{ ($tipo_operacao=="incluir" ? "" : $dados[0]->valor_oferta) }}'>
                                </div>

                      </div>

                      <div class="row">
                            <div class="col-xs-12">
                                  <label for="observacao" class="control-label">Observações</label>
                                  <textarea name="observacao" class="form-control" rows="2" placeholder="Digite o texto..." >
                                  {{ ($tipo_operacao=="incluir" ? "" : $dados[0]->obs) }}
                                  </textarea>
                            </div>
                      </div>

                 </div>
                <!-- /.box-body -->
                <!-- /.box-footer -->
              </div>
            </div>
            <!-- /.box -->
            <!-- FIM CONTEUDO -->


        </div>

       <div class="col-md-12" id="box_participantes" style="display: none">

          <div class="box box-default">

                <div class="box-body">


                        <div class="row">
                              <p id="reune_sempre"></p>
                        </div>

                        <div class="row">
                           <div class="col-xs-12">
                           <br/>

                                 <table id="tab_participantes" class="table table-responsive table-hover">
                                  <thead>
                                      <tr>
                                          <th >ID</th>
                                          <th >Participantes</th>
                                          <th >Presença</th>
                                          <th >Observação</th>
                                      </tr>
                                  </thead>
                                  <tbody>

                                    <tr>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                        <td ></td>
                                    </tr>

                                    @if ($tipo_operacao=="editar")
                                        @foreach ($participantes as $item)
                                        <tr>
                                                  <td>{{$item->id}}</td>
                                                  <td>{{$item->razaosocial}}</td>
                                                  <td>
                                                      <input name="presenca[]" id="presenca[]" type="checkbox" class="obs" data-group-cls="btn-group-sm" value="{{$item->id}}"  data-off-text="Não" data-on-text="Sim" {{ ($item->presenca_simples=="S" ? "checked" : "") }} />
                                                  </td>
                                                  <td>
                                                            <input  name="id_obs_membro[]" id="id_obs_membro[]" type="hidden"  value="{{$item->id}}" />
                                                            <input  name="obs_membro[]" id="obs_membro[]" type="text" class="form-control" value="{{$item->observacao}}" />
                                                  </td>
                                         </tr>
                                         @endforeach
                                    @endif

                                  </tbody>
                                 </table>

                             </div>
                        </div>

                  </div><!-- fim box-body"-->
              </div><!-- box box-primary -->


       </div>


       <!-- ini-->
       <div class="col-md-12"  id="box_visitantes" style="display: none">

            <!-- Horizontal Form -->
                <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Visitantes</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="form-horizontal">
                    <div class="box-body">

                        <div class="row">
                                <div class="col-xs-12">
                                        <table id="tab_visitantes" class="table table-responsive">
                                          <thead>
                                              <tr>
                                                  <th>Nome</th>
                                                  <th>Fone</th>
                                                  <th>Email</th>
                                                  <th></th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                                <td><input name="pergunta" type="text" class="form-control" value=""  /></td>
                                                <td><input name="pergunta" type="text" class="form-control" value=""  /></td>
                                                <td><input name="pergunta" type="text" class="form-control" value=""  /></td>
                                                <td><a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default"><b> + </b></a></td>
                                            </tr>
                                          </tbody>
                                        </table>
                               </div>


                       </div>


                   </div>

                 </div>

               </div>

                <!-- /.box -->
                <!-- FIM CONTEUDO -->

        </div>

       <div class="col-md-12"  id="box_questions" style="display: none">
             <!-- Horizontal Form -->
                <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Questionários</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="form-horizontal">
                    <div class="box-body">

                        <div class="form-group">
                                <label  for="pergunta" class="col-sm-6 control-label">Aglum alvo de oração alcançado  ? </label>

                                <div class="col-xs-4">
                                        <input name="pergunta" type="checkbox" class="perguntas" data-group-cls="btn-group-sm" value=""  data-off-text="Não" data-on-text="Sim" />
                               </div>
                       </div>
                       <div class="form-group">
                                <label  for="pergunta" class="col-sm-6 control-label">Alguma desistência de estar na célula hoje  ? </label>

                                <div class="col-xs-4">
                                        <input name="pergunta" type="checkbox" class="perguntas" data-group-cls="btn-group-sm" value=""  data-off-text="Não" data-on-text="Sim" />
                               </div>
                       </div>
                       <div class="form-group">
                                <label  for="pergunta" class="col-sm-6 control-label">Algum testemunho hoje  ? </label>

                                <div class="col-xs-4">
                                        <input name="pergunta" type="checkbox" class="perguntas" data-group-cls="btn-group-sm" value=""  data-off-text="Não" data-on-text="Sim" />
                               </div>
                       </div>
                       <div class="form-group">
                                <label  for="pergunta" class="col-sm-6 control-label">Qual sua cor favorita : </label>

                                <div class="col-xs-4">
                                        <input name="pergunta" type="text" class="form-control" value=""  />
                               </div>
                       </div>

                   </div>

                 </div>

              </div>

                <!-- /.box -->
                <!-- FIM CONTEUDO -->
       </div>

      </div>
      <!-- /.row -->

             <div class="box-footer">
                  <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-save"></i> Salvar</button>
                  <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
              </div>


    </section>
    <!-- /.content -->
 </form>

</div>


<script type="text/javascript">


    $(document).ready(function(){

          //editing data
          if  ($('#hidden_id').val()!="") {

              $("[class='obs']").bootstrapSwitch();
              exibir_divs(true);

              //initialize datatable
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

                          "columnDefs":
                          [
                             {"targets": [3], "sortable": false},
                             {"targets": [0], "visible": false}
                          ]
                   });

          } else { //create, nothing to do...
                exibir_divs(false);
          }


          function exibir_divs(bool_opcao)
          {

                  if (bool_opcao==true) {
                      $('#box_participantes').show();
                      $('#box_visitantes').show();
                      $('#box_questions').show();
                      $('#box_resumo').show();
                      $('#box_mais').show();
                  } else {
                        //hide divs
                      $('#box_participantes').hide();
                      $('#box_visitantes').hide();
                      $('#box_questions').hide();
                      $('#box_resumo').hide();
                      $('#box_mais').hide();
                 }
          }


          function vai()
          {
               $("[name='presenca']").bootstrapSwitch();
          }

          function apos()
          {
                //alert('Selecione agora a Data do Encontro para marcar as presenças');
                //Buscar informações da Célula
                if ($('#celulas').val()!="") //se foi preenchido o campo
                {

                        var conteudo_celulas = $('#celulas').val().split('|');
                        var strValor = conteudo_celulas[0];
                        var urlGetUser = '{!! url("/celulas/buscar/' +  strValor +  '/' + $('#mes').val()+ '/' + $('#ano').val() + '") !!}';

                        $.ajax(
                        {
                             url: urlGetUser,
                             success: function (response) {

                                 if (response!="")
                                 {
                                     $("#dia_encontro").val(response); //Limpa campo

                                          var var_day = $("#data_encontro").val();
                                          var var_year = $("#ano").val();
                                          var var_month = $("#mes").val();
                                          var var_cell_input = $('#celulas').val().split('|');
                                          var var_cell_id = var_cell_input[0];
                                          var urlGetUser = '{!! url("/celulas/buscar_datas/' +  var_cell_id + '/' + var_month + '/' + var_year + '") !!}';

                                          $.getJSON(urlGetUser, function( data, status )
                                          {

                                              if (status==="success") //if found
                                              {
                                                   html ='<option value=""></option>';

                                                   $.each(data, function(index, element)
                                                   {
                                                       html +='<option value="' + element.substr(0,2) + '">' + element + '</option>';
                                                   });

                                                  var $stations = $("#data_encontro"); //Instancia o objeto combo nivel2
                                                  $stations.empty();
                                                  $stations.append(html);
                                                  $("#data_encontro").trigger("change"); //trigger the change event for load fields from database

                                              }

                                          });

                                 }

                             }
                        });


                }

          }


        $('.ckFinalizar').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
        });


        $('#ckFinalizar').change(function()
        {
              if ($(this).prop('checked'))
              {
                  $("#data_encontro").trigger("change");
              }
              else
              {
                  exibir_divs(false);
              }

        });



        $("[class='perguntas']").bootstrapSwitch(); //Habilita check box com SIM E NAO

        //ao celecionar a celula, preenche com os participantes
        $("#celulas").change(function()
        {

             var conteudo_celulas = $(this).val().split('|');
             var id_celula = conteudo_celulas[0];
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
                             {"targets": [3], "sortable": false},
                             {"targets": [0], "visible": false}
                          ],
                          "columns": [
                                  { data: "id" },
                                  { data: "razaosocial" },
                                  {"mRender": function(data, type, full) {

                                            return '<input name="presenca[]" id="presenca[]" type="checkbox" class="obs" data-group-cls="btn-group-sm" value="' + full['id'] + '"  data-off-text="Não" data-on-text="Sim" />';

                                    }},
                                    {"mRender": function(data, type, full) {

                                          var sHtml = '<input  name="id_obs_membro[]" id="id_obs_membro[]" type="hidden" class="form-control obs"  value="' + full['id'] + '" /><input  name="obs_membro[]" id="obs_membro[]" type="text" class="form-control obs"  value="" />';
                                          return sHtml;

                                    }}

                              ],
                   }).after(apos()); //Apos carregar participantes, dispara function

            }); //fim change celulas


          //------------- DATA ENCONTRO CHANGE EVENT-----------------------
          //Quando clicar em uma data no combo
          $("#data_encontro").change(function()
          {
                if ($('#ckFinalizar').prop('checked')) //Exibe divs se foi selecionado encerramento
                {
                    $("[class='obs']").bootstrapSwitch();
                    exibir_divs(true);
               }
               else //Esconde divs
               {
                    exibir_divs(false);
               }

                //Search for existent data in database
                var var_day = $("#data_encontro").val();
                var var_cell_input = $('#celulas').val().split('|');
                var var_cell_id = var_cell_input[0];
                var var_year = $("#ano").val();
                var var_month = $("#mes").val();
                var urlGetUser = '{!! url("/controle_atividades/buscar/' +  var_cell_id +  '/' + var_day + '/' + var_month + '/' + var_year + '") !!}';

                console.log('change data encontro ' + urlGetUser);
                //if selected a date
                if (var_day!="")
                {

                    $.getJSON(urlGetUser, function( data, status ) //search by : id, dia encontro, mes, ano
                    {

                        if (data!="") //found
                        {
                            //reopen page with ID found
                            var urlGetUser = '{!! url("/controle_atividades/' +  data[0].id +  '/edit") !!}';
                            window.location=urlGetUser; //redirect to route
                        }

                    });

                }


          });
          //-------------FIM DATA ENCONTRO CHANGE EVENT-----------------------


    });

</script>

@endsection