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
      <form method = 'POST' class="form-horizontal"  action = {{ url('/' . \Session::get('route') . '/' . $dados[0]->celulas_id . '/update')}}>
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

                                    <!-- se houver erros na validacao do form request -->
                                    @if ($errors->has('mes'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mes') }}</strong>
                                    </span>
                                    @endif
                            </div>


                            <div class="col-xs-4 {{ $errors->has('ano') ? ' has-error' : '' }}">
                                  <label for="ano" class="control-label">Ano</label>
                                  <input id="ano"  name = "ano" type="text" class="form-control" value="{{date('Y')}}">

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
                                      <option value=""></option>
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
                                                  <input  id= "ckFinalizar" name="ckFinalizar" data-group-cls="btn-group-sm" type="checkbox" class="ckFinalizar"/>
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
                                    <input type="text" name="hora_inicio" id="hora_inicio"  data-inputmask='"mask": "99:99"' data-mask  class="form-control input-small">
                                </div>

                                <div class="col-xs-4">
                                    <label for="hora_fim" class="control-label">Horário Término</label>
                                    <input type="text" name="hora_fim" id="hora_fim"  data-inputmask='"mask": "99:99"' data-mask  class="form-control input-small">
                                </div>

                                <div class="col-xs-4">
                                   <label for="valor_oferta" class="control-label">Valor Oferta</label>
                                   <input type="text" name="valor_oferta" id="valor_oferta"  class="form-control">
                                </div>

                      </div>

                      <div class="row">
                            <div class="col-xs-12">
                                  <label for="observacao" class="control-label">Observações</label>
                                  <textarea name="observacao" class="form-control" rows="2" placeholder="Digite o texto..." value=""></textarea>

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

                                 <table id="tab_participantes" class="table table-bordered table-hover">
                                  <thead>
                                      <tr>
                                          <th class="col-xs-4">ID</th>
                                          <th class="col-xs-4">Participantes</th>
                                          <th class="col-xs-2">Presença</th>
                                          <th class="col-xs-6">Observação</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                        <td class="col-xs-4"></td>
                                        <td class="col-xs-4"></td>
                                        <td class="col-xs-2"></td>
                                        <td class="col-xs-6"></td>
                                    </tr>
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
                        var strValor = conteudo_celulas[0]; //Pega conteudo campo cpf
                        var urlGetUser = '{!! url("/celulas/buscar/' +  strValor +  '") !!}'; //Route funcoes = FuncoesController@index passando cpf como parametro

                        $.ajax(
                        {
                            url: urlGetUser,
                             success: function (response) { //Encontrando a rota e a funcao retornando dados, exibe alerta

                                 if (response!="") //Só exibe mensagem se encontrar CPF para outra pessoa
                                 {
                                     $("#dia_encontro").val(response); //Limpa campo


                                        /*-------------------------------CARREGARÁ AS DATAS CONFORME DIA DO ENCONTRO-------------------------------*/
                                        if ($('#dia_encontro').val()!="")
                                        {
                                                var dia_encontro = $('#dia_encontro').val(); //Dia do encontro da célula
                                                var firstDayOfMonth = new Date( $('#ano').val(), ($('#mes').val()-1), 1 ); //Pega primeira ocorrencia do dia do encontro no mes informado
                                                var d = firstDayOfMonth,
                                                    month = d.getMonth(),
                                                    mondays = [];

                                                d.setDate(dia_encontro);

                                                // Get the first Monday in the month
                                                while (d.getDay() !== parseInt(dia_encontro)) {
                                                    d.setDate(d.getDate() + 1);
                                                }

                                                html ='<option value=""></option>';

                                                // Get all the other Mondays in the month
                                                while (d.getMonth() === month) {
                                                    //mondays.push(new Date(d.getTime()));
                                                    var nova_data = new Date(d.getTime());
                                                    html +='<option value="' + nova_data.getDate() + '">' + (nova_data.getDate() + "/" + nova_data.getMonth() + "/" + nova_data.getFullYear()) + '</option>';
                                                    d.setDate(d.getDate() + 7);
                                                }

                                                var $stations = $("#data_encontro"); //Instancia o objeto combo nivel2
                                                $stations.empty();
                                                $stations.append(html);
                                                $("#data_encontro").trigger("change"); //trigger the change event for load fields from database
                                        }
                                        /*-------------------------------FIM  DATAS CONFORME DIA DO ENCONTRO-------------------------------*/


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
                    $('#box_participantes').hide();
                    $('#box_visitantes').hide();
                    $('#box_questions').hide();
                    $('#box_resumo').hide();
                    $('#box_mais').hide();
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


          //Quando clicar em uma data no combo
          $("#data_encontro").change(function()
          {
                if ($('#ckFinalizar').prop('checked')) //Exibe divs se foi selecionado encerramento
                {
                    $("[class='obs']").bootstrapSwitch();
                    $('#box_participantes').show();
                    $('#box_visitantes').show();
                    $('#box_questions').show();
                    $('#box_resumo').show();
                    $('#box_mais').show();
               }
               else //Esconde divs
               {
                    $('#box_participantes').hide();
                    $('#box_visitantes').hide();
                    $('#box_questions').hide();
                    $('#box_resumo').hide();
                    $('#box_mais').hide();
               }


                var var_day = $("#data_encontro").val();
                var var_cell_input = $('#celulas').val().split('|');
                var var_cell_id = var_cell_input[0];
                var var_year = $("#ano").val();
                var var_month = $("#mes").val();
                var urlGetUser = '{!! url("/controle_atividades/buscar/' +  var_cell_id +  '/' + var_day + '/' + var_month + '/' + var_year + '") !!}';


                //if day isset, load json data from table (controle_atividades)
                if (var_day!="")
                {

                    $.getJSON(urlGetUser, function( data )
                    {

                        if (data) //if found
                        {
                            $("[class='obs']").bootstrapSwitch();
                            $('#box_participantes').show();
                            $('#box_visitantes').show();
                            $('#box_questions').show();
                            $('#box_resumo').show();
                            $('#box_mais').show();

                            //Load fields
                            $('#hora_inicio').val(data[0].hora_inicio);
                            $('#hora_fim').val(data[0].hora_fim);
                            $('#observacao').val(data[0].obs);
                            $('#valor_oferta').val(data[0].valor_oferta);

                        }

                    });

                }


          });


    });

</script>

@endsection