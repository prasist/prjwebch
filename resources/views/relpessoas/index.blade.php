@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Relatório de Pessoas') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'relpessoas') }}
{{ \Session::put('id_pagina', '47') }}

<div class = 'row'>

 <div class="col-md-12">

  <form method = 'POST'  class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/pesquisar')}}>

  {!! csrf_field() !!}

    <div class="box box-default">

          <div class="box-body">

            <div class="row">
                <div class="col-md-12">

                     <!-- Custom Tabs -->
                      <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#tab_1" data-toggle="tab">Fitros Básicos</a></li>
                          <li><a href="#tab_2" data-toggle="tab">Por Períodos</a></li>
                          <li><a href="#tab_3" data-toggle="tab">Estrutura de Células</a></li>
                        </ul>
                        <div class="tab-content">

                          <div class="tab-pane active" id="tab_1">

                                <div  class="row">
                                              <div class="col-md-12">

                                                    <div class="box box-default">

                                                          <div class="box-body"><!-- box-body-->

                                                                <div class="row"><!-- row entrada-->

                                                                      <div class="col-xs-3">
                                                                            <label for="mes" class="control-label">Mês Aniversário</label>
                                                                            <select id="mes" name="mes" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                                <option  value=""></option>
                                                                                <option  value="01">Janeiro</option>
                                                                                <option  value="02">Fevereiro</option>
                                                                                <option  value="03">Março</option>
                                                                                <option  value="04">Abril</option>
                                                                                <option  value="05">Maio</option>
                                                                                <option  value="06">Junho</option>
                                                                                <option  value="07">Julho</option>
                                                                                <option  value="08">Agosto</option>
                                                                                <option  value="09">Setembro</option>
                                                                                <option  value="10">Outubro</option>
                                                                                <option  value="11">Novembro</option>
                                                                                <option  value="12">Dezembro</option>
                                                                            </select>
                                                                    </div>

                                                                    <div class="col-xs-3">
                                                                            <label for="status" class="control-label">Status Cadastro</label>
                                                                            <select id="status" name="status" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                                <option  value="">Ambos</option>
                                                                                <option  value="S">Ativo</option>
                                                                                <option  value="N">Inativo</option>
                                                                            </select>
                                                                    </div>

                                                                    <div class="col-xs-3">

                                                                          <label for="status_id" class="control-label">Status</label>

                                                                          <select id="status_id" placeholder="(Selecionar)" name="status_id" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>

                                                                          @foreach($status as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>

                                                                    </div><!-- col-xs-5-->

                                                                    <div class="col-xs-3">

                                                                        <label for="situacoes" class="control-label">Situação</label>

                                                                          <select id="situacoes" placeholder="(Selecionar)" name="situacoes" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>

                                                                          @foreach($situacoes as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                    </div><!-- col-xs-5-->


                                                                 </div><!-- end row -->

                                                                 <div class="row">
                                                                      <div class="col-xs-3">

                                                                          <label for="tipos" class="control-label">Tipo Pessoa</label>

                                                                          <select id="tipos" placeholder="(Selecionar)" name="tipos" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>

                                                                          @foreach($tipos as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                      </div><!-- col-xs-5-->

                                                                      <div class="col-xs-3">
                                                                          <label for="estadoscivis" class="control-label">Estado Civil</label>

                                                                          <select id="estadoscivis" placeholder="(Selecionar)" name="estadoscivis" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>

                                                                          @foreach($estadoscivis as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                      </div><!-- col-xs-5-->

                                                                      <div class="col-xs-3">
                                                                          <label for="sexo" class="control-label">Sexo</label>
                                                                            <select id="sexo" name="sexo" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                                <option  value="">Ambos</option>
                                                                                <option  value="M">Masculino</option>
                                                                                <option  value="F">Feminino</option>
                                                                            </select>
                                                                      </div>

                                                                      <div class="col-xs-3">
                                                                            <label for="saida" class="control-label">Tipo de Saída</label>
                                                                            <select id="saida" name="saida" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                                 <option  value="I">Relatório</option>
                                                                                 <option  value="E" >Gerar Lista de Emails</option>
                                                                            </select>
                                                                    </div>

                                                                 </div> <!-- end row -->

                                                                 <div class="row">
                                                                      <div class="col-xs-6">
                                                                          <label for="grupo" class="control-label">Grupo</label>

                                                                          <select id="grupo" placeholder="(Selecionar)" name="grupo" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>
                                                                          @foreach($grupos as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                      </div><!-- col-xs-5-->

                                                                      <div class="col-xs-3">
                                                                            <br/>
                                                                            <input  id= "ckEstruturas" name="ckEstruturas" type="checkbox" class="minimal" />  Listar Estruturas Células
                                                                      </div>
                                                                </div> <!-- end row -->

                                                           </div> <!-- enb box-body-->
                                                       </div> <!-- end box box-default -->
                                                   </div>
                                </div><!-- end row -->

                          </div>

                          <!-- /.tab-pane -->
                          <div class="tab-pane" id="tab_2">

                                <div  class="row">
                                              <div class="col-md-12">

                                                    <div class="box box-default">

                                                          <div class="box-body"><!-- box-body-->

                                                                <div  class="row">
                                                                        <div class="col-xs-3">
                                                                                <label  for="data_entrada" class="control-label">Data Entrada</label>
                                                                                <div class="input-group">
                                                                                       <div class="input-group-addon">
                                                                                        <i class="fa fa-calendar"></i>
                                                                                        </div>
                                                                                        <input id ="data_entrada" name = "data_entrada" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                                </div>
                                                                       </div>

                                                                       <div class="col-xs-3">
                                                                                <label  for="data_entrada_ate" class="control-label">Até</label>
                                                                                <div class="input-group">
                                                                                       <div class="input-group-addon">
                                                                                        <i class="fa fa-calendar"></i>
                                                                                        </div>
                                                                                        <input id ="data_entrada_ate" name = "data_entrada_ate" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                                </div>
                                                                       </div>

                                                                      <div class="col-xs-4">
                                                                               <label for="motivoentrada" class="control-label">Motivo Entrada</label>
                                                                                <select id="motivoentrada" placeholder="(Selecionar)" name="motivoentrada" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                                <option  value=""></option>
                                                                                @foreach($motivos as $item)
                                                                                       <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                                @endforeach
                                                                                </select>
                                                                      </div><!-- col-xs-5-->


                                                                </div><!-- end row -->


                                                                <div class="row"><!-- row saida-->

                                                                     <div class="col-xs-3">
                                                                              <label  for="data_saida" class="control-label">Data Saída</label>
                                                                              <div class="input-group">
                                                                                     <div class="input-group-addon">
                                                                                      <i class="fa fa-calendar"></i>
                                                                                      </div>
                                                                                      <input id ="data_saida" name = "data_saida" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                              </div>
                                                                     </div>

                                                                     <div class="col-xs-3">
                                                                              <label  for="data_saida_ate" class="control-label">Até</label>

                                                                              <div class="input-group">
                                                                                     <div class="input-group-addon">
                                                                                      <i class="fa fa-calendar"></i>
                                                                                      </div>
                                                                                      <input id ="data_saida_ate" name = "data_saida_ate" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                              </div>

                                                                     </div>

                                                                      <div class="col-xs-4">
                                                                                <label for="motivosaida" class="control-label">Motivo Saída</label>

                                                                                <select id="motivosaida" placeholder="(Selecionar)" name="motivosaida" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                                <option  value=""></option>

                                                                                @foreach($motivos as $item)
                                                                                       <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                                @endforeach
                                                                                </select>
                                                                      </div><!-- col-xs-5-->

                                                                 </div><!-- end row -->

                                                                 <div class="row"><!-- row saida-->

                                                                      <div class="col-xs-3">
                                                                              <label  for="data_batismo" class="control-label">Data Batismo</label>

                                                                              <div class="input-group">
                                                                                     <div class="input-group-addon">
                                                                                      <i class="fa fa-calendar"></i>
                                                                                      </div>

                                                                                      <input id ="data_batismo" name = "data_batismo" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                              </div>

                                                                     </div>

                                                                     <div class="col-xs-3">
                                                                              <label  for="data_batismo_ate" class="control-label">Até</label>

                                                                              <div class="input-group">
                                                                                     <div class="input-group-addon">
                                                                                      <i class="fa fa-calendar"></i>
                                                                                      </div>

                                                                                      <input id ="data_batismo_ate" name = "data_batismo_ate" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                              </div>

                                                                     </div>

                                                                 </div><!-- end row -->

                                                            </div>

                                                    </div>
                                              </div>
                                </div>

                          </div>

                          <!-- /.tab-pane -->
                          <div class="tab-pane" id="tab_3">

                                    <div class="box box-default">
                                        <div class="box-header with-border">
                                          <h3 class="box-title">Estrutura de Células</h3>
                                        </div>

                                          <div class="box-body">

                                          <!-- NIVEL 1-->
                                            <div class="form-group">
                                                <label for="nivel1_up" class="col-sm-2 control-label">{{Session::get('nivel1')}}</label>
                                                <div class="col-sm-10">
                                                      <select id="nivel1_up" placeholder="(Selecionar)" name="nivel1_up" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                      <option  value="0"></option>
                                                      @foreach($nivel1 as $item)
                                                             <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                      @endforeach
                                                      </select>
                                                </div>
                                            </div>


                                            <!-- NIVEL 2 -->
                                            <div class="form-group">
                                                <label for="nivel2_up" class="col-sm-2 control-label">{{Session::get('nivel2')}}</label>
                                                <div class="col-sm-10">
                                                        <select id="nivel2_up" placeholder="(Selecionar)" name="nivel2_up" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                        <option  value="0"></option>
                                                         @foreach($nivel2 as $item)
                                                             <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                         @endforeach
                                                        </select>
                                                </div>
                                            </div>

                                            <!-- NIVEL 3-->
                                            <div class="form-group">
                                              <label for="nivel3_up" class="col-sm-2 control-label">{{Session::get('nivel3')}}</label>
                                              <div class="col-sm-10">
                                                    <select id="nivel3_up" placeholder="(Selecionar)" name="nivel3_up" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                    <option  value="0"></option>
                                                      @foreach($nivel3 as $item)
                                                             <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                      @endforeach
                                                    </select>
                                              </div>
                                            </div>

                                            <!-- NIVEL 4-->
                                            <div class="form-group">
                                              <label for="nivel4_up" class="col-sm-2 control-label">{{Session::get('nivel4')}}</label>

                                              <div class="col-sm-10">
                                                    <select id="nivel4_up" placeholder="(Selecionar)" name="nivel4_up" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                    <option  value="0"></option>
                                                      @foreach($nivel4 as $item)
                                                             <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                      @endforeach
                                                    </select>
                                              </div>
                                            </div>

                                            <!-- NIVEL 5-->
                                            <div class="form-group">
                                              <label for="nivel5_up" class="col-sm-2 control-label">{!!Session::get('nivel5') !!}</label>
                                              <div class="col-sm-10">
                                                      <select id="nivel5_up" placeholder="(Selecionar)" name="nivel5_up" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                      <option  value="0"></option>
                                                      @foreach($nivel5 as $item)
                                                             <option  value="{{$item->id . '|' . $item->nome}}" >{{$item->nome}}</option>
                                                      @endforeach
                                                      </select>
                                              </div>
                                            </div>

                                         </div>

                                     </div>
                          </div>
                          <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                     </div>
                      <!-- nav-tabs-custom -->

                </div><!-- /.col -->
            </div><!-- /.row -->

        <div class="overlay modal" style="display: none">
            <i class="fa fa-refresh fa-spin"></i>
        </div>

         </div><!-- fim box-body"-->


     </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' onclick="myApp.showPleaseWait();">Pesquisar</button>
        </div>

        </form>

    </div>

</div>

<script type="text/javascript">

      var myApp;
      myApp = myApp || (function () {

          return {
              showPleaseWait: function() {
                  $(".overlay").show();
              }
          };
      })();

</script>
@include('configuracoes.script_estruturas')


@endsection