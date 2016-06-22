@extends('principal.master')

@section('content')

@if ($tipo=="P")
    {{ \Session::put('titulo', 'Contas à Pagar') }}
@else
    {{ \Session::put('titulo', 'Contas à Receber') }}
@endif
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'titulos') }}
{{ \Session::put('id_pagina', '52') }}

<div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href={{ url('/' . \Session::get('route')) . '/' . $tipo }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

     <form method = 'POST'  class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/gravar/' . $tipo)}}>

       {!! csrf_field() !!}

        <div class="box box-default">
            <!--  status, descricao, valor, data_vencimento, data_emissao) -->
             <div class="box-body">
                    <input  id= "ckpago" name="ckpago" type="hidden" value=""/>
                    <input type="hidden" name="total_pago" id='total_pago' value="0">

                                  <div class="row">
                                      <div class="col-xs-4 {{ $errors->has('descricao') ? ' has-error' : '' }}">
                                            <label for="descricao" class="control-label"><span class="text-danger">*</span> Descrição</label>
                                            <input id="descricao"  placeholder="Campo Obrigatório" name = "descricao" type="text" class="form-control" value="{{ old('descricao') }}">
                                               <!-- se houver erros na validacao do form request -->
                                               @if ($errors->has('descricao'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('descricao') }}</strong>
                                                </span>
                                               @endif
                                      </div>

                                      <div class="col-xs-2 {{ $errors->has('valor') ? ' has-error' : '' }}">

                                            <label for="valor" class="control-label"><span class="text-danger">*</span> Valor</label>
                                            <div class="input-group">
                                             <span class="input-group-addon">R$</span>
                                             <input id="valor" maxlength="60"  placeholder="" name = "valor" type="text" class="formata_valor form-control" onblur="atualizar_valor_rateio();" value="{{ old('valor') }}">
                                               @if ($errors->has('valor'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('valor') }}</strong>
                                                </span>
                                               @endif
                                           </div>

                                      </div>

                                      <div class="col-xs-2">
                                          <label for="data_emissao" class="control-label"><span class="text-danger">*</span> Data Emissão</label>
                                          <div class="input-group">
                                                 <div class="input-group-addon">
                                                  <i class="fa fa-calendar"></i>
                                                  </div>

                                                  <input id ="data_emissao" name = "data_emissao" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                          </div>
                                     </div>

                                     <div class="col-xs-2 {{ $errors->has('data_vencimento') ? ' has-error' : '' }}">
                                          <label for="data_vencimento" class="control-label"><span class="text-danger">*</span> Data Vencimento</label>

                                          <div class="input-group">
                                                 <div class="input-group-addon">
                                                  <i class="fa fa-calendar"></i>
                                                  </div>

                                                  <input id ="data_vencimento" name = "data_vencimento" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask value="">
                                                  <!-- se houver erros na validacao do form request -->
                                                   @if ($errors->has('data_vencimento'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('data_vencimento') }}</strong>
                                                    </span>
                                                   @endif
                                          </div>

                                     </div>

                                </div> <!-- row -->

                                <div class="row">
                                      <div class="col-xs-4  {{ $errors->has('conta') ? ' has-error' : '' }}">
                                            <span class="text-danger">*</span>@include('carregar_combos', array('dados'=>$contas, 'titulo' =>'Conta', 'id_combo'=>'conta', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '48'))
                                            @include('modal_cadastro_basico', array('qual_campo'=>'conta', 'modal' => 'modal_conta', 'tabela' => 'contas'))

                                                 <!-- se houver erros na validacao do form request -->
                                                 @if ($errors->has('conta'))
                                                 <span class="help-block">
                                                      <strong>{{ $errors->first('conta') }}</strong>
                                                 </span>
                                                 @endif
                                      </div><!-- col-xs-->

                                      <div class="col-xs-4">
                                            @include('carregar_combos', array('dados'=>$plano_contas, 'titulo' =>'Plano de Contas', 'id_combo'=>'plano', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '49'))
                                            @include('modal_cadastro_basico', array('qual_campo'=>'plano', 'modal' => 'modal_plano', 'tabela' => 'planos_contas'))
                                      </div><!-- col-xs-->


                                      <div class="col-xs-3">

                                          <label for="centros_custos" class="control-label">Centro de Custo</label>
                                            <div class="input-group">
                                                   <div class="input-group-addon">
                                                      <a href="#" data-toggle="tooltip" title="Clique em 'Incluir Novo Registro' para cadastrar sem sair da página.">
                                                            <img src="{{ url('/images/help.png') }}" class="user-image" alt="Ajuda"  />
                                                       </a>
                                                    </div>

                                                    <select id="centros_custos" onchange="incluir_registro_combo('centros_custos');" placeholder="(Selecionar)"
                                                    name="centros_custos" data-live-search="true" data-none-selected-text="Nenhum item selecionado"
                                                    class="form-control selectpicker" style="width: 100%;">
                                                    <option  value=""></option>

                                                    <!-- Verifica permissão de inclusao da pagina/tabela-->
                                                    @can('verifica_permissao', [52 ,'incluir'])
                                                        <optgroup label="Ação">
                                                    @else
                                                        <optgroup label="Ação" disabled>
                                                    @endcan

                                                    <option  value=""  data-icon="fa fa-eraser">(Nenhum)</option>
                                                    <option  value=""  data-icon="fa fa-plus-circle">(Incluir Novo Registro)</option>
                                                    <option data-divider="true"></option>
                                                    </optgroup>

                                                    <optgroup label="Registros">
                                                    @foreach($centros_custos as $item)
                                                           <option  value="{{$item->id}}" >{{$item->nome}}</option>
                                                    @endforeach
                                                    </select>
                                                    </optgroup>

                                                    <span class="input-group-addon">
                                                          <button  id="novorateio" type="button" data-toggle="modal" data-target="#myModal" onclick="calcular_rateio();">
                                                              Rateio...
                                                          </button>
                                                    </span>

                                           </div>


                                            @include('modal_cadastro_basico', array('qual_campo'=>'centros_custos', 'modal' => 'modal_centros_custos', 'tabela' => 'centros_custos'))
                                      </div>

                                </div>

                                          <!-- vai ratear ? -->
                                          <!-- Modal -->
                                              <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog  modal-lg" role="document">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                                                        <h4 class="modal-title" id="myModalLabel">Rateio por Centro de Custo</h4>
                                                        </div>
                                                        <div class="modal-body">

                                                             <div class="row">
                                                                      <div class="col-xs-2">
                                                                       <i class="text-info"> Valor Total Título :</i> <input type="text" id="valor_original" readonly="true" name="valor_original" value="" class="form-control">
                                                                      </div>
                                                                      <div class="col-xs-2">
                                                                       <i class="text-info"> Soma do Rateio :</i> <input type="text" id="soma_rateio" readonly="true" name="soma_rateio" value="" class="form-control">
                                                                      </div>
                                                                      <div class="col-xs-2">
                                                                       <i class="text-info"> Valor Restante : </i><input type="text" id="valor_restante" readonly="true" name="valor_restante" value="" class="form-control">
                                                                      </div>
                                                             </div>

                                                             <div class="row">

                                                                    <div class="col-xs-4">
                                                                          <label for="rateio_cc" class="control-label">Centro de Custo</label>

                                                                          <select id="rateio_cc" name="rateio_cc" placeholder="(Selecionar)" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;" onchange="document.getElementById('perc_rateio').focus(); validar_cc(this.value);">
                                                                          <option  value=""></option>
                                                                          @foreach($centros_custos as $item)
                                                                                 <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                    </div>

                                                                    <div class="col-xs-3">
                                                                          <label for="perc_rateio" class="control-label">% Rateio</label>
                                                                          <div class="input-group">
                                                                           <span class="input-group-addon">%</span>
                                                                           <input id="perc_rateio" onfocus="document.getElementById('valor_rateio').value=''; " name = "perc_rateio" type="text" class="form-control" value="" onblur="calcular_rateio();">
                                                                          </div>
                                                                    </div>

                                                                    <div class="col-xs-3">
                                                                          <label for="valor_rateio" class="control-label">Valor</label>
                                                                          <div class="input-group">
                                                                           <span class="input-group-addon">R$</span>
                                                                           <input id="valor_rateio" onfocus="document.getElementById('perc_rateio').value=''; "  name = "valor_rateio" type="text" class="form-control" value="" onblur="calcular_rateio();">
                                                                          </div>
                                                                    </div>

                                                                    <div class="col-xs-2">
                                                                          <label for="botao" class="control-label">&nbsp;</label>
                                                                          <button id="botao" type="button" class="btn btn-success form-control" onclick="incluir_rateio();"><i class="fa fa-plus"></i> Incluir</button>
                                                                    </div>
                                                            </div>

                                                        <div class="row">
                                                              <div class="col-xs-10">
                                                              <input type="hidden" name="hidden_id_rateio_cc[]" id="hidden_id_rateio_cc[]" value="">
                                                                    <table id="mais_rateios" class="table table-bordered table-hover">
                                                                        <tr>
                                                                              <td>Centro de Custo</td>
                                                                              <td>%</td>
                                                                              <td>Valor</td>
                                                                              <td>Excluir</td>
                                                                        </tr>
                                                                    </table>
                                                              </div>
                                                        </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button id="tchau" type="button" class="btn btn-danger" data-dismiss="modal" onclick="remover_todos();">Cancelar / Excluir Tudo</button>
                                                            <button id="salvar" type="button" class="btn btn-primary" data-dismiss="modal" disabled="true"><i class="fa fa-save"></i> Salvar / Fechar</button>
                                                        </div>
                                                      </div>
                                                    </div>
                                               </div>
                                           <!-- fim modal -->

                                <div class="row">
                                        <div class="col-xs-4">
                                              <label for="ckpago" class="control-label">Pago ?</label>
                                              <div class="input-group">
                                                     <div class="input-group-addon">
                                                          <input  id= "ckpago" name="ckpago" type="checkbox" class="ckpago" data-group-cls="btn-group-sm" value="true"/>
                                                     </div>
                                              </div>
                                        </div>

                                      <div id="esconder" style="display: none" >
                                            <div class="col-xs-2">
                                                <label for="data_pagamento" class="control-label">Data Pagamento</label>

                                                <div class="input-group">
                                                       <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input id ="data_pagamento" name = "data_pagamento"
                                                        onblur="validar_data(this);" type="text"
                                                        class="form-control"
                                                        data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                </div>

                                           </div>

                                             <div class="col-xs-2">
                                                  <label for="acrescimo" class="control-label">Acréscimo</label>
                                                  <div class="input-group">
                                                      <span class="input-group-addon">R$</span>
                                                      <input id="acrescimo" maxlength="10"   name = "acrescimo" type="text" class="formata_valor form-control" value="">
                                                 </div>
                                             </div>

                                              <div class="col-xs-2">
                                                   <label for="desconto" class="control-label">Desconto</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">R$</span>
                                                        <input id="desconto" maxlength="10"   name = "desconto" type="text" class="formata_valor form-control" value="">
                                                   </div>
                                             </div>

                                             <div class="col-xs-2">
                                                  <label for="valor_pago" class="control-label">Valor Pago</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">R$</span>
                                                        <input id="valor_pago" maxlength="10"   name = "valor_pago" type="text" class="formata_valor form-control" value="">
                                                   </div>
                                             </div>

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
                                                      ( + ) Mais Informações
                                                    </a>
                                                  </h5>
                                                </div>
                                                <div id="collapseOne" class="panel-collapse collapse">
                                                  <div class="box-body">

                                                             <div class="row">
                                                                   <div class="col-xs-7">
                                                                        <label for="fornecedor" class="control-label">Fornecedor / Cliente</label>
                                                                        <div class="input-group">
                                                                                 <div class="input-group-addon">
                                                                                    <button  id="buscarpessoa" type="button"  data-toggle="modal" data-target="#modal_fornecedor" >
                                                                                           <i class="fa fa-search"></i> ...
                                                                                     </button>
                                                                                  </div>

                                                                                  @include('modal_buscar_pessoas', array('qual_campo'=>'fornecedor', 'modal' => 'modal_fornecedor'))

                                                                                  <input id="fornecedor"  name = "fornecedor" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >

                                                                          </div>
                                                                 </div>

                                                                  <div class="col-xs-5">
                                                                        <label for="obs" class="control-label">Observação</label>
                                                                        <input id="obs"  placeholder="(Opcional)" name = "obs" type="text" class="form-control" value="">
                                                                  </div>

                                                            </div>

                                                             <div class="row">
                                                                  <div class="col-xs-2">
                                                                        <label for="parcelas" class="control-label">Qtd. Parcelas</label>
                                                                        <input id="parcelas"  placeholder="(Opcional)" name = "parcelas" type="number" class="form-control" value="1">
                                                                  </div>

                                                                  <div class="col-xs-2">
                                                                        <label for="numdoc" class="control-label">N. Documento</label>
                                                                        <input id="numdoc"  placeholder="(Opcional)" name = "numdoc" type="text" class="form-control" value="">
                                                                  </div>

                                                                  <div class="col-xs-2">
                                                                        <label for="serie" class="control-label">Série</label>
                                                                        <input id="serie"  placeholder="(Opcional)" name = "serie" type="text" class="form-control" value="">
                                                                  </div>

                                                                  <div class="col-xs-6">
                                                                        @include('carregar_combos', array('dados'=>$grupos_titulos, 'titulo' =>'Grupo Título', 'id_combo'=>'grupos_titulos', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '51'))
                                                                        @include('modal_cadastro_basico', array('qual_campo'=>'grupos_titulos', 'modal' => 'modal_grupos_titulos', 'tabela' => 'grupos_titulos'))
                                                                  </div><!-- col-xs-->

                                                             </div>

                                                  </div>
                                                </div>
                                              </div>

                                            </div>
                                          </div>

                                        </div>

                                      </div>

                                    </div>

             </div><!-- fim box-body"-->
        </div><!-- box box-primary -->
        <span class="text-danger">* <i>Campos Obrigatórios</i></span>

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit'>Gravar</button>
            <a href="{{ url('/' . \Session::get('route') . '/' . $tipo)}}" class="btn btn-default">Cancelar</a>
        </div>

        </form>

    </div>

</div>

@include('titulos.script_titulos')

@endsection