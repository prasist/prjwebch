@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Cadastro de Células') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'celulas') }}
{{ \Session::put('id_pagina', '42') }}

<div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href={{ url('/' . \Session::get('route')) }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

    <form method = 'POST'  class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/gravar')}}>

       {!! csrf_field() !!}

<!-- Horizontal Form -->
 <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Estrutura de Células</h3>
      </div>

        <div class="box-body">


          <div class="form-group">
            <label for="nivel5" class="col-sm-2 control-label">{!!Session::get('nivel5') !!}</label>
            <div class="col-sm-10{{ $errors->has('nivel5') ? ' has-error' : '' }}">
                    <select id="nivel5" placeholder="(Selecionar)" name="nivel5" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                    <option  value=""></option>
                    @foreach($nivel5 as $item)
                           <option  value="{{$item->id}}" >{{$item->nome}}</option>
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

<!-- FIM Horizontal Form -->

    <div class="box box-default">

          <div class="box-body">

                  <div class="row">

                        <div class="col-xs-6 {{ $errors->has('pessoas') ? ' has-error' : '' }}">
                                <label for="nome" class="control-label">Líder</label>
                                <div class="input-group">
                                         <div class="input-group-addon">
                                            <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#modal_lider" >
                                                   <i class="fa fa-search"></i> ...
                                             </button>
                                          </div>

                                          @include('modal_buscar_pessoas', array('qual_campo'=>'pessoas', 'modal' => 'modal_lider'))

                                          <input id="pessoas"  name = "pessoas" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >

                                          <!-- se houver erros na validacao do form request -->
                                           @if ($errors->has('pessoas'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('pessoas') }}</strong>
                                            </span>
                                           @endif

                                  </div>
                         </div>

                         <div class="col-xs-6">
                                <label for="nome" class="control-label">Nome Célula</label>
                                <input id="nome"  placeholder="(Opcional)" name = "nome" type="text" class="form-control" value="">

                          </div>


                  </div>

                  <div class="row">

                        <div class="col-xs-4 {{ $errors->has('vicelider_pessoas_id') ? ' has-error' : '' }}">
                                <label for="vicelider_pessoas_id" class="control-label">Vice-Líder</label>
                                <div class="input-group">
                                         <div class="input-group-addon">
                                            <button  id="buscarpessoa2" type="button"  data-toggle="modal" data-target="#modal_vice" >
                                                   <i class="fa fa-search"></i> ...
                                             </button>
                                          </div>

                                          @include('modal_buscar_pessoas', array('qual_campo'=>'vicelider_pessoas_id', 'modal' => 'modal_vice'))

                                          <input id="vicelider_pessoas_id"  name = "vicelider_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >

                                          <!-- se houver erros na validacao do form request -->
                                           @if ($errors->has('vicelider_pessoas_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('vicelider_pessoas_id') }}</strong>
                                            </span>
                                           @endif

                                  </div>
                         </div>

                         <div class="col-xs-4 {{ $errors->has('suplente1_pessoas_id') ? ' has-error' : '' }}">
                                  <label for="suplente1_pessoas_id" class="control-label">Suplente I</label>
                                  <div class="input-group">
                                           <div class="input-group-addon">
                                              <button  id="buscarpessoa3" type="button"  data-toggle="modal" data-target="#modal_suplente1" >
                                                     <i class="fa fa-search"></i> ...
                                               </button>
                                            </div>

                                            @include('modal_buscar_pessoas', array('qual_campo'=>'suplente1_pessoas_id', 'modal' => 'modal_suplente1'))

                                            <input id="suplente1_pessoas_id"  name = "suplente1_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >

                                            <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('suplente1_pessoas_id'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('suplente1_pessoas_id') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                         </div>


                         <div class="col-xs-4 {{ $errors->has('suplente1_pessoas_id') ? ' has-error' : '' }}">
                                <label for="suplente2_pessoas_id" class="control-label">Suplente II</label>
                                <div class="input-group">
                                         <div class="input-group-addon">
                                            <button  id="buscarpessoa4" type="button"  data-toggle="modal" data-target="#modal_suplente2" >
                                                   <i class="fa fa-search"></i> ...
                                             </button>
                                          </div>

                                          @include('modal_buscar_pessoas', array('qual_campo'=>'suplente2_pessoas_id', 'modal' => 'modal_suplente2'))

                                          <input id="suplente2_pessoas_id"  name = "suplente2_pessoas_id" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >
                                          <!-- se houver erros na validacao do form request -->
                                           @if ($errors->has('suplente2_pessoas_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('suplente2_pessoas_id') }}</strong>
                                            </span>
                                           @endif

                                  </div>
                         </div>


                  </div>


                  <div class="row">

                          <div class="col-xs-3 {{ $errors->has('dia_encontro') ? ' has-error' : '' }}">
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

                                <!-- se houver erros na validacao do form request -->
                               @if ($errors->has('dia_encontro'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dia_encontro') }}</strong>
                                </span>
                               @endif

                          </div>

                          <div class="col-xs-3 {{ $errors->has('turno') ? ' has-error' : '' }}">
                                <label for="turno" class="control-label">Turno</label>

                                <select id="turno" placeholder="(Selecionar)" name="turno" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                <option  value=""></option>
                                <option  value="M">Manhã</option>
                                <option  value="T">Tarde</option>
                                <option  value="N">Noite</option>
                                </select>

                                <!-- se houver erros na validacao do form request -->
                               @if ($errors->has('turno'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('turno') }}</strong>
                                </span>
                               @endif

                          </div>

                          <div class="col-xs-3 {{ $errors->has('regiao') ? ' has-error' : '' }}">
                                <label for="regiao" class="control-label">Região</label>
                                <input id="regiao"  placeholder="(Opcional)" name = "regiao" type="text" class="form-control" value="">

                                <!-- se houver erros na validacao do form request -->
                               @if ($errors->has('regiao'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('regiao') }}</strong>
                                </span>
                               @endif

                          </div>

                             <div class="col-xs-3 {{ $errors->has('segundo_dia_encontro') ? ' has-error' : '' }}">
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

                                <!-- se houver erros na validacao do form request -->
                               @if ($errors->has('segundo_dia_encontro'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('segundo_dia_encontro') }}</strong>
                                </span>
                               @endif

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
                                                        <input id="email_grupo"  placeholder="(Opcional)" name = "email_grupo" type="text" class="form-control" value="">
                                                  </div>
                                             </div>

                                             <div class="row">
                                                  <div class="col-xs-10">
                                                        <label for="obs" class="control-label">Observações</label>
                                                        <input id="obs"  placeholder="(Opcional)" name = "obs" type="text" class="form-control" value="">
                                                  </div>
                                             </div>

                                             <div class="row">

                                                  <div class="col-xs-5">
                                                        @include('carregar_combos', array('dados'=>$publicos, 'titulo' =>'Público Alvo', 'id_combo'=>'publico_alvo', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '43'))
                                                        @include('modal_cadastro_basico', array('qual_campo'=>'publico_alvo', 'modal' => 'modal_publico_alvo', 'tabela' => 'publicos_alvos'))
                                                  </div>

                                                  <div class="col-xs-5">
                                                        @include('carregar_combos', array('dados'=>$faixas, 'titulo' =>'Faixa Etária', 'id_combo'=>'faixa_etaria', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '44'))
                                                        @include('modal_cadastro_basico', array('qual_campo'=>'faixa_etaria', 'modal' => 'modal_faixa_etaria', 'tabela' => 'faixas_etarias'))
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

        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit'>Gravar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>

        </form>

    </div>

</div>

@include('configuracoes.script_estruturas')
@endsection