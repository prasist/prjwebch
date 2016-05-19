        <form name ="form_principal" method = 'POST' class="form-horizontal"  action = {{ url('/' . \Session::get('route') . '/pesquisar')}}>

        {!! csrf_field() !!}

        <!-- Filtros para pesquisa-->
        <!-- /.box-header -->
        <div class="box-body">
          <div class="box-group" id="accordion">
            <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
            <div class="panel box box-default">
              <div class="box-header with-border">
                <h5 class="box-title">
                  <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    <span class="fa fa-search"></span> Filtros
                  </a>
                </h5>
              </div>
              <div id="collapseOne" class="panel-collapse collapse in">
                      <div class="box-body">

                            <div class="row">
                                  <div class="col-xs-10">
                                        <label for="razaosocial" class="control-label">Termo a pesquisar...</label>
                                        <input id="razaosocial"  placeholder="(Pesquise por Nome, Nome Abreviado, CPF ou CNPJ)" name = "razaosocial" type="text" class="form-control" value="">
                                  </div>
                           </div>

                     </div>
              </div>
            </div>

                 <!-- TAB Dados Profissionais -->
                      <div class="panel box box-primary">
                        <div class="box-header with-border">
                          <h5 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#tab2">
                              <span class="fa fa-search-plus"></span> Pesquisa Avançada
                            </a>
                          </h5>
                        </div>
                        <div id="tab2" class="panel-collapse collapse">

                                <div class="box-body">

                                   <div class="row">
                                          <div class="col-xs-3">
                                              <label for="opStatus" class="control-label">Status</label>

                                              <select name="opStatus" class="form-control select2" style="width: 100%;">
                                                    <option  value="A">Ambos</option>
                                                     <option  value="S">Ativo</option>
                                                     <option  value="N">Inativo</option>
                                               </select>

                                          </div>

                                          <div class="col-xs-3">

                                                <label for="opPessoa" class="control-label">Tipo Pessoa</label>

                                                <select name="opPessoa" class="form-control select2" style="width: 100%;">
                                                     <option  value="">Ambos</option>
                                                     <option  value="F">Física</option>
                                                     <option  value="J">Jurídica</option>
                                                </select>

                                          </div>
                                   </div> <!-- end row-->

                                   <div class="row">
                                        <div class="col-xs-5">
                                              @include('carregar_combos', array('dados'=>$tipos, 'titulo' =>'Tipos de Pessoa', 'id_combo'=>'tipos', 'complemento'=>'', 'comparar'=>''))
                                              @include('modal_cadastro_basico', array('qual_campo'=>'tipos', 'modal' => 'modal_tipos', 'tabela' => 'tipos_pessoas'))
                                        </div><!-- col-xs-5-->

                                        <div class="col-xs-5">
                                              @include('carregar_combos', array('dados'=>$grupos, 'titulo' =>'Grupo', 'id_combo'=>'grupo', 'complemento'=>'', 'comparar'=>''))
                                              @include('modal_cadastro_basico', array('qual_campo'=>'grupo', 'modal' => 'modal_grupo', 'tabela' => 'grupos_pessoas'))
                                        </div><!-- col-xs-5-->

                                   </div>

                                   <div class="row">

                                        <div class="col-xs-4">

                                                <label for="mes" class="control-label">Aniversariante Mês</label>

                                                <select name="mes" class="form-control select2" style="width: 100%;">
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

                                  </div>
                            </div> <!-- fim box body -->

                        </div>
                      </div><!-- FIM TAB Dados Profissionais -->

          </div>

          <div class="box-footer">
              <button class = 'btn btn-primary' type ='submit'>Pesquisar</button>
          </div>

        </div>
        <!-- /.box-body -->
        </form>