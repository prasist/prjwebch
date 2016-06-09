@extends('principal.master')

@section('content')

@if ($tipo=="P")
    {{ \Session::put('titulo', 'Contas à Pagar') }}
@else
    {{ \Session::put('titulo', 'Contas à Receber') }}
@endif
{{ \Session::put('subtitulo', 'Alteração') }}
{{ \Session::put('route', 'titulos') }}
{{ \Session::put('id_pagina', '52') }}

<div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href={{ url('/' . \Session::get('route')) . '/' . $tipo }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

     <form method = 'POST' class="form-horizontal"  action = {{ url('/' . \Session::get('route') . '/' . $dados[0]->id . '/update/' . $tipo)}}>

       {!! csrf_field() !!}

        <div class="box box-default">

             <div class="box-body">


                            <!-- Custom Tabs -->
                      <div class="nav-tabs-custom">

                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#tab_1" data-toggle="tab">Dados</a></li>
                          <li><a href="#tab_2" data-toggle="tab">Histórico</a></li>
                        </ul>

                        <div class="tab-content">
                          <div class="tab-pane active" id="tab_1">

                                        <div class="row">
                                              <div class="col-xs-4 {{ $errors->has('descricao') ? ' has-error' : '' }}">
                                                    <label for="descricao" class="control-label">Descrição</label>
                                                    <input id="descricao"  placeholder="Campo Obrigatório" name = "descricao" type="text" class="form-control" value="{{ $dados[0]->descricao }}">
                                                       <!-- se houver erros na validacao do form request -->
                                                       @if ($errors->has('descricao'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('descricao') }}</strong>
                                                        </span>
                                                       @endif
                                              </div>

                                              <div class="col-xs-2 {{ $errors->has('valor') ? ' has-error' : '' }}">
                                                    <label for="valor" class="control-label">Valor</label>
                                                    <div class="input-group">
                                                       <span class="input-group-addon">R$</span>
                                                         <input id="valor" maxlength="60"   name = "valor" type="text" class="formata_valor form-control" value="{{ $dados[0]->valor }}">
                                                         @if ($errors->has('valor'))
                                                          <span class="help-block">
                                                              <strong>{{ $errors->first('valor') }}</strong>
                                                          </span>
                                                         @endif
                                                   </div>
                                              </div>


                                              <div class="col-xs-2">
                                                  <label for="data_emissao" class="control-label">Data Emissão</label>

                                                  <div class="input-group">
                                                         <div class="input-group-addon">
                                                          <i class="fa fa-calendar"></i>
                                                          </div>

                                                          <input id ="data_emissao" name = "data_emissao" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ $dados[0]->data_emissao }}">
                                                  </div>

                                             </div>

                                             <div class="col-xs-2 {{ $errors->has('data_vencimento') ? ' has-error' : '' }}">
                                                  <label for="data_vencimento" class="control-label">Data Vencimento</label>

                                                  <div class="input-group">
                                                         <div class="input-group-addon">
                                                          <i class="fa fa-calendar"></i>
                                                          </div>

                                                          <input id ="data_vencimento" name = "data_vencimento" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{ $dados[0]->data_vencimento }}">
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
                                                    @include('carregar_combos', array('dados'=>$contas, 'titulo' =>'Conta', 'id_combo'=>'conta', 'complemento'=>'', 'comparar'=>$dados[0]->contas_id, 'id_pagina'=> '48'))
                                                    @include('modal_cadastro_basico', array('qual_campo'=>'conta', 'modal' => 'modal_conta', 'tabela' => 'contas'))
                                              </div><!-- col-xs-->

                                              <div class="col-xs-4">
                                                    @include('carregar_combos', array('dados'=>$plano_contas, 'titulo' =>'Plano de Contas', 'id_combo'=>'plano', 'complemento'=>'', 'comparar'=>$dados[0]->planos_contas_id, 'id_pagina'=> '49'))
                                                    @include('modal_cadastro_basico', array('qual_campo'=>'plano', 'modal' => 'modal_plano', 'tabela' => 'planos_contas'))
                                              </div><!-- col-xs-->

                                              <div class="col-xs-4">
                                                    @include('carregar_combos', array('dados'=>$centros_custos, 'titulo' =>'Centro de Custo', 'id_combo'=>'centros_custos', 'complemento'=>'', 'comparar'=>$dados[0]->centros_custos_id, 'id_pagina'=> '50'))
                                                    @include('modal_cadastro_basico', array('qual_campo'=>'centros_custos', 'modal' => 'modal_centros_custos', 'tabela' => 'centros_custos'))
                                              </div><!-- col-xs-->

                                        </div>

                                        <input  id= "ckpago" name="ckpago" type="hidden" value=""/>
                                        <div class="row">
                                                <div class="col-xs-4">
                                                      <label for="ckpago" class="control-label">Pago ?</label>
                                                      <div class="input-group">
                                                             <div class="input-group-addon">
                                                                  <input  id= "ckpago" name="ckpago" type="checkbox" class="ckpago" data-group-cls="btn-group-sm" value="{{ ($dados[0]->status=='B' ? true : '') }}"  {{ ($dados[0]->status=='B' ? 'checked' : '') }} />
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
                                                                data-inputmask='"mask": "99/99/9999"' data-mask  value="{{$dados[0]->data_pagamento}}">
                                                        </div>

                                                   </div>

                                                     <div class="col-xs-2">
                                                          <label for="acrescimo" class="control-label">Acréscimo</label>
                                                          <div class="input-group">
                                                             <span class="input-group-addon">R$</span>
                                                               <input id="acrescimo" maxlength="10"   name = "acrescimo" type="text" class="formata_valor form-control" value="{{$dados[0]->acrescimo}}">
                                                          </div>
                                                     </div>

                                                      <div class="col-xs-2">
                                                          <label for="desconto" class="control-label">Desconto</label>
                                                          <div class="input-group">
                                                             <span class="input-group-addon">R$</span>
                                                               <input id="desconto" maxlength="10"   name = "desconto" type="text" class="formata_valor form-control" value="{{$dados[0]->desconto}}">
                                                          </div>
                                                     </div>

                                                     <div class="col-xs-2">
                                                          <label for="valor_pago" class="control-label">Valor Pago</label>
                                                          <div class="input-group">
                                                               <span class="input-group-addon">R$</span>
                                                               <input id="valor_pago" maxlength="10"   name = "valor_pago" type="text" class="formata_valor form-control" value="{{$dados[0]->valor_pago}}">
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

                                                                                          <input
                                                                                            id="fornecedor"
                                                                                            name = "fornecedor"
                                                                                            type="text"
                                                                                            class="form-control"
                                                                                            placeholder="Clica na lupa ao lado para consultar uma pessoa"
                                                                                            value="{!! ($dados[0]->pessoas_id!='' ? str_repeat('0', (9-strlen($dados[0]->pessoas_id))) . $dados[0]->pessoas_id . ' - ' . $dados[0]->razaosocial  : '') !!}"
                                                                                            readonly >

                                                                                  </div>
                                                                         </div>

                                                                          <div class="col-xs-5">
                                                                                <label for="obs" class="control-label">Observação</label>
                                                                                <input id="obs"  placeholder="(Opcional)" name = "obs" type="text" class="form-control" value="{{$dados[0]->obs}}">
                                                                          </div>

                                                                    </div>

                                                                     <div class="row">
                                                                          <div class="col-xs-2">
                                                                                <label for="parcelas" class="control-label">Qtd. Parcelas</label>
                                                                                <input id="parcelas"  placeholder="(Opcional)" name = "parcelas" type="text" class="form-control" value="{{$dados[0]->numpar}}">
                                                                          </div>

                                                                          <div class="col-xs-2">
                                                                                <label for="numdoc" class="control-label">N. Documento</label>
                                                                                <input id="numdoc"  placeholder="(Opcional)" name = "numdoc" type="text" class="form-control" value="{{$dados[0]->numdoc}}">
                                                                          </div>

                                                                          <div class="col-xs-2">
                                                                                <label for="serie" class="control-label">Série</label>
                                                                                <input id="serie"  placeholder="(Opcional)" name = "serie" type="text" class="form-control" value="{{$dados[0]->serie}}">
                                                                          </div>

                                                                          <div class="col-xs-6">
                                                                                @include('carregar_combos', array('dados'=>$grupos_titulos, 'titulo' =>'Grupo Título', 'id_combo'=>'grupos_titulos', 'complemento'=>'', 'comparar'=>$dados[0]->grupos_titulos_id, 'id_pagina'=> '51'))
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


                          </div>
                          <!-- /.tab-pane -->

                          <div class="tab-pane" id="tab_2">
                                    <table class="table">
                                    <tr>
                                        <td>Data Ocorrência</td>
                                        <td>Usuário</td>
                                        <td>Descrição Título</td>
                                        <td>Valor</td>
                                        <td>Tipo</td>
                                        <td>Status</td>
                                        <td>Ação</td>
                                        <td>IP</td>
                                    </tr>
                                    @foreach($log as $item)
                                          <tr>
                                              <td>{{$item->data_ocorrencia}}</td>
                                              <td>{{$item->name}}</td>
                                              <td>{{$item->descricao}}</td>
                                              <td>{{$item->valor}}</td>
                                              <td>{{$item->tipo}}</td>
                                              <td>{{$item->status}}</td>
                                              <td>{{$item->acao}}</td>
                                              <td>{{$item->ip}}</td>
                                          </tr>
                                    @endforeach
                                    </table>
                          </div>
                          <!-- /.tab-pane -->

                        </div>
                        <!-- /.tab-content -->
                      </div>
                      <!-- nav-tabs-custom -->





             </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}>Gravar</button>
            <a href="{{ url('/' . \Session::get('route') . '/' . $tipo)}}" class="btn btn-default">Cancelar</a>
        </div>

        </form>


    </div>

</div>
@include('titulos.script_titulos')

@endsection

