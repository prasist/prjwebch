@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Cadastro de Células') }}

@if ($tipo_operacao=="incluir")
    {{ \Session::put('subtitulo', 'Inclusão') }}
@else
    {{ \Session::put('subtitulo', 'Alteração / Visualização') }}
@endif

{{ \Session::put('route', 'celulas') }}
{{ \Session::put('id_pagina', '42') }}

<div class = 'row'>

<div class="col-md-12">

<div>
        <a href={{ url('/' . \Session::get('route')) }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
</div>

@if ($tipo_operacao=="incluir")
<form id="form_celulas" method = 'POST'  class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/gravar')}}>
@else
<form id="form_celulas" method = 'POST' class="form-horizontal"  action = {{ url('/' . \Session::get('route') . '/' . $dados[0]->id . '/update')}}>
@endif

<input type="hidden" id="quero_incluir_participante" name="quero_incluir_participante" value="">
{!! csrf_field() !!}

<div class="box box-default">
  <div class="box-body">
    <div class="row">
        <div class="col-md-12">

                      <div class="nav-tabs-custom">

                          <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Dados Cadastrais</a></li>
                            <li><a href="#tab_2" data-toggle="tab">Vinculo de Células</a></li>
                            @if ($total_vinculos>0)
                                <li><a href="#tab_3" data-toggle="tab"> Exibir Célula(s) Vinculada(s)&nbsp;<span class="pull-right badge bg-blue">{!! ($total_vinculos==0 ? "" : $total_vinculos) !!}</span></a></li>
                            @endif
                          </ul>

                          <div class="tab-content">
                                    <!-- TABS-->
                                    <div class="tab-pane active" id="tab_1">

                                        <div class="row">

                                              <div class="form-group">
                                              <label for="nivel5" class="col-sm-2 control-label">{!!Session::get('nivel5') !!}</label>
                                              <div class="col-sm-10{{ $errors->has('nivel5') ? ' has-error' : '' }}">
                                                      <select id="nivel5" placeholder="(Selecionar)" name="nivel5" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                      <option  value=""></option>
                                                      @foreach($nivel5 as $item)
                                                             @if ($tipo_operacao=="editar")
                                                                  <option  value="{{$item->id}}" {{ ($dados[0]->celulas_nivel5_id == $item->id ? 'selected' : '') }} >{{$item->nome}}</option>
                                                             @else
                                                                  <option  value="{{$item->id}}" >{{$item->nome}}</option>
                                                             @endif
                                                      @endforeach
                                                      </select>
                                                      <!-- se houver erros na validacao do form request -->
                                                     @if ($errors->has('nivel5'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('nivel5') }}</strong>
                                                      </span>
                                                     @endif
                                              </div>
                                            </div>


                                            <div class="form-group">
                                            <label for="nivel4" class="col-sm-2 control-label">{{Session::get('nivel4')}}</label>

                                            <div class="col-sm-10{{ $errors->has('nivel4') ? ' has-error' : '' }}">
                                                  <select id="nivel4" placeholder="(Selecionar)" name="nivel4" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                  <option  value=""></option>
                                                  </select>
                                            </div>

                                                  <!-- se houver erros na validacao do form request -->
                                                   @if ($errors->has('nivel4'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('nivel4') }}</strong>
                                                    </span>
                                                   @endif
                                          </div>

                                          <div class="form-group">
                                            <label for="nivel3" class="col-sm-2 control-label">{{Session::get('nivel3')}}</label>

                                            <div class="col-sm-10{{ $errors->has('nivel3') ? ' has-error' : '' }}">
                                                  <select id="nivel3" placeholder="(Selecionar)" name="nivel3" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                  <option  value=""></option>
                                                  </select>
                                            </div>

                                                  <!-- se houver erros na validacao do form request -->
                                                   @if ($errors->has('nivel3'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('nivel3') }}</strong>
                                                    </span>
                                                   @endif
                                          </div>

                                          <div class="form-group">
                                            <label for="nivel2" class="col-sm-2 control-label">{{Session::get('nivel2')}}</label>

                                            <div class="col-sm-10{{ $errors->has('nivel2') ? ' has-error' : '' }}">
                                                    <select id="nivel2" placeholder="(Selecionar)" name="nivel2" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                    <option  value=""></option>
                                                    </select>
                                            </div>

                                                 <!-- se houver erros na validacao do form request -->
                                                 @if ($errors->has('nivel2'))
                                                  <span class="help-block">
                                                      <strong>{{ $errors->first('nivel2') }}</strong>
                                                  </span>
                                                 @endif
                                          </div>

                                          <div class="form-group">
                                            <label for="nivel1" class="col-sm-2 control-label">{{Session::get('nivel1')}}</label>

                                            <div class="col-sm-10{{ $errors->has('nivel1') ? ' has-error' : '' }}">
                                                  <select id="nivel1" placeholder="(Selecionar)" name="nivel1" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                  <option  value=""></option>
                                                  </select>
                                            </div>

                                                    <!-- se houver erros na validacao do form request -->
                                                   @if ($errors->has('nivel1'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('nivel1') }}</strong>
                                                    </span>
                                                   @endif
                                          </div>

                                        </div>

                                         <div class="row">

                                              <div class="col-xs-4">
                                                      <label for="nome" class="control-label">Nome Célula</label>
                                                      @if ($tipo_operacao=="editar")
                                                            <input id="nome"  placeholder="(Opcional)" name = "nome" type="text" class="form-control" value="{!! $dados[0]->nome !!}">
                                                      @else
                                                            <input id="nome"  placeholder="(Opcional)" name = "nome" type="text" class="form-control" value="">
                                                      @endif
                                              </div>

                                              <div class="col-xs-4 {{ $errors->has('regiao') ? ' has-error' : '' }}">
                                                      <label for="regiao" class="control-label">Região</label>
                                                      @if ($tipo_operacao=="editar")
                                                        <input id="regiao"  placeholder="(Opcional)" name = "regiao" type="text" class="form-control" value="{{$dados[0]->regiao}}">
                                                      @else
                                                        <input id="regiao"  placeholder="(Opcional)" name = "regiao" type="text" class="form-control" value="">
                                                      @endif

                                                      <!-- se houver erros na validacao do form request -->
                                                     @if ($errors->has('regiao'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('regiao') }}</strong>
                                                      </span>
                                                     @endif

                                              </div>
                                        </div>

                                        <div class="row">

                                              <div class="col-xs-4 {{ $errors->has('pessoas') ? ' has-error' : '' }}">
                                                      <label for="pessoas" class="control-label"><span class="text-danger">*</span> Líder</label>
                                                      <div class="input-group">
                                                               <div class="input-group-addon">
                                                                  <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#modal_lider" >
                                                                         <i class="fa fa-search"></i> ...
                                                                   </button>
                                                                </div>

                                                                @include('modal_buscar_pessoas', array('qual_campo'=>'pessoas', 'modal' => 'modal_lider'))

                                                                @if ($tipo_operacao=="editar")
                                                                    <input id="pessoas"  name = "pessoas" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="{!! ($dados[0]->lider_pessoas_id!="" ? str_repeat('0', (9-strlen($dados[0]->lider_pessoas_id))) . $dados[0]->lider_pessoas_id . ' - ' . $dados[0]->razaosocial  : '') !!}" readonly >
                                                                @else
                                                                    <input id="pessoas"  name = "pessoas" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                                                @endif

                                                                <!-- se houver erros na validacao do form request -->
                                                                @if ($errors->has('pessoas'))
                                                                <span class="help-block">
                                                                    <strong>{{ $errors->first('pessoas') }}</strong>
                                                                </span>
                                                                @endif

                                                        </div>
                                               </div>

                                               <div class="col-xs-4 {{ $errors->has('vicelider_pessoas_id') ? ' has-error' : '' }}">
                                                      <label for="vicelider_pessoas_id" class="control-label">Vice-Líder</label>
                                                      <div class="input-group">
                                                               <div class="input-group-addon">
                                                                  <button  id="buscarpessoa2" type="button"  data-toggle="modal" data-target="#modal_vice" >
                                                                         <i class="fa fa-search"></i> ...
                                                                   </button>
                                                                </div>

                                                                @include('modal_buscar_pessoas', array('qual_campo'=>'vicelider_pessoas_id', 'modal' => 'modal_vice'))

                                                                @if ($tipo_operacao=="editar")
                                                                       <input id="vicelider_pessoas_id"  name = "vicelider_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="{!! ($dados[0]->vicelider_pessoas_id!="" ? str_repeat('0', (9-strlen($dados[0]->vicelider_pessoas_id))) . $dados[0]->vicelider_pessoas_id . ' - ' . $dados[0]->nome_vicelider  : '') !!}" readonly >
                                                                @else
                                                                       <input id="vicelider_pessoas_id"  name = "vicelider_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                                                @endif

                                                                <!-- se houver erros na validacao do form request -->
                                                                @if ($errors->has('vicelider_pessoas_id'))
                                                                <span class="help-block">
                                                                     <strong>{{ $errors->first('vicelider_pessoas_id') }}</strong>
                                                                 </span>
                                                                @endif
                                                        </div>
                                               </div>

                                               <div class="col-xs-4 {{ $errors->has('suplente1_pessoas_id') ? ' has-error' : '' }}">
                                                        <label for="suplente1_pessoas_id" class="control-label">Anfitrião</label>
                                                        <div class="input-group">
                                                                 <div class="input-group-addon">
                                                                    <button  id="buscarpessoa3" type="button"  data-toggle="modal" data-target="#modal_suplente1" >
                                                                           <i class="fa fa-search"></i> ...
                                                                     </button>
                                                                  </div>

                                                                  @include('modal_buscar_pessoas', array('qual_campo'=>'suplente1_pessoas_id', 'modal' => 'modal_suplente1'))

                                                                  @if ($tipo_operacao=="editar")
                                                                      <input id="suplente1_pessoas_id"  name = "suplente1_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="{!! ($dados[0]->suplente1_pessoas_id!="" ? str_repeat('0', (9-strlen($dados[0]->suplente1_pessoas_id))) . $dados[0]->suplente1_pessoas_id . ' - ' . $dados[0]->nome_suplente1  : '') !!}" readonly >
                                                                  @else
                                                                      <input id="suplente1_pessoas_id"  name = "suplente1_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                                                  @endif

                                                                  <!-- se houver erros na validacao do form request -->
                                                                   @if ($errors->has('suplente1_pessoas_id'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('suplente1_pessoas_id') }}</strong>
                                                                    </span>
                                                                   @endif

                                                          </div>
                                               </div>

                                        </div>



                                        <div class="row">

                                                <div class="col-xs-2 {{ $errors->has('dia_encontro') ? ' has-error' : '' }}">
                                                      <label for="dia_encontro" class="control-label"><span class="text-danger">*</span> Dia Encontro</label>

                                                      <select id="dia_encontro" placeholder="(Selecionar)" name="dia_encontro" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                      <option  value=""></option>
                                                      @if ($tipo_operacao=="editar")
                                                             <option  value="2" {{ ($dados[0]->dia_encontro=="2" ? "selected" : "") }}>Segunda-Feira</option>
                                                             <option  value="3" {{ ($dados[0]->dia_encontro=="3" ? "selected" : "") }}>Terça-Feira</option>
                                                             <option  value="4" {{ ($dados[0]->dia_encontro=="4" ? "selected" : "") }}>Quarta-Feira</option>
                                                             <option  value="5" {{ ($dados[0]->dia_encontro=="5" ? "selected" : "") }}>Quinta-Feira</option>
                                                             <option  value="6" {{ ($dados[0]->dia_encontro=="6" ? "selected" : "") }}>Sexta-Feira</option>
                                                             <option  value="7" {{ ($dados[0]->dia_encontro=="7" ? "selected" : "") }}>Sábado</option>
                                                             <option  value="0" {{ ($dados[0]->dia_encontro=="0" ? "selected" : "") }}>Domingo</option>
                                                      @else
                                                             <option  value="2" >Segunda-Feira</option>
                                                             <option  value="3" >Terça-Feira</option>
                                                             <option  value="4" >Quarta-Feira</option>
                                                             <option  value="5">Quinta-Feira</option>
                                                             <option  value="6">Sexta-Feira</option>
                                                             <option  value="7">Sábado</option>
                                                             <option  value="0">Domingo</option>
                                                      @endif
                                                      </select>

                                                      <!-- se houver erros na validacao do form request -->
                                                     @if ($errors->has('dia_encontro'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('dia_encontro') }}</strong>
                                                      </span>
                                                     @endif

                                                </div>

                                                <div class="col-xs-2 {{ $errors->has('horario') ? ' has-error' : '' }}">

                                                        <div class="bootstrap-timepicker">
                                                              <div class="form-group">
                                                                <label for="horario" class="control-label"><span class="text-danger">*</span>  Horário</label>

                                                                <div class="input-group">
                                                                  @if ($tipo_operacao=="editar")
                                                                        <input type="text" name="horario" id="horario"  data-inputmask='"mask": "99:99"' data-mask  class="form-control input-small" value="{{ $dados[0]->horario}}">
                                                                  @else
                                                                        <input type="text" name="horario" id="horario"  data-inputmask='"mask": "99:99"' data-mask  class="form-control input-small">
                                                                  @endif
                                                                  <div class="input-group-addon">
                                                                    <i class="fa fa-clock-o"></i>
                                                                  </div>
                                                                </div>
                                                                <!-- /.input group -->
                                                              </div>
                                                              <!-- /.form group -->
                                                            </div>

                                                            @if ($errors->has('horario'))
                                                              <span class="help-block">
                                                                  <strong>{{ $errors->first('horario') }}</strong>
                                                              </span>
                                                             @endif

                                                </div>

                                                <div class="col-xs-4">
                                                      <label for="local" class="control-label">Local Encontro</label>

                                                      <select id="local" placeholder="(Selecionar)" name="local" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                      <option  value=""></option>
                                                      @if ($tipo_operacao=="editar")
                                                          <option  value="1" {{ ($dados[0]->qual_endereco=="1" ? "selected" : "") }}>Endereço do Líder</option>
                                                          <option  value="2" {{ ($dados[0]->qual_endereco=="2" ? "selected" : "") }}>Endereço do Vice Líder</option>
                                                          <option  value="3" {{ ($dados[0]->qual_endereco=="3" ? "selected" : "") }}>Endereço do Anfitrião</option>
                                                          <option  value="4" {{ ($dados[0]->qual_endereco=="4" ? "selected" : "") }}>Endereço do Líder Suplente</option>
                                                          <option  value="5" {{ ($dados[0]->qual_endereco=="5" ? "selected" : "") }}>Endereço da Igreja Sede</option>
                                                          <option  value="6" {{ ($dados[0]->qual_endereco=="6" ? "selected" : "") }}>Outro</option>
                                                      @else
                                                          <option  value="1">Endereço do Líder</option>
                                                          <option  value="2">Endereço do Vice Líder</option>
                                                          <option  value="3">Endereço do Anfitrião</option>
                                                          <option  value="4">Endereço do Líder Suplente</option>
                                                          <option  value="5">Endereço da Igreja Sede</option>
                                                          <option  value="6">Outro</option>
                                                      @endif
                                                      </select>
                                             </div>

                                                <!--
                                                <div class="col-xs-3 {{ $errors->has('turno') ? ' has-error' : '' }}">
                                                      <label for="turno" class="control-label">Turno</label>

                                                      <select id="turno" placeholder="(Selecionar)" name="turno" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                      <option  value=""></option>
                                                      <option  value="M">Manhã</option>
                                                      <option  value="T">Tarde</option>
                                                      <option  value="N">Noite</option>
                                                      </select>

                                                     @if ($errors->has('turno'))
                                                      <span class="help-block">
                                                          <strong>{{ $errors->first('turno') }}</strong>
                                                      </span>
                                                     @endif

                                                </div>
                                                -->


                                        </div><!-- end row -->

                                           <div class="row">

                                              <div class="col-xs-4">
                                                    @if ($tipo_operacao=="editar")
                                                          @include('carregar_combos', array('dados'=>$publicos, 'titulo' =>'Público Alvo', 'id_combo'=>'publico_alvo', 'complemento'=>'', 'comparar'=>$dados[0]->publico_alvo_id, 'id_pagina'=> '43'))
                                                    @else
                                                          @include('carregar_combos', array('dados'=>$publicos, 'titulo' =>'Público Alvo', 'id_combo'=>'publico_alvo', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '43'))
                                                    @endif

                                                    @include('modal_cadastro_basico', array('qual_campo'=>'publico_alvo', 'modal' => 'modal_publico_alvo', 'tabela' => 'publicos_alvos'))
                                              </div>

                                              <div class="col-xs-4">
                                                    @if ($tipo_operacao=="editar")
                                                          @include('carregar_combos', array('dados'=>$faixas, 'titulo' =>'Faixas Etárias', 'id_combo'=>'faixa_etaria', 'complemento'=>'', 'comparar'=>$dados[0]->faixa_etaria_id, 'id_pagina'=> '44'))
                                                    @else
                                                          @include('carregar_combos', array('dados'=>$faixas, 'titulo' =>'Faixas Etárias', 'id_combo'=>'faixa_etaria', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '44'))
                                                    @endif

                                                    @include('modal_cadastro_basico', array('qual_campo'=>'faixa_etaria', 'modal' => 'modal_faixa_etaria', 'tabela' => 'faixas_etarias'))
                                              </div>

                                        </div>


                                        <br/>
                                        <div class="row">
                                            <div class="col-md-12">
                                              <div class="box box-solid">

                                                <!-- /.box-header -->
                                                <div class="box-body">
                                                  <div class="box-group" id="accordion">
                                                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                                                    <div class="panel box box-default">
                                                      <div class="box-header with-border">
                                                        <h5 class="box-title">
                                                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                                            ( + ) Informações Complementares
                                                          </a>
                                                        </h5>
                                                      </div>
                                                      <div id="collapseOne" class="panel-collapse collapse">
                                                        <div class="box-body">

                                                                   <div class="row">
                                                                        <div class="col-xs-10">
                                                                              <label for="email_grupo" class="control-label">E-mail do grupo</label>
                                                                              @if ($tipo_operacao=="editar")
                                                                                    <input id="email_grupo"  placeholder="(Opcional)" name = "email_grupo" type="text" class="form-control" value="{!! $dados[0]->email_grupo!!}">
                                                                              @else
                                                                                    <input id="email_grupo"  placeholder="(Opcional)" name = "email_grupo" type="text" class="form-control" value="">
                                                                              @endif
                                                                        </div>
                                                                   </div>

                                                                   <div class="row">
                                                                        <div class="col-xs-10">
                                                                              <label for="obs" class="control-label">Observações</label>
                                                                              @if ($tipo_operacao=="editar")
                                                                                    <input id="obs"  placeholder="(Opcional)" name = "obs" type="text" class="form-control" value="{!! $dados[0]->obs!!}">
                                                                              @else
                                                                                    <input id="obs"  placeholder="(Opcional)" name = "obs" type="text" class="form-control" value="">
                                                                              @endif
                                                                        </div>
                                                                   </div>


                                                                  <div class="row">
                                                                    <div class="col-xs-4">
                                                                          <label for="suplente2_pessoas_id" class="control-label">Líder Suplente</label>
                                                                          <div class="input-group">
                                                                                   <div class="input-group-addon">
                                                                                      <button  id="buscarpessoa4" type="button"  data-toggle="modal" data-target="#modal_suplente2" >
                                                                                             <i class="fa fa-search"></i> ...
                                                                                       </button>
                                                                                    </div>

                                                                                    @include('modal_buscar_pessoas', array('qual_campo'=>'suplente2_pessoas_id', 'modal' => 'modal_suplente2'))

                                                                                    @if ($tipo_operacao=="editar")
                                                                                          <input id="suplente2_pessoas_id"  name = "suplente2_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="{!! ($dados[0]->suplente2_pessoas_id!="" ? str_repeat('0', (9-strlen($dados[0]->suplente2_pessoas_id))) . $dados[0]->suplente2_pessoas_id . ' - ' . $dados[0]->nome_suplente2  : '') !!}" readonly >
                                                                                    @else
                                                                                          <input id="suplente2_pessoas_id"  name = "suplente2_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                                                                    @endif


                                                                            </div>
                                                                   </div>

                                                                    <div class="col-xs-2">
                                                                        <label for="segundo_dia_encontro" class="control-label">2º Dia Encontro</label>

                                                                        <select id="segundo_dia_encontro" placeholder="(Selecionar)" name="segundo_dia_encontro" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                                                        <option  value=""></option>
                                                                        @if ($tipo_operacao=="editar")
                                                                              <option  value="2" {{ ($dados[0]->segundo_dia_encontro=="2" ? "selected" : "") }}>Segunda-Feira</option>
                                                                              <option  value="3" {{ ($dados[0]->segundo_dia_encontro=="3" ? "selected" : "") }}>Terça-Feira</option>
                                                                              <option  value="4" {{ ($dados[0]->segundo_dia_encontro=="4" ? "selected" : "") }}>Quarta-Feira</option>
                                                                              <option  value="5" {{ ($dados[0]->segundo_dia_encontro=="5" ? "selected" : "") }}>Quinta-Feira</option>
                                                                              <option  value="6" {{ ($dados[0]->segundo_dia_encontro=="6" ? "selected" : "") }}>Sexta-Feira</option>
                                                                              <option  value="7" {{ ($dados[0]->segundo_dia_encontro=="7" ? "selected" : "") }}>Sábado</option>
                                                                              <option  value="0" {{ ($dados[0]->segundo_dia_encontro=="0" ? "selected" : "") }}>Domingo</option>
                                                                        @else
                                                                              <option  value="2">Segunda-Feira</option>
                                                                              <option  value="3">Terça-Feira</option>
                                                                              <option  value="4">Quarta-Feira</option>
                                                                              <option  value="5">Quinta-Feira</option>
                                                                              <option  value="6">Sexta-Feira</option>
                                                                              <option  value="7">Sábado</option>
                                                                              <option  value="0">Domingo</option>
                                                                        @endif
                                                                        </select>

                                                                  </div>

                                                                  <div class="col-xs-2">

                                                                          <div class="bootstrap-timepicker">
                                                                                <div class="form-group">
                                                                                  <label for="horario2" class="control-label">Horário 2º Dia Encontro</label>

                                                                                  <div class="input-group">

                                                                                     @if ($tipo_operacao=="editar")
                                                                                          <input type="text" name="horario2" id="horario2"  data-inputmask='"mask": "99:99"' data-mask  class="form-control input-small" value="{{ $dados[0]->horario2}}">
                                                                                     @else
                                                                                          <input type="text" name="horario2" id="horario2"  data-inputmask='"mask": "99:99"' data-mask  class="form-control input-small">
                                                                                     @endif

                                                                                    <div class="input-group-addon">
                                                                                      <i class="fa fa-clock-o"></i>
                                                                                    </div>
                                                                                  </div>
                                                                                  <!-- /.input group -->
                                                                                </div>
                                                                                <!-- /.form group -->
                                                                              </div>

                                                                  </div>
                                                                </div>

                                                                <div class="row">
                                                                       <div class="col-xs-2">
                                                                                <label  for="data_inicio" class="control-label">Data de Início da Célula</label>
                                                                                <div class="input-group">
                                                                                       <div class="input-group-addon">
                                                                                        <i class="fa fa-calendar"></i>
                                                                                        </div>
                                                                                        @if ($tipo_operacao=="editar")
                                                                                              <input id ="data_inicio" name = "data_inicio" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ $dados[0]->data_inicio_format}}">
                                                                                        @else
                                                                                              <input id ="data_inicio" name = "data_inicio" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                                        @endif
                                                                                </div>
                                                                       </div>
                                                                </div>

                                                        </div>
                                                      </div>
                                                    </div>

                                                  </div>
                                                </div>
                                                <!-- /.box-body -->
                                              </div>
                                              <!-- /.box -->
                                            </div>

                                        </div><!-- fim box-body"-->

                                    </div><!-- /.tab-pane -->

                                    <div class="tab-pane" id="tab_2">

                                          <div class="row">
                                                <div class="col-xs-11">
                                                      <p class="text-info">- Informe o campo abaixo caso essa célula teve origem de outra.</p>
                                                      <p class="text-info"> - Células Vinculadas são aquelas que ocorrem dentro da própria célula, por exemplo : Célula para Crianças</p>
                                                      <p class="text-info"> - Células Multiplicadas são novas células geradas a partir de outra.</p>

                                                      <label for="origem" class="control-label">Qual a origem dessa célula ?</label>
                                                      <select id="origem" placeholder="(Selecionar)" name="origem" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;" >
                                                      <option  value=""></option>
                                                      @if ($tipo_operacao=="editar")
                                                          <option  value="1" {{ $dados[0]->origem == 1 ? "selected" : ""}}>Multiplicação</option>
                                                          <option  value="2" {{ $dados[0]->origem == 2 ? "selected" : ""}}>Vínculo (ou célula Filha)</option>
                                                      @else
                                                          <option  value="1">Multiplicação</option>
                                                          <option  value="2">Vínculo (ou célula Filha)</option>
                                                      @endif
                                                      </select>

                                                </div>
                                          </div>

                                          <div class="row">
                                              <div class="col-xs-11">
                                                      <label for="celulas_pai_id" class="control-label">Quem é a Célula Pai ?</label>
                                                      <select id="celulas_pai_id" placeholder="(Selecionar)" name="celulas_pai_id" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;" >
                                                      <option  value="0"></option>
                                                      @foreach($celulas as $item)
                                                              @if ($tipo_operacao=="editar")
                                                                    <option  value="{{$item->id}}" {{$dados[0]->celulas_pai_id == $item->id ? "selected" : ""}}>{{$item->nome}}</option>
                                                               @else
                                                                    <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                               @endif
                                                      @endforeach
                                                      </select>
                                              </div>
                                        </div>


                                    </div>

                                    <div class="tab-pane" id="tab_3">
                                         <div class="row">
                                                  <div class="col-xs-11">
                                                    @if ($vinculos[0]->nome!="")
                                                          <label for="tabela" class="control-label">A Célula <i>{{ $dados[0]->nome}}</i> possui a(s) seguinte(s) célula(s) vinculada(s) : </label>
                                                          <table class="table">
                                                              <tr>
                                                                  <td>Célula</td>
                                                                  <td>Dia Encontro</td>
                                                                  <td>Horário</td>
                                                              </tr>
                                                              @foreach ($vinculos as $value)
                                                              <tr>
                                                                    <td>{!! $value->razaosocial . ($value->nome!="" ? ' - ' : ''). $value->nome !!}</td>
                                                                    <td>{!! $value->descricao_dia_encontro !!}</td>
                                                                    <td>{!! $value->horario !!}</td>
                                                              </tr>
                                                              @endforeach
                                                          </table>
                                                    @endif
                                                  </div>
                                         </div>
                                    </div>
                                    <!--  END TABS-->

                         </div> <!-- TAB CONTENTS -->

                      </div> <!-- nav-tabs-custom -->

        </div>
    </div>
  </div>
</div>

   <div class="box-footer">
       <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-save"></i> Salvar</button>
       <a href="#" class="btn btn-warning" onclick="salvar_e_incluir();" ><i class="fa fa-users"></i> Salvar e Incluir Participantes</a>
       <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
   </div>

   </form>

 </div>

</div>

@include('configuracoes.script_estruturas')

<script type="text/javascript">

    $(document).ready(function()
    {
            /*quando carregar a pagina e estiver preenchido o nivel4, dispara o evento que carrega as outras dropdows.*/
            if ($("#nivel5").val()!="")
            {
                  $("#nivel5").trigger("change");
            }
    });

    function salvar_e_incluir()
    {
          $('#quero_incluir_participante').val('sim');
          $('#form_celulas')[0].submit();
    }

</script>


@endsection