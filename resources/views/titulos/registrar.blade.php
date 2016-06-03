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

        <div class="box box-primary">
            <!--  status, descricao, valor, data_vencimento, data_emissao) -->
             <div class="box-body">
                    <input  id= "ckpago" name="ckpago" type="hidden" value=""/>

                    <div class="row">
                          <div class="col-xs-4 {{ $errors->has('descricao') ? ' has-error' : '' }}">
                                <label for="descricao" class="control-label">Descrição</label>
                                <input id="descricao"  placeholder="Campo Obrigatório" name = "descricao" type="text" class="form-control" value="{{ old('descricao') }}">
                                   <!-- se houver erros na validacao do form request -->
                                   @if ($errors->has('descricao'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descricao') }}</strong>
                                    </span>
                                   @endif
                          </div>

                          <div class="col-xs-2 {{ $errors->has('valor') ? ' has-error' : '' }}">
                                <label for="valor" class="control-label">Valor</label>
                                <input id="valor" maxlength="60"  placeholder="R$" name = "valor" type="text" class="form-control" value="{{ old('valor') }}">
                                   @if ($errors->has('valor'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valor') }}</strong>
                                    </span>
                                   @endif
                          </div>


                          <div class="col-xs-2">
                              <label for="data_emissao" class="control-label">Data Emissão</label>

                              <div class="input-group">
                                     <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                      </div>

                                      <input id ="data_emissao" name = "data_emissao" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                              </div>

                         </div>

                         <div class="col-xs-2 {{ $errors->has('data_vencimento') ? ' has-error' : '' }}">
                              <label for="data_vencimento" class="control-label">Data Vencimento</label>

                              <div class="input-group">
                                     <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                      </div>

                                      <input id ="data_vencimento" name = "data_vencimento" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
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
                          <div class="col-xs-4">
                                @include('carregar_combos', array('dados'=>$contas, 'titulo' =>'Conta', 'id_combo'=>'conta', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '48'))
                                @include('modal_cadastro_basico', array('qual_campo'=>'conta', 'modal' => 'modal_conta', 'tabela' => 'contas'))
                          </div><!-- col-xs-->

                          <div class="col-xs-4">
                                @include('carregar_combos', array('dados'=>$plano_contas, 'titulo' =>'Plano de Contas', 'id_combo'=>'plano', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '49'))
                                @include('modal_cadastro_basico', array('qual_campo'=>'plano', 'modal' => 'modal_plano', 'tabela' => 'planos_contas'))
                          </div><!-- col-xs-->

                          <div class="col-xs-4">
                                @include('carregar_combos', array('dados'=>$centros_custos, 'titulo' =>'Centro de Custo', 'id_combo'=>'centros_custos', 'complemento'=>'', 'comparar'=>'', 'id_pagina'=> '50'))
                                @include('modal_cadastro_basico', array('qual_campo'=>'centros_custos', 'modal' => 'modal_centros_custos', 'tabela' => 'centros_custos'))
                          </div><!-- col-xs-->

                    </div>

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
                                      <input id="acrescimo" maxlength="10"  placeholder="R$" name = "acrescimo" type="text" class="form-control" value="">
                                 </div>

                                  <div class="col-xs-2">
                                      <label for="desconto" class="control-label">Desconto</label>
                                      <input id="desconto" maxlength="10"  placeholder="R$" name = "desconto" type="text" class="form-control" value="">
                                 </div>

                                 <div class="col-xs-2">
                                      <label for="valor_pago" class="control-label">Valor Pago</label>
                                      <input id="valor_pago" maxlength="10"  placeholder="R$" name = "valor_pago" type="text" class="form-control" value="">
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
                                                            <input id="parcelas"  placeholder="(Opcional)" name = "parcelas" type="text" class="form-control" value="1">
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

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit'>Gravar</button>
            <a href="{{ url('/' . \Session::get('route') . '/' . $tipo)}}" class="btn btn-default">Cancelar</a>
        </div>

        </form>


    </div>

</div>

<script type="text/javascript">
 /*Prepara checkbox bootstrap*/
       $(function () {

            $('.ckpago').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
            });


            $('#ckpago').change(function()
            {
                  if ($(this).prop('checked'))
                     $("#esconder").show();
                  else
                    $("#esconder").hide();
            });


      });

</script>

@endsection