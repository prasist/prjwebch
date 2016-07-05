@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Relatório Financeiro') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'relfinanceiro') }}
{{ \Session::put('id_pagina', '53') }}


<div class="row">

  <form method = 'POST'  class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/pesquisar')}}>
  {!! csrf_field() !!}
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->

        <div class="col-md-6">

              <!-- INICIO CONTEUDO -->

                <!-- Horizontal Form -->
                <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title">Filtros</h3>
                  </div>
                  <!-- /.box-header -->
                  <!-- form start -->
                  <div class="form-horizontal">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="opTipo" class="col-sm-3 control-label">Tipo :</label>

                              <div class="col-xs-8">
                                    <select id="opTipo" placeholder="(Selecionar)" name="opTipo" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                    <option  value="P">Contas à Pagar</option>
                                    <option  value="R">Contas à Receber</option>
                                    </select>
                              </div><!-- col-xs-3-->
                      </div>

                      <div class="form-group">
                            <label for="status_id" class="col-sm-3 control-label">Status</label>
                            <div class="col-xs-8">
                                <select id="status_id" placeholder="(Selecionar)" name="status_id" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                <option  value="T" selected>Ambos</option>
                                <option  value="A">Abertos</option>
                                <option  value="B">Baixados</option>
                                </select>
                          </div><!-- col-xs-3-->
                      </div>

                      <div class="form-group">
                              <label for="centros_custos" class="col-sm-3 control-label">Centro de Custo</label>
                              <div class="col-xs-8">
                                    <select id="centros_custos" placeholder="(Selecionar)" name="centros_custos" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                    <option  value=""></option>
                                    @foreach($centros_custos as $item)
                                           <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                    @endforeach
                                    </select>
                              </div><!-- col-xs-3-->
                      </div>


                      <div class="form-group">
                            <label for="planos_contas" class="col-sm-3 control-label">Plano de Contas</label>
                            <div class="col-xs-8">
                                  <select id="planos_contas" placeholder="(Selecionar)" name="planos_contas" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                  <option  value=""></option>
                                  @foreach($planos_contas as $item)
                                         <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                  @endforeach
                                  </select>
                            </div><!-- col-xs-3-->
                      </div>

                      <div class="form-group">
                          <label for="fornecedor" class="col-sm-3 control-label">Fornecedor / Cliente</label>
                          <div class="col-xs-8">
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
                      </div>


                      <div class="form-group">
                          <label for="contas" class="col-sm-3 control-label">Conta</label>
                          <div class="col-xs-8">
                              <select id="contas" placeholder="(Selecionar)" name="contas" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                              <option  value=""></option>

                              @foreach($contas as $item)
                                     <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                              @endforeach
                              </select>
                         </div><!-- col-xs-5-->
                    </div>

                    <div class="form-group">
                           <label for="grupos" class="col-sm-3 control-label">Grupo de Títulos</label>
                            <div class="col-xs-8">
                                  <select id="grupos" placeholder="(Selecionar)" name="grupos" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                  <option  value=""></option>

                                  @foreach($grupos_titulos as $item)
                                         <option  value="{{$item->id . '|' . $item->nome}}">{{$item->nome}}</option>
                                  @endforeach
                                  </select>
                              </div><!-- col-xs-3-->
                    </div>

                 </div>
                    <!-- /.box-body -->
                    <!-- /.box-footer -->
                  </div>
                </div>
                <!-- /.box -->
              <!-- FIM CONTEUDO -->

        </div>

        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">


        <!-- INICIO CONTEUDO -->

                 <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Período</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="form-horizontal">
              <div class="box-body">

                <div class="form-group">
                      <label  for="data_emissao" class="col-sm-3 control-label">Data Emissão</label>

                      <div class="col-xs-3">
                              <div class="input-group">
                                     <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                      </div>
                                      <input id ="data_emissao" name = "data_emissao" onblur="validar_data(this);" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                              </div>
                     </div>

                     <label  for="data_emissao_ate" class="col-sm-1 control-label">Até</label>

                      <div class="col-xs-3">

                              <div class="input-group">
                                     <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                      </div>
                                      <input id ="data_emissao_ate" name = "data_emissao_ate" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                              </div>
                     </div>
                </div>

                <div class="form-group">

                      <label  for="data_vencimento" class="col-sm-3 control-label">Data Vencimento</label>
                      <div class="col-xs-3">
                              <div class="input-group">
                                     <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                      </div>
                                      <input id ="data_vencimento" name = "data_vencimento" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                              </div>
                     </div>

                     <label  for="data_vencimento_ate" class="col-sm-1 control-label">Até</label>
                     <div class="col-xs-3">

                              <div class="input-group">
                                     <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                      </div>
                                      <input id ="data_vencimento_ate" name = "data_vencimento_ate" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                              </div>

                     </div>

                </div>

                <div class="form-group">

                      <label  for="data_pagamento" class="col-sm-3 control-label">Data Pagamento</label>
                      <div class="col-xs-3">

                              <div class="input-group">
                                     <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                      </div>

                                      <input id ="data_pagamento" name = "data_pagamento" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                              </div>

                     </div>

                      <label  for="data_pagamento_ate" class="col-sm-1 control-label">Até</label>
                     <div class="col-xs-3">

                              <div class="input-group">
                                     <div class="input-group-addon">
                                      <i class="fa fa-calendar"></i>
                                      </div>

                                      <input id ="data_pagamento_ate" name = "data_pagamento_ate" onblur="validar_data(this)" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="">
                              </div>

                     </div>
                 </div>

              </div>
              <!-- /.box-body -->
              <!-- /.box-footer -->
            </div>
          </div>
          <!-- /.box -->


          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Opções do Relatório</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                        <label for="resultado" class="col-sm-3 control-label">Formato de Saída : </label>

                        <div class="col-xs-8">

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

               </div>

                <div class="form-group">
                          <label for="ordem" class="col-sm-3 control-label">Ordem</label>
                          <div class="col-xs-8">
                                <select id="ordem" name="ordem" class="form-control selectpicker">
                                <option  value="descricao"  selected>Descrição Título</option>
                                <option  value="razaosocial"  selected>Fornecedor/Cliente</option>
                                <option  value="data_vencimento" >Data Vencimento</option>
                                <option  value="data_pagamento" >Data Pagamento</option>
                                </select>
                         </div>
                </div>

              </div>
              <!-- /.box-body -->
              <!-- /.box-footer -->
            </div>
          </div>
          <!-- /.box -->

        <!-- FIM CONTEUDO -->

        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->


  <div class="box-footer">
      &nbsp;&nbsp;<button class = 'btn btn-primary' type ='submit' onclick="myApp.showPleaseWait();">Pesquisar</button>
      <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Limpar</a>
  </div>

  </form>

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