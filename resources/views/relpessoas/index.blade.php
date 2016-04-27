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
                      <li class="active"><a href="#tab_1" data-toggle="tab">Filtros Básicos</a></li>
                      <li><a href="#tab_2" data-toggle="tab">Filtrar Estrutura de Células</a></li>
                    </ul>

                    <div class="tab-content">
                      <div class="tab-pane active" id="tab_1">

                              <div  class="row">
                                        <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-body"><!-- box-body-->

                                                          <div class="row"><!-- row entrada-->

                                                                <div class="col-xs-4">
                                                                      <label for="mes" class="control-label">Mês Aniversário</label>
                                                                      <select id="mes" name="status" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>
                                                                          <option  value="1">Janeiro</option>
                                                                          <option  value="2">Fevereiro</option>
                                                                          <option  value="3">Março</option>
                                                                          <option  value="4">Abril</option>
                                                                          <option  value="5">Maio</option>
                                                                          <option  value="6">Junho</option>
                                                                          <option  value="7">Julho</option>
                                                                          <option  value="8">Agosto</option>
                                                                          <option  value="9">Setembro</option>
                                                                          <option  value="10">Outubro</option>
                                                                          <option  value="11">Novembro</option>
                                                                          <option  value="12">Dezembro</option>
                                                                      </select>
                                                              </div>

                                                              <div class="col-xs-4">
                                                                      <label for="status" class="control-label">Status</label>
                                                                      <select id="status" name="status" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value="A">Ambos</option>
                                                                          <option  value="S">Ativo</option>
                                                                          <option  value="N">Inativo</option>
                                                                      </select>
                                                              </div>

                                                              <div class="col-xs-4">
                                                                  @include('carregar_combos_multiple', array('dados'=>$situacoes, 'titulo' =>'Situação', 'id_combo'=>'situacoes[]', 'complemento'=>'multiple="multiple"', 'comparar'=>''))
                                                              </div><!-- col-xs-5-->

                                                           </div><!-- end row -->

                                                           <div class="row">
                                                                <div class="col-xs-4">
                                                                    @include('carregar_combos_multiple', array('dados'=>$tipos, 'titulo' =>'Tipos Pessoas', 'id_combo'=>'tipos[]', 'complemento'=>'multiple="multiple"', 'comparar'=>''))
                                                                </div><!-- col-xs-5-->

                                                                <div class="col-xs-4">
                                                                    @include('carregar_combos_multiple', array('dados'=>$estadoscivis, 'titulo' =>'Estados Civis', 'id_combo'=>'estadoscivis[]', 'complemento'=>'multiple="multiple"', 'comparar'=>''))
                                                                </div><!-- col-xs-5-->

                                                                <div class="col-xs-4">
                                                                    <label for="status" class="control-label">Sexo</label>
                                                                      <select id="status" name="status" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value="A">Ambos</option>
                                                                          <option  value="M">Masculino</option>
                                                                          <option  value="F">Feminino</option>
                                                                      </select>
                                                                </div>

                                                           </div>

                                                     </div>
                                                 </div>
                                             </div>
                              </div>


                              <div  class="row">
                                  <div class="col-md-12">

                                        <div class="box box-default">

                                              <div class="box-header">
                                                      <h3 class="box-title">Filtros por Datas</h3>
                                              </div>

                                              <div class="box-body"><!-- box-body-->

                                                    <div class="row"><!-- row entrada-->

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
                                                                  <label  for="data_entrada_fim" class="control-label">Até</label>

                                                                  <div class="input-group">
                                                                         <div class="input-group-addon">
                                                                          <i class="fa fa-calendar"></i>
                                                                          </div>

                                                                          <input id ="data_entrada_fim" name = "data_entrada_fim" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                  </div>

                                                         </div>

                                                          <div class="col-xs-4">
                                                                  @include('carregar_combos', array('dados'=>$motivos, 'titulo' =>'Motivo Entrada', 'id_combo'=>'motivo_entrada', 'complemento'=>'', 'comparar'=>''))
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
                                                                  @include('carregar_combos', array('dados'=>$motivos, 'titulo' =>'Motivo Saída', 'id_combo'=>'motivosaida', 'complemento'=>'', 'comparar'=>''))
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

                      <div class="tab-pane" id="tab_2">
                            <!-- Horizontal Form -->
                             <div class="box box-default">
                                  <div class="box-header with-border">
                                    <h3 class="box-title">Estrutura de Células</h3>
                                  </div>

                                    <div class="box-body">


                                      <div class="form-group">
                                        <label for="nivel5" class="col-sm-2 control-label">{!!Session::get('nivel5') !!}</label>
                                        <div class="col-sm-10">
                                                <select id="nivel5" placeholder="(Selecionar)" name="nivel5" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                <option  value=""></option>
                                                @foreach($nivel5 as $item)
                                                       <option  value="{{$item->id}}" >{{$item->nome}}</option>
                                                @endforeach
                                                </select>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label for="nivel4" class="col-sm-2 control-label">{{Session::get('nivel4')}}</label>

                                        <div class="col-sm-10">
                                              <select id="nivel4" placeholder="(Selecionar)" name="nivel4" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                              <option  value=""></option>
                                              </select>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                        <label for="nivel3" class="col-sm-2 control-label">{{Session::get('nivel3')}}</label>
                                        <div class="col-sm-10">
                                              <select id="nivel3" placeholder="(Selecionar)" name="nivel3" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                              <option  value=""></option>
                                              </select>
                                        </div>
                                      </div>

                                      <div class="form-group">
                                          <label for="nivel2" class="col-sm-2 control-label">{{Session::get('nivel2')}}</label>
                                          <div class="col-sm-10">
                                                  <select id="nivel2" placeholder="(Selecionar)" name="nivel2" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                  <option  value=""></option>
                                                  </select>
                                          </div>
                                      </div>

                                      <div class="form-group">
                                          <label for="nivel1" class="col-sm-2 control-label">{{Session::get('nivel1')}}</label>
                                          <div class="col-sm-10">
                                                <select id="nivel1" placeholder="(Selecionar)" name="nivel1" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                <option  value=""></option>
                                                </select>
                                          </div>
                                      </div>

                            </div>

                            <!-- FIM Horizontal Form -->
                      </div>
                      <!-- /.tab-pane -->

                    </div>
                    <!-- /.tab-content -->
                  </div>
                  <!-- nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div><!-- /.row -->


         </div><!-- fim box-body"-->
     </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit'>Pesquisar</button>
        </div>

        </form>

    </div>

</div>

@include('configuracoes.script_estruturas')
@endsection