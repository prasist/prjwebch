@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Relatório de Células') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'relcelulas') }}
{{ \Session::put('id_pagina', '46') }}

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

                          <div class="row">
                                <div class="col-xs-5">
                                        @include('carregar_combos', array('dados'=>$lideres, 'titulo' =>'Líder', 'id_combo'=>'lideres', 'complemento'=>'', 'comparar'=>''))
                                </div>

                                <div class="col-xs-3">
                                      <input  id= "ckEstruturas" name="ckEstruturas" type="checkbox" class="minimal" checked />  Listar Estruturas Células
                                      <br/>
                                      <input  id= "ckExibir" name="ckExibir" type="checkbox" class="minimal" checked />  Listar Participantes
                                </div>

                                <!--
                                <div class="col-xs-3">
                                        <label for="tipo_relatorio" class="control-label">Tipo Relatório</label>
                                        <select id="tipo_relatorio" name="tipo_relatorio" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                            <option  value="S">Sintético</option>
                                            <option  value="A">Analítico</option>
                                        </select>
                                </div>
                                -->

                          </div>

                          <div class="row">

                                  <div class="col-xs-3">
                                        <label for="dia_encontro" class="control-label">Dia Encontro</label>
                                        <select id="dia_encontro" placeholder="(Selecionar)" name="dia_encontro" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                        <option  value=""></option>
                                        <option  value="2">Segunda-Feira</option>
                                        <option  value="3">Terça-Feira</option>
                                        <option  value="4">Quarta-Feira</option>
                                        <option  value="5">Quinta-Feira</option>
                                        <option  value="6">Sexta-Feira</option>
                                        <option  value="7">Sábado</option>
                                        <option  value="0">Domingo</option>
                                        </select>
                                  </div>

                                  <div class="col-xs-3">
                                        <label for="turno" class="control-label">Turno</label>
                                        <select id="turno" placeholder="(Selecionar)" name="turno" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                        <option  value=""></option>
                                        <option  value="M">Manhã</option>
                                        <option  value="T">Tarde</option>
                                        <option  value="N">Noite</option>
                                        </select>
                                  </div>

                                  <div class="col-xs-3">
                                        <label for="regiao" class="control-label">Região</label>
                                        <input id="regiao"  placeholder="(Opcional)" name = "regiao" type="text" class="form-control" value="">
                                  </div>

                                  <div class="col-xs-3">
                                        <label for="segundo_dia_encontro" class="control-label">Segundo Dia Encontro</label>
                                        <select id="segundo_dia_encontro" placeholder="(Selecionar)" name="segundo_dia_encontro" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                        <option  value=""></option>
                                        <option  value="2">Segunda-Feira</option>
                                        <option  value="3">Terça-Feira</option>
                                        <option  value="4">Quarta-Feira</option>
                                        <option  value="5">Quinta-Feira</option>
                                        <option  value="6">Sexta-Feira</option>
                                        <option  value="7">Sábado</option>
                                        <option  value="0">Domingo</option>
                                        </select>
                                  </div>
                          </div>

                          <div class="row">

                              <div class="col-xs-5">
                                    @include('carregar_combos', array('dados'=>$publicos, 'titulo' =>'Público Alvo', 'id_combo'=>'publico_alvo', 'complemento'=>'', 'comparar'=>''))
                              </div>

                              <div class="col-xs-5">
                                    @include('carregar_combos', array('dados'=>$faixas, 'titulo' =>'Faixa Etária', 'id_combo'=>'faixa_etaria', 'complemento'=>'', 'comparar'=>''))
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