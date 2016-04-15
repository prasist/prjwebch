@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Relatório de Células') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'relcelulas') }}
{{ \Session::put('id_pagina', '46') }}

<div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href={{ url('/' . \Session::get('route')) }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

  <form method = 'POST'  class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/pesquisar')}}>

  {!! csrf_field() !!}


    <div class="box box-default">

          <div class="box-body">

            <div class="row">
                <div class="col-md-11">
                  <!-- Custom Tabs -->
                  <div class="nav-tabs-custom">

                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab_1" data-toggle="tab">Filtros Básicos</a></li>
                      <li><a href="#tab_2" data-toggle="tab">Filtrar Estrutura de Células</a></li>
                    </ul>

                    <div class="tab-content">
                      <div class="tab-pane active" id="tab_1">

                          <div class="row">
                                <div class="col-xs-8">
                                        @include('carregar_combos', array('dados'=>$lideres, 'titulo' =>'Líder', 'id_combo'=>'lideres', 'complemento'=>'', 'comparar'=>''))
                                </div>

                                <div class="col-xs-4">
                                      <br/>
                                      <input  id= "ckExibir" name="ckExibir" type="checkbox" class="minimal" checked />  Listar Participantes
                                </div>
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
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>

        </form>

    </div>

</div>

@include('configuracoes.script_estruturas')
@endsection