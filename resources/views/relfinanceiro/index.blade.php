@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Relatório Financeiro') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'relfinanceiro') }}
{{ \Session::put('id_pagina', '53') }}

<div class = 'row'>

 <div class="col-md-12">

  <form method = 'POST'  class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/pesquisar')}}>

  {!! csrf_field() !!}

    <div class="box box-default">

          <div class="box-body">

            <div class="row">
                <div class="col-md-12">


                                                            <div  class="row">
                                                                        <div class="col-xs-2">
                                                                                <label  for="data_emissao" class="control-label">Data Emissão</label>
                                                                                <div class="input-group">
                                                                                       <div class="input-group-addon">
                                                                                        <i class="fa fa-calendar"></i>
                                                                                        </div>
                                                                                        <input id ="data_emissao" name = "data_emissao" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                                </div>

                                                                       </div>

                                                                       <div class="col-xs-2">
                                                                                <label  for="data_emissao_ate" class="control-label">Até</label>
                                                                                <div class="input-group">
                                                                                       <div class="input-group-addon">
                                                                                        <i class="fa fa-calendar"></i>
                                                                                        </div>
                                                                                        <input id ="data_emissao_ate" name = "data_emissao_ate" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                                </div>
                                                                       </div>

                                                                       <div class="col-xs-2">
                                                                              <label  for="data_vencimento" class="control-label">Data Vencimento</label>
                                                                              <div class="input-group">
                                                                                     <div class="input-group-addon">
                                                                                      <i class="fa fa-calendar"></i>
                                                                                      </div>
                                                                                      <input id ="data_vencimento" name = "data_vencimento" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                              </div>
                                                                     </div>

                                                                     <div class="col-xs-2">
                                                                              <label  for="data_vencimento_ate" class="control-label">Até</label>

                                                                              <div class="input-group">
                                                                                     <div class="input-group-addon">
                                                                                      <i class="fa fa-calendar"></i>
                                                                                      </div>
                                                                                      <input id ="data_vencimento_ate" name = "data_vencimento_ate" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                              </div>

                                                                     </div>


                                                                       <div class="col-xs-2">
                                                                              <label  for="data_pagamento" class="control-label">Data Pagamento</label>

                                                                              <div class="input-group">
                                                                                     <div class="input-group-addon">
                                                                                      <i class="fa fa-calendar"></i>
                                                                                      </div>

                                                                                      <input id ="data_pagamento" name = "data_pagamento" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                              </div>

                                                                     </div>

                                                                     <div class="col-xs-2">
                                                                              <label  for="data_pagamento_ate" class="control-label">Até</label>

                                                                              <div class="input-group">
                                                                                     <div class="input-group-addon">
                                                                                      <i class="fa fa-calendar"></i>
                                                                                      </div>

                                                                                      <input id ="data_pagamento_ate" name = "data_pagamento_ate" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                                                                              </div>

                                                                     </div>



                                                                </div><!-- end row -->



                                                                 <div class="row"><!-- row saida-->



                                                                 </div><!-- end row -->

                                                             <div class="row">

                                                                    <div class="col-xs-3">

                                                                          <label for="opTipo" class="control-label">Tipo :</label>
                                                                          <select id="opTipo" placeholder="(Selecionar)" name="opTipo" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value="P">Contas à Pagar</option>
                                                                          <option  value="R">Contas à Receber</option>
                                                                          </select>
                                                                    </div><!-- col-xs-3-->

                                                                    <div class="col-xs-3">

                                                                          <label for="status_id" class="control-label">Status</label>

                                                                          <select id="status_id" placeholder="(Selecionar)" name="status_id" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value="T" selected>Ambos</option>
                                                                          <option  value="A">Abertos</option>
                                                                          <option  value="B">Baixados</option>
                                                                          </select>

                                                                    </div><!-- col-xs-3-->

                                                                      <div class="col-xs-3">

                                                                          <label for="centros_custos" class="control-label">Centro de Custo</label>

                                                                          <select id="centros_custos" placeholder="(Selecionar)" name="centros_custos" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>

                                                                          @foreach($centros_custos as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                      </div><!-- col-xs-3-->

                                                                      <div class="col-xs-3">
                                                                          <label for="planos_contas" class="control-label">Plano de Contas</label>

                                                                          <select id="planos_contas" placeholder="(Selecionar)" name="planos_contas" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>

                                                                          @foreach($planos_contas as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                      </div><!-- col-xs-3-->



                                                                 </div> <!-- end row -->

                                                                 <div class="row">
                                                                      <div class="col-xs-6">
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

                                                                      <div class="col-xs-3">

                                                                        <label for="contas" class="control-label">Conta</label>

                                                                          <select id="contas" placeholder="(Selecionar)" name="contas" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>

                                                                          @foreach($contas as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                    </div><!-- col-xs-5-->

                                                                    <div class="col-xs-3">
                                                                          <label for="grupos" class="control-label">Grupo de Títulos</label>

                                                                          <select id="grupos" placeholder="(Selecionar)" name="grupos" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                                          <option  value=""></option>

                                                                          @foreach($grupos_titulos as $item)
                                                                                 <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                      </div><!-- col-xs-3-->


                                                             </div> <!-- end row -->


                                                          <div class="row">

                                                              <div class="col-xs-3">

                                                                    <label for="resultado" class="control-label">Formato de Saída : </label>
                                                                    <select id="resultado" name="resultado" class="form-control selectpicker">
                                                                    <option  value="pdf" data-icon="fa fa-file-pdf-o" selected>PDF (.pdf)</option>
                                                                    <option  value="xlsx" data-icon="fa fa-file-excel-o">Planilha Excel (.xls)</option>
                                                                    <option  value="csv" data-icon="fa fa-file-excel-o">CSV (.csv)</option>
                                                                    <option  value="docx" data-icon="fa fa-file-word-o">Microsoft Word (.docx)</option>
                                                                    <option  value="html" data-icon="fa fa-file-word-o">HTML (.html)</option>
                                                                    <option  value="email" data-icon="fa fa-envelope-o">Listagem de E-mails</option>
                                                                    </select>

                                                                   @if ($var_download!="")
                                                                    <br/>
                                                                    <br/>
                                                                     <div class="alert2 alert-info">
                                                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                                      <h4><i class="icon fa fa-check"></i> Relatório gerado com Sucesso!</h4>
                                                                      Clique no link abaixo para baixar o arquivo.
                                                                    </div>
                                                                    <a href="{!! url($var_download) !!}" class="text" target="_blank">
                                                                    CLIQUE AQUI PARA VISUALIZAR / BAIXAR
                                                                    @if (substr($var_download,-3)=="pdf")
                                                                        <img src="{{ url('/images/pdf.png') }}" alt="Baixar Arquivo" />
                                                                     @elseif (substr($var_download,-4)=="xlsx")
                                                                        <img src="{{ url('/images/excel.png') }}" alt="Baixar Arquivo" />
                                                                     @elseif (substr($var_download,-3)=="csv")
                                                                        <img src="{{ url('/images/csv.jpg') }}" alt="Baixar Arquivo" />
                                                                     @elseif (substr($var_download,-4)=="docx")
                                                                         <img src="{{ url('/images/microsoft-word-icon.png') }}" alt="Baixar Arquivo" />
                                                                     @endif
                                                                     </a>
                                                                   @endif

                                                              </div>

                                                              <div class="col-xs-3">
                                                                    <label for="ordem" class="control-label">Ordem</label>
                                                                    <select id="ordem" name="ordem" class="form-control selectpicker">
                                                                    <option  value="descricao"  selected>Descrição Título</option>
                                                                    <option  value="razaosocial"  selected>Fornecedor/Cliente</option>
                                                                    <option  value="data_vencimento" >Data Vencimento</option>
                                                                    <option  value="data_pagamento" >Data Pagamento</option>
                                                                    </select>
                                                             </div>
                                                      </div>
                                  </div>

                          </div>


                  <div class="overlay modal" style="display: none">
                      <i class="fa fa-refresh fa-spin"></i>
                  </div>

            </div><!-- /.col -->
        </div><!-- /.row -->

    </div><!-- fim box-body"-->

 </div><!-- box box-primary -->

        <div class="box-footer">
            &nbsp;&nbsp;<button class = 'btn btn-primary' type ='submit' onclick="myApp.showPleaseWait();">Pesquisar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Limpar</a>
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

      /*Prepara checkbox bootstrap*/
       $(function () {

            $('.ckEstruturas').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
            });

            $('.possui_necessidades_especiais').checkboxpicker({
                offLabel : 'Não',
                onLabel : 'Sim',
            });

      });

</script>
@include('configuracoes.script_estruturas')


@endsection