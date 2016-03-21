<!-- DADOS ECLISIASTICOS-->
   <div class="tab-pane fade" id="eclesia">

      <div class="row">
              <div class="col-md-12">

                <div class="box box-solid">

                  <div class="box-header with-border">
                          <h3 class="box-title">Clique nas opções abaixo para preencher os dados</h3>
                  </div>

                  <!-- /.box-header -->
                  <div class="box-body">

                    <div class="box-group" id="accordion">

                      <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                      <div class="panel box box-primary">
                        <div class="box-header with-border">
                          <h5 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                              <span class="fa fa-user-plus"></span> Dados Pessoais
                            </a>
                          </h5>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse">
                          <div class="box-body">

                          <input type="hidden" name="situacoes[]" class="minimal" value="">

                                <div class="row">

                                        <div class="col-md-12">
                                                <div class="box box-default">
                                                    <div class="box-body">

                                                          <div class="col-xs-12">
                                                              @include('carregar_combos', array('dados'=>$familias, 'titulo' =>'Família', 'id_combo'=>'familia', 'complemento'=>'', 'comparar'=>''))
                                                          </div><!-- col-xs-5-->

                                                           <div class="col-xs-6">
                                                                  @include('carregar_combos', array('dados'=>$status, 'titulo' =>'Status', 'id_combo'=>'status', 'complemento'=>'', 'comparar'=>''))
                                                           </div><!-- col-xs-5-->

                                                           <div class="col-xs-6">
                                                                  @include('carregar_combos', array('dados'=>$situacoes, 'titulo' =>'Situações', 'id_combo'=>'situacoes[]', 'complemento'=>'multiple="multiple"', 'comparar'=>''))
                                                           </div><!-- col-xs-5-->
                                                   </div>
                                                </div>
                                          </div>

                                </div><!-- end row-->


                                <div class="row">

                                <!-- campos hidden -->

                                <input type="hidden" name="ck_necessidades" class="minimal" value="false">

                                         <div class="col-md-6">
                                                <div class="box box-default">
                                                    <div class="box-body">

                                                       <div class="col-xs-4">
                                                             <label for="opSexo" class="control-label">Sexo</label>
                                                             <select name="opSexo" class="form-control select2" style="width: 100%;">
                                                             <option  value="">(Selecionar)</option>
                                                                   <option  value="M"  {{ ($tipo_operacao=='inclusao' ? '' : ($membros_dados_pessoais[0]->sexo=='M' ? 'selected=selected' : '') )  }}>Masculino</option>
                                                                   <option  value="F" {{ ($tipo_operacao=='inclusao' ? '' : ($membros_dados_pessoais[0]->sexo=='F' ? 'selected=selected' : '') )  }}>Feminino</option>
                                                             </select>

                                                       </div>

                                                       <div class="col-xs-4">
                                                             <label for="opDoadorSangue" class="control-label">Doador Sangue</label>

                                                             <select name="opDoadorSangue" class="form-control select2" style="width: 100%;">
                                                             <option  value="">(Selecionar)</option>
                                                                   <option  value="true"  {{ ($tipo_operacao=='inclusao' ? '' : ($membros_dados_pessoais[0]->doador_sangue==1 ? 'selected=selected' : '') )  }}>SIM</option>
                                                                   <option  value="false" >NÃO</option>
                                                             </select>

                                                       </div>

                                                       <div class="col-xs-4">
                                                               <label for="opDoadorOrgaos" class="control-label">Doador Orgãos</label>

                                                               <select name="opDoadorOrgaos" class="form-control select2" style="width: 100%;">
                                                               <option  value="">(Selecionar)</option>
                                                                     <option  value="true" {{ ($tipo_operacao=='inclusao' ? '' : ($membros_dados_pessoais[0]->doador_orgaos==1 ? 'selected=selected' : '') )  }}>SIM</option>
                                                                     <option  value="false">NÃO</option>
                                                               </select>

                                                       </div>

                                                     </div>
                                                </div>
                                          </div>

                                           <div class="col-md-6">
                                                  <div class="box box-default">
                                                        <div class="box-body">

                                                                 <div class="col-xs-3">
                                                                          <label for="grpsangue" class="control-label">Grupo Sanguínio</label>
                                                                          <input id="grpsangue" name = "grpsangue" type="text" class="form-control"  value="{{ ($tipo_operacao=='inclusao' ? old('gruposanguinio') : $membros_dados_pessoais[0]->grupo_sanguinio) }}">
                                                                  </div>

                                                                  <div class="col-xs-7">

                                                                          <label for="ck_necessidades">Possui Necessidades Especiais ?</label>
                                                                          <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                        <input  id="ck_necessidades" name="ck_necessidades" type="checkbox" class="minimal-red" value="true" />
                                                                                </div>

                                                                                <input id="necessidades" name = "necessidades" type="text" class="form-control" placeholder="Descrição Tipo Necessidade"  value="{{ ($tipo_operacao=='inclusao' ? old('necessidades') : $membros_dados_pessoais[0]->descricao_necessidade_especial) }}">
                                                                          </div>

                                                                 </div>

                                                       </div>
                                                  </div>
                                            </div>

                           </div> <!-- end row-->

                           <div  class="row">

                                              <div class="col-md-6">

                                                    <div class="box box-default">

                                                          <div class="box-body">

                                                                <div class="col-xs-4">
                                                                          <label for="naturalidade" class="control-label">Naturalidade</label>
                                                                          <input id="naturalidade" name = "naturalidade" type="text" class="form-control"  value="{{ ($tipo_operacao=='inclusao' ? old('naturalidade') : $membros_dados_pessoais[0]->naturalidade) }}">
                                                                </div>

                                                                <div class="col-xs-2">
                                                                          <label for="ufnaturalidade" class="control-label">UF</label>
                                                                          <input id="ufnaturalidade" name = "ufnaturalidade" type="text" class="form-control"  value="{{ ($tipo_operacao=='inclusao' ? old('ufnaturalidade') : $membros_dados_pessoais[0]->uf_naturalidade) }}">
                                                                </div>

                                                                  <div class="col-xs-3">
                                                                            <label for="nacionalidade" class="control-label">Nacionalidade</label>
                                                                            <input id="nacionalidade" name = "nacionalidade" type="text" class="form-control"  value="{{ ($tipo_operacao=='inclusao' ? old('nacionalidade') : $membros_dados_pessoais[0]->nacionalidade) }}">
                                                                  </div>

                                                                  <div class="col-xs-3">
                                                                          @include('carregar_combos', array('dados'=>$idiomas, 'titulo' =>'Lingua Oficial', 'id_combo'=>'lingua', 'complemento'=>'', 'comparar'=>''))
                                                                  </div>


                                                          </div>

                                                    </div>
                                              </div>


                                              <div class="col-md-6">

                                                    <div class="box box-default">

                                                          <div class="box-body">

                                                                 <div class="col-xs-7">
                                                                         @include('carregar_combos', array('dados'=>$igrejas, 'titulo' =>'Igreja', 'id_combo'=>'igreja', 'complemento'=>'', 'comparar'=>''))
                                                                 </div>

                                                          </div>

                                                    </div>
                                              </div>


                           </div><!-- end row-->


                           <!-- REDES SOCIAIS -->
                           <div  class="row">

                                              <div class="col-md-12">

                                                    <div class="box box-default">
                                                          <div class="box-header">
                                                            <h3 class="box-title">Redes Sociais</h3>
                                                          </div>

                                                          <div class="box-body">

                                                                <div class="col-xs-10">
                                                                          <label for="facebook" class="control-label">Facebook</label>
                                                                          <input id="facebook" name = "facebook" type="text" class="form-control"  value="{{ ($tipo_operacao=='inclusao' ? old('facebook') : $membros_dados_pessoais[0]->link_facebook) }}">
                                                                </div>

                                                                <div class="col-xs-10">
                                                                          <label for="google" class="control-label">Google+</label>
                                                                          <input id="google" name = "google" type="text" class="form-control"  value="{{ ($tipo_operacao=='inclusao' ? old('google') : $membros_dados_pessoais[0]->link_google) }}">
                                                                </div>

                                                                  <div class="col-xs-10">
                                                                            <label for="instagram" class="control-label">Instagram</label>
                                                                            <input id="instagram" name = "instagram" type="text" class="form-control"  value="{{ ($tipo_operacao=='inclusao' ? old('instagram') : $membros_dados_pessoais[0]->link_instagram) }}">
                                                                  </div>

                                                                  <div class="col-xs-10">
                                                                            <label for="linkedin" class="control-label">LinkedIn</label>
                                                                            <input id="linkedin" name = "linkedin" type="text" class="form-control"  value="{{ ($tipo_operacao=='inclusao' ? old('linkedin') : $membros_dados_pessoais[0]->link_linkedin) }}">
                                                                  </div>


                                                          </div>

                                                    </div>
                                              </div>

                              </div><!-- end row-->

                          </div><!-- end box-body-->

                        </div> <!-- end collapse-->

                      </div>

                      <!-- TAB Dados Profissionais -->
                      <div class="panel box box-primary">
                        <div class="box-header with-border">
                          <h5 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#tab2">
                              <span class="fa fa-user-md"></span> Dados Profissionais
                            </a>
                          </h5>
                        </div>
                        <div id="tab2" class="panel-collapse collapse">
                          <div class="box-body">

                               <div  class="row">

                                     <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-body"><!-- box-body-->

                                                           <div class="row">

                                                                <div class="col-xs-10">
                                                                        <label for="nome_empresa" class="control-label">Empresa</label>
                                                                        <input id="nome_empresa" maxlength="150" name = "nome_empresa" type="text" class="form-control" value="{{old('nome_empresa')}}">
                                                                </div>
                                                           </div>

                                                           <div class="row">

                                                                  <div class="col-xs-2">
                                                                              <label for="cep_prof" class="control-label">CEP</label>
                                                                              <div class="input-group">
                                                                                       <div class="input-group-addon">
                                                                                          <a href="#" data-toggle="tooltip" title="Digite o CEP para buscar automaticamente o endereço. Não informar pontos ou traços.">
                                                                                                <img src="{{ url('/images/help.png') }}" class="user-image" alt="Ajuda"  />
                                                                                           </a>
                                                                                        </div>

                                                                                        <input id="cep_prof" maxlength="8" name = "cep_prof" type="text" class="form-control" value="{{old('cep_prof')}}">
                                                                                </div>
                                                                  </div>

                                                                    <div class="col-xs-7">
                                                                            <label for="endereco_prof" class="control-label">Endereço</label>
                                                                            <input id="endereco_prof" maxlength="150" name = "endereco_prof" type="text" class="form-control" value="{{old('endereco_prof')}}">
                                                                    </div>

                                                                    <div class="col-xs-1">
                                                                            <label for="numero_prof" class="control-label">Número</label>
                                                                            <input id="numero_prof" maxlength="10" name = "numero_prof" type="text" class="form-control" value="{{old('numero_prof')}}">
                                                                    </div>

                                                             </div>

                                                            <div class="row">
                                                                  <div class="col-xs-5">
                                                                        <label for="bairro_prof" class="control-label">Bairro</label>
                                                                        <input id="bairro_prof" maxlength="50" name = "bairro_prof" type="text" class="form-control" value="{{old('bairro_prof')}}">
                                                                   </div>

                                                                  <div class="col-xs-5">
                                                                      <label for="complemento_prof" class="control-label">Complemento</label>
                                                                      <input id="complemento_prof" name = "complemento_prof" type="text" class="form-control" value="{{old('complemento_prof')}}">
                                                                  </div>
                                                             </div>

                                                            <div class="row">
                                                                    <div class="col-xs-5">
                                                                            <label for="cidade_prof" class="control-label">Cidade</label>
                                                                            <input id="cidade_prof" maxlength="60" name = "cidade_prof" type="text" class="form-control" value="{{old('cidade_prof')}}">
                                                                    </div>

                                                                    <div class="col-xs-1">
                                                                        <label for="estado_prof" class="control-label">Estado</label>
                                                                        <input id="estado_prof" maxlength="2" name = "estado_prof" type="text" class="form-control" value="{{old('estado_prof')}}">
                                                                    </div>

                                                                    <div class="col-xs-6"><!-- col-xs-6-->
                                                                        <label for="emailprofissional" class="control-label">Email</label>

                                                                        <div class="input-group{{ $errors->has('emailprofissional') ? ' has-error' : '' }}">
                                                                                   <div class="input-group-addon">
                                                                                    <i class="fa fa-envelope"></i>
                                                                                    </div>
                                                                                    <input id="emailprofissional" maxlength="150" name = "emailprofissional" type="text" class="form-control" value="{{old('emailprofissional')}}">

                                                                                     <!-- se houver erros na validacao do form request -->
                                                                                     @if ($errors->has('emailprofissional'))
                                                                                      <span class="help-block">
                                                                                          <strong>{{ $errors->first('emailprofissional') }}</strong>
                                                                                      </span>
                                                                                     @endif
                                                                        </div>
                                                                   </div><!-- end col-xs-6-->

                                                            </div>

                                                            <div class="row"><!-- row-->

                                                                   <div class="col-xs-4">
                                                                          @include('carregar_combos', array('dados'=>$cargos, 'titulo' =>'Cargo/Função', 'id_combo'=>'cargos', 'complemento'=>'', 'comparar'=>''))
                                                                   </div><!-- col-xs-5-->

                                                                   <div class="col-xs-4">
                                                                          @include('carregar_combos', array('dados'=>$ramos, 'titulo' =>'Ramos de Atividade', 'id_combo'=>'ramos', 'complemento'=>'', 'comparar'=>''))
                                                                   </div><!-- col-xs-5-->

                                                                   <div class="col-xs-4">
                                                                          @include('carregar_combos', array('dados'=>$profissoes, 'titulo' =>'Profissão', 'id_combo'=>'profissoes', 'complemento'=>'', 'comparar'=>''))
                                                                   </div><!-- col-xs-5-->

                                                            </div><!-- end row-->

                                                     </div><!-- end box-body-->

                                               </div><!-- end box-default-->

                                        </div>

                               </div><!-- end row-->

                          </div>
                        </div>
                      </div><!-- FIM TAB Dados Profissionais -->



                      <!-- TAB FORMAÇÃO-->
                      <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h5 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#tab3">
                                <span class="fa fa-mortar-board"></span> Formação
                              </a>
                            </h5>
                          </div>
                          <div id="tab3" class="panel-collapse collapse">
                            <div class="box-body">

                             <div  class="row">

                                     <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-body"><!-- box-body-->

                                                            <div class="row"><!-- row-->

                                                                  <input type="hidden" name="graus" class="minimal" value="">

                                                                   <div class="col-xs-4">
                                                                          @include('carregar_combos', array('dados'=>$graus, 'titulo' =>'Graus de Instrução', 'id_combo'=>'graus', 'complemento'=>'', 'comparar'=>''))
                                                                   </div><!-- col-xs-5-->

                                                                   <input type="hidden" name="formacoes[]" class="minimal" value="">
                                                                   <input type="hidden" name="idiomas[]" class="minimal" value="">

                                                                   <div class="col-xs-4">
                                                                          @include('carregar_combos', array('dados'=>$formacoes, 'titulo' =>'Áreas de Formação', 'id_combo'=>'formacoes[]', 'complemento'=>'multiple="multiple"', 'comparar'=>''))
                                                                   </div><!-- col-xs-5-->

                                                                   <div class="col-xs-4">
                                                                          @include('carregar_combos', array('dados'=>$idiomas, 'titulo' =>'Idiomas', 'id_combo'=>'idiomas[]', 'complemento'=>'multiple="multiple"', 'comparar'=>''))
                                                                   </div><!-- col-xs-5-->

                                                            </div><!-- end row-->

                                                     </div><!-- end box-body-->

                                               </div><!-- end box-default-->

                                     </div>

                               </div><!-- end row-->

                            </div>

                          </div>
                      </div><!-- FIM TAB FORMAÇÃO-->



                      <!-- TAB FAMILIAR-->
                      <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h5 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#tab4">
                                <span class="fa fa-users"></span> Familiar
                              </a>
                            </h5>
                          </div>
                          <div id="tab4" class="panel-collapse collapse">
                            <div class="box-body">

                               <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-default">
                                        <div class="box-body"><!-- box-body-->

                                                  <div class="col-xs-3">
                                                          @include('carregar_combos', array('dados'=>$estadoscivis, 'titulo' =>'Estado Civil', 'id_combo'=>'estadoscivis', 'complemento'=>'', 'comparar'=>''))
                                                  </div><!-- col-xs-->

                                        </div>
                                    </div>
                                   </div>
                               </div>


                               <div class="row">

                                       <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-header">
                                                            <h3 class="box-title">Conjuge</h3>
                                                    </div>

                                                    <div class="box-body"><!-- box-body-->

                                                          <div class="row"><!-- row entrada-->

                                                                   <div class="col-xs-5">
                                                                        @include('carregar_combos', array('dados'=>$familias, 'titulo' =>'Nome', 'id_combo'=>'conjuge', 'complemento'=>'', 'comparar'=>''))
                                                                   </div>

                                                                   <div class="col-xs-5">
                                                                      <label for="igrejacasamento" class="control-label">Igreja Casamento</label>
                                                                      <input id="igrejacasamento" name = "igrejacasamento" type="text" class="form-control" value="{{old('igrejacasamento')}}">
                                                                   </div>

                                                                   <div class="col-xs-2">
                                                                        <label id="datacasamento" for="datacasamento" class="control-label">Data Casamento</label>

                                                                        <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                                </div>

                                                                                <input id ="datacasamento" name = "datacasamento" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{old('databatismo')}}">
                                                                        </div>

                                                                   </div>

                                                          </div>

                                                          <div class="row">

                                                               <div class="col-xs-4">
                                                                        @include('carregar_combos', array('dados'=>$status, 'titulo' =>'Status', 'id_combo'=>'status_conjuge', 'complemento'=>'', 'comparar'=>''))
                                                              </div>

                                                              <div class="col-xs-4">
                                                                      @include('carregar_combos', array('dados'=>$profissoes, 'titulo' =>'Profissão', 'id_combo'=>'profissao_conjuge', 'complemento'=>'', 'comparar'=>''))
                                                              </div>

                                                                   <div class="col-xs-2">
                                                                        <label for="datanasc_conjuge" class="control-label">Data Nascimento</label>

                                                                        <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                                </div>

                                                                                <input id ="datanasc_conjuge" name = "datanasc_conjuge" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{old('databatismo')}}">
                                                                        </div>

                                                                   </div>

                                                                   <div class="col-xs-2">
                                                                        <label for="datacasamento" class="control-label">Data Falecimento</label>

                                                                        <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                                </div>

                                                                                <input id ="datafalecimento" name = "datafalecimento" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{old('datafalecimento')}}">
                                                                        </div>

                                                                   </div>

                                                                </div><!-- end row-->



                                                    </div>
                                              </div>
                                           </div>
                               </div><!-- end row-->

                               <div class="row">

                                       <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-header">
                                                            <h3 class="box-title">Filhos</h3>
                                                    </div>

                                                    <div class="box-body"><!-- box-body-->

                                                          <div class="row"><!-- row entrada-->

                                                                   <div class="col-xs-5">
                                                                        <label for="filhos" class="control-label">Nome</label>
                                                                        <select name="filhos" class="form-control select2" style="width: 100%;">
                                                                        <option  value="">(Selecionar)</option>
                                                                        @foreach($familias as $item)
                                                                              <option  value="{{$item->id}}">{{$item->razaosocial}}</option>
                                                                        @endforeach
                                                                        </select>
                                                                   </div>

                                                                   <div class="col-xs-4">
                                                                          <label for="opSexo" class="control-label">Sexo</label>

                                                                          <br/>
                                                                         <label>
                                                                              <input type="radio" name="opSexo" class="minimal" value="M">
                                                                              Masculino
                                                                         </label>

                                                                         <label>
                                                                              <input type="radio" name="opSexo" class="minimal" value="F">
                                                                              Feminino
                                                                         </label>
                                                                   </div>

                                                                   <div class="col-xs-2">
                                                                        <label id="datacasamento" for="datacasamento" class="control-label">Data Nascimento</label>

                                                                        <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                                </div>

                                                                                <input id ="datacasamento" name = "datacasamento" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{old('databatismo')}}">
                                                                        </div>

                                                                   </div>

                                                          </div>

                                                          <div class="row">

                                                               <div class="col-xs-5">
                                                                        <label for="status_conjuge" class="control-label">Status</label>
                                                                        <select name="status_conjuge" class="form-control select2" style="width: 100%;">
                                                                        <option  value="">(Selecionar)</option>
                                                                        @foreach($status as $item)
                                                                              <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                        @endforeach
                                                                        </select>
                                                              </div>

                                                              <div class="col-xs-4">
                                                                        <label for="profissao_conjuge" class="control-label">Estado Civil</label>
                                                                        <select name="profissao_conjuge" class="form-control select2" style="width: 100%;">
                                                                        <option  value="">(Selecionar)</option>
                                                                        @foreach($profissoes as $item)
                                                                              <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                        @endforeach
                                                                        </select>
                                                              </div>


                                                                   <div class="col-xs-2">
                                                                        <label for="datacasamento" class="control-label">Data Falecimento</label>

                                                                        <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                                </div>

                                                                                <input id ="datafalecimento" name = "datafalecimento" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{old('datafalecimento')}}">
                                                                        </div>

                                                                   </div>

                                                                </div><!-- end row-->
                                                    </div>
                                              </div>
                                           </div>
                               </div><!-- end row-->


                               <div class="row">

                                       <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-header">
                                                            <h3 class="box-title">Filiação</h3>
                                                    </div>

                                                    <div class="box-body"><!-- box-body-->

                                                          <div class="row"><!-- row pai-->

                                                                   <div class="col-xs-5">
                                                                        <label for="pai" class="control-label">Nome do Pai</label>
                                                                        <select name="pai" class="form-control select2" style="width: 100%;">
                                                                        <option  value="">(Selecionar)</option>
                                                                        @foreach($familias as $item)
                                                                              <option  value="{{$item->id}}">{{$item->razaosocial}}</option>
                                                                        @endforeach
                                                                        </select>
                                                                   </div>

                                                                   <div class="col-xs-5">
                                                                        <label for="status_pai" class="control-label">Status</label>
                                                                        <select name="status_pai" class="form-control select2" style="width: 100%;">
                                                                        <option  value="">(Selecionar)</option>
                                                                        @foreach($status as $item)
                                                                              <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                        @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-xs-2">
                                                                        <label for="datafalecimento_pai" class="control-label">Data Falecimento</label>

                                                                        <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                                </div>

                                                                                <input id ="datafalecimento_pai" name = "datafalecimento_pai" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{old('datafalecimento_pai')}}">
                                                                        </div>

                                                                   </div>

                                                          </div><!-- end row-->

                                                          <div class="row"><!-- row mãe-->

                                                                   <div class="col-xs-5">
                                                                        <label for="mae" class="control-label">Nome da Mãe</label>
                                                                        <select name="mae" class="form-control select2" style="width: 100%;">
                                                                        <option  value="">(Selecionar)</option>
                                                                        @foreach($familias as $item)
                                                                              <option  value="{{$item->id}}">{{$item->razaosocial}}</option>
                                                                        @endforeach
                                                                        </select>
                                                                   </div>

                                                                   <div class="col-xs-5">
                                                                        <label for="status_mae" class="control-label">Status</label>
                                                                        <select name="status_mae" class="form-control select2" style="width: 100%;">
                                                                        <option  value="">(Selecionar)</option>
                                                                        @foreach($status as $item)
                                                                              <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                        @endforeach
                                                                        </select>
                                                                    </div>

                                                                    <div class="col-xs-2">
                                                                        <label for="datafalecimento_mae" class="control-label">Data Falecimento</label>

                                                                        <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                                </div>

                                                                                <input id ="datafalecimento_mae" name = "datafalecimento_mae" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{old('datafalecimento_mae')}}">
                                                                        </div>

                                                                   </div>

                                                          </div><!-- end row-->

                                                    </div>
                                              </div>
                                           </div>
                               </div><!-- end row-->

                            </div>
                          </div>
                      </div><!-- FIM TAB FAMILIAR-->


                      <!-- TAB HISTORICO ECLESIASTICO-->
                      <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h5 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#tab5">
                                    <span class="fa fa-clone"></span> Histórico Eclesiástico
                              </a>
                            </h5>
                          </div>

                          <div id="tab5" class="panel-collapse collapse">

                            <div class="box-body">

                                <div  class="row">

                                     <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-header">
                                                            <h3 class="box-title">Igreja Anterior</h3>
                                                    </div>

                                                    <div class="box-body"><!-- box-body-->

                                                           <div class="row">
                                                                <div class="col-xs-5">
                                                                        <label for="igrejaanterior" class="control-label">Igreja</label>
                                                                        <input id="igrejaanterior" maxlength="150" name = "igrejaanterior" type="text" class="form-control" value="{{old('igrejaanterior')}}">
                                                                </div>


                                                                <div class="col-xs-2">
                                                                    <label for="foneigrejaanterior" class="control-label">Telefone</label>

                                                                    <div class="input-group">
                                                                           <div class="input-group-addon">
                                                                            <i class="fa fa-phone"></i>
                                                                            </div>

                                                                            <input id="foneigrejaanterior"  name = "foneigrejaanterior" type="text" class="form-control" value="{{old('foneigrejaanterior')}}"  data-inputmask='"mask": "(99) 9999-9999"' data-mask >

                                                                    </div>
                                                                </div>

                                                                <div class="col-xs-3">
                                                                          <label for="religioes" class="control-label">Religião Anterior</label>

                                                                          <select name="religioes" class="form-control select2" style="width: 100%;">
                                                                          <option  value="">(Selecione)</option>
                                                                          @foreach($religioes as $item)
                                                                                <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                </div><!-- col-xs-5-->


                                                           </div><!-- end row-->


                                                           <div class="row">

                                                                  <div class="col-xs-2">
                                                                              <label for="cep_igreja_anterior" class="control-label">CEP</label>
                                                                              <div class="input-group">
                                                                                       <div class="input-group-addon">
                                                                                          <a href="#" data-toggle="tooltip" title="Digite o CEP para buscar automaticamente o endereço. Não informar pontos ou traços.">
                                                                                                <img src="{{ url('/images/help.png') }}" class="user-image" alt="Ajuda"  />
                                                                                           </a>
                                                                                        </div>

                                                                                        <input id="cep_igreja_anterior" maxlength="8" name = "cep_igreja_anterior" type="text" class="form-control" value="{{old('cep_igreja_anterior')}}">
                                                                                </div>
                                                                  </div>

                                                                    <div class="col-xs-7">
                                                                            <label for="endereco_igreja_anterior" class="control-label">Endereço</label>
                                                                            <input id="endereco_igreja_anterior" maxlength="150" name = "endereco_igreja_anterior" type="text" class="form-control" value="{{old('endereco_igreja_anterior')}}">
                                                                    </div>

                                                                    <div class="col-xs-1">
                                                                            <label for="numero_igreja_anterior" class="control-label">Número</label>
                                                                            <input id="numero_igreja_anterior" maxlength="10" name = "numero_igreja_anterior" type="text" class="form-control" value="{{old('numero_igreja_anterior')}}">
                                                                    </div>

                                                            </div><!-- end row  -->

                                                            <div class="row">
                                                                  <div class="col-xs-5">
                                                                        <label for="bairro_igreja_anterior" class="control-label">Bairro</label>
                                                                        <input id="bairro_igreja_anterior" maxlength="50" name = "bairro_igreja_anterior" type="text" class="form-control" value="{{old('bairro_igreja_anterior')}}">
                                                                   </div>

                                                                  <div class="col-xs-5">
                                                                      <label for="complemento_igreja_anterior" class="control-label">Complemento</label>
                                                                      <input id="complemento_igreja_anterior" name = "complemento_igreja_anterior" type="text" class="form-control" value="{{old('complemento_igreja_anterior')}}">
                                                                  </div>
                                                            </div><!-- end row  -->

                                                            <div class="row">
                                                                    <div class="col-xs-5">
                                                                            <label for="cidade_igreja_anterior" class="control-label">Cidade</label>
                                                                            <input id="cidade_igreja_anterior" maxlength="60" name = "cidade_igreja_anterior" type="text" class="form-control" value="{{old('cidade_igreja_anterior')}}">
                                                                    </div>

                                                                    <div class="col-xs-1">
                                                                        <label for="estado_igreja_anterior" class="control-label">Estado</label>
                                                                        <input id="estado_igreja_anterior" maxlength="2" name = "estado_igreja_anterior" type="text" class="form-control" value="{{old('estado_igreja_anterior')}}">
                                                                    </div>

                                                            </div><!-- end row  -->


                                                     </div><!-- end box-body-->

                                               </div><!-- end box-default-->

                                        </div>

                               </div><!-- end row-->


                               <div  class="row">

                                     <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-body"><!-- box-body-->

                                                            <div class="row">

                                                                <div class="col-xs-2">
                                                                        <label id="databatismo" for="datanasc" class="control-label">Data Batismo</label>

                                                                        <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                                </div>

                                                                                <input id ="databatismo" name = "databatismo" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{old('databatismo')}}">
                                                                        </div>

                                                               </div>

                                                                <div class="col-xs-5">
                                                                        <label for="igreja_batismo" class="control-label">Igreja</label>
                                                                        <input id="igreja_batismo" maxlength="150" name = "igreja_batismo" type="text" class="form-control" value="{{old('igreja_batismo')}}">
                                                                </div>

                                                                <div class="col-xs-4">
                                                                        <label for="celebrador" class="control-label">Celebrador</label>
                                                                        <input id="celebrador" maxlength="10" name = "celebrador" type="text" class="form-control" value="{{old('celebrador')}}">
                                                                </div>

                                                           </div><!-- end row -->

                                                    </div>
                                              </div>
                                     </div>
                               </div>

                               <div  class="row">

                                     <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-header">
                                                            <h3 class="box-title">Movimento de Membro</h3>
                                                    </div>

                                                    <div class="box-body"><!-- box-body-->

                                                          <div class="row"><!-- row entrada-->

                                                                <div class="col-xs-2">
                                                                        <label id="dataentrada" for="datanasc" class="control-label">Data Entrada</label>

                                                                        <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                                </div>

                                                                                <input id ="dataentrada" name = "dataentrada" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{old('databatismo')}}">
                                                                        </div>

                                                               </div>

                                                                <div class="col-xs-4">
                                                                          <label for="motivoentrada" class="control-label">Motivo Entrada</label>

                                                                          <select name="motivoentrada" class="form-control select2" style="width: 100%;">
                                                                          <option  value="">(Selecione)</option>
                                                                          @foreach($motivos as $item)
                                                                                <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                </div><!-- col-xs-5-->

                                                                <div class="col-xs-4">
                                                                        <label for="ataentrada" class="control-label">Registrado em Ata n.:</label>
                                                                        <input id="ataentrada" maxlength="10" name = "ataentrada" type="text" class="form-control" value="{{old('ata_entrada')}}">
                                                                </div>

                                                           </div><!-- end row -->

                                                          <div class="row"><!-- row saida-->

                                                                <div class="col-xs-2">
                                                                        <label id="datasaida" for="datanasc" class="control-label">Data Saída</label>

                                                                        <div class="input-group">
                                                                               <div class="input-group-addon">
                                                                                <i class="fa fa-calendar"></i>
                                                                                </div>

                                                                                <input id ="datasaida" name = "datasaida" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{old('databatismo')}}">
                                                                        </div>

                                                               </div>

                                                                <div class="col-xs-4">
                                                                          <label for="motivosaida" class="control-label">Motivo Saída</label>

                                                                          <select name="motivosaida" class="form-control select2" style="width: 100%;">
                                                                          <option  value="">(Selecione)</option>
                                                                          @foreach($motivos as $item)
                                                                                <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>
                                                                </div><!-- col-xs-5-->

                                                                <div class="col-xs-4">
                                                                        <label for="atasaida" class="control-label">Registrado em Ata n.:</label>
                                                                        <input id="atasaida" maxlength="10" name = "atasaida" type="text" class="form-control" value="{{old('ata_entrada')}}">
                                                                </div>

                                                           </div><!-- end row -->

                                                          <div class="row">
                                                                <div class="col-xs-10">
                                                                        <label for="observacoes_hist" class="control-label">Observação</label>
                                                                        <input id="observacoes_hist" name = "observacoes_hist" type="text" class="form-control" value="{{old('observacoes')}}">
                                                                </div>
                                                          </div><!--end row-->
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>

                               <!-- fim aqui-->



                            </div>
                          </div>
                      </div><!-- FIM TAB HISTORICO ECLESIASTICO-->


                      <!-- TAB Habilidades, Dons e Cursos-->
                      <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h5 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#tab6">
                                <span class="fa fa-magic"></span> Dons e Habilidades
                              </a>
                            </h5>
                          </div>
                          <div id="tab6" class="panel-collapse collapse">
                            <div class="box-body">


                                   <div class="col-md-12">

                                              <div class="box box-default">

                                                    <div class="box-body"><!-- box-body-->

                                                            <div class="row"><!-- row-->

                                                                  <div class="col-xs-4">
                                                                        <label for="prefere_trabalhar_com" class="control-label">Prefere trabalhar com :</label>

                                                                         <select name="prefere_trabalhar_com" class="form-control select2" style="width: 100%;">
                                                                          <option  value="">(Selecionar)</option>
                                                                                <option  value="P">Pessoas</option>
                                                                                <option  value="T">Tarefas</option>
                                                                          </select>
                                                                  </div><!-- end col-xs-->

                                                                  <div class="col-xs-4">

                                                                        <label for="considera_se" class="control-label">Considera-se :</label>

                                                                          <select name="considera_se" class="form-control select2" style="width: 100%;">
                                                                          <option  value="">(Selecionar)</option>
                                                                                <option  value="M">Muito Estruturado</option>
                                                                                <option  value="P">Pouco Estruturado</option>
                                                                                <option  value="E">Estruturado</option>
                                                                          </select>

                                                                  </div><!-- end col-xs-->

                                                            </div><!-- end row-->

                                                            <input type="hidden" name="dons[]" class="minimal" value="">
                                                            <input type="hidden" name="habilidades[]" class="minimal" value="">


                                                            <div class="row"><!-- row-->

                                                                   <div class="col-xs-4">
                                                                          <label for="disponibilidades" class="control-label">Disponibilidade de Tempo</label>

                                                                          <select name="disponibilidades" class="form-control select2" style="width: 100%;">
                                                                          <option  value="">(Selecionar)</option>
                                                                          @foreach($disponibilidades as $item)
                                                                                <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>

                                                                   </div><!-- col-xs-5-->

                                                                   <div class="col-xs-4">
                                                                          <label for="dons[]" class="control-label">Dons Espirituais</label>

                                                                          <select name="dons[]" multiple="multiple" data-placeholder="Um ou Vários" class="form-control select2" style="width: 100%;">
                                                                          <option  value="">(Um ou Vários)</option>
                                                                          @foreach($dons as $item)
                                                                                <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>

                                                                   </div><!-- col-xs-5-->

                                                                   <div class="col-xs-4">
                                                                          <label for="habilidades[]" class="control-label">Habilidades</label>

                                                                          <select name="habilidades[]" multiple="multiple" data-placeholder="Um ou Vários" class="form-control select2" style="width: 100%;">
                                                                          <option  value="">(Um ou Vários)</option>
                                                                          @foreach($habilidades as $item)
                                                                                <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                          @endforeach
                                                                          </select>

                                                                   </div><!-- col-xs-5-->

                                                            </div><!-- end row-->

                                                     </div><!-- end box-body-->

                                               </div><!-- end box-default-->

                                     </div>

                            </div>
                          </div>
                      </div><!-- FIM TAB Habilidades, Dons e Cursos-->

                      <!-- TAB Envolvimento Ministerial-->
                      <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h5 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#tab7">
                                <span class="fa fa-bullseye"></span> Envolvimento Ministerial
                              </a>
                            </h5>
                          </div>
                          <div id="tab7" class="panel-collapse collapse">
                            <div class="box-body">

                                     <div  class="row">

                                             <div class="col-md-12">

                                                      <div class="box box-default">

                                                            <div class="box-body"><!-- box-body-->

                                                                    <div class="row"><!-- row-->

                                                                          <input type="hidden" name="ministerios[]" class="minimal" value="">
                                                                          <input type="hidden" name="atividades[]" class="minimal" value="">

                                                                           <div class="col-xs-6">
                                                                                  <label for="ministerios[]" class="control-label">Ministério</label>

                                                                                  <select name="ministerios[]" multiple="multiple" data-placeholder="Um ou Vários" class="form-control select2" style="width: 100%;">
                                                                                  <option  value="">(Um ou Vários)</option>
                                                                                  @foreach($ministerios as $item)
                                                                                        <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                  @endforeach
                                                                                  </select>

                                                                           </div><!-- col-xs-5-->


                                                                           <div class="col-xs-6">
                                                                                  <label for="atividades[]" class="control-label">Atividade</label>

                                                                                  <select name="atividades[]" multiple="multiple" data-placeholder="Um ou Vários" class="form-control select2" style="width: 100%;">
                                                                                  <option  value="">(Selecionar)</option>
                                                                                  @foreach($atividades as $item)
                                                                                        <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                  @endforeach
                                                                                  </select>

                                                                           </div><!-- col-xs-5-->

                                                                    </div><!-- end row-->

                                                             </div><!-- end box-body-->

                                                       </div><!-- end box-default-->

                                             </div>

                                     </div><!-- end row-->


                            </div>
                          </div>
                      </div><!-- FIM TAB Envolvimento Ministerial -->

                      <!-- TAB Histórico de Movimentações -->
                      <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h5 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#tab8">
                                <span class="fa fa-exchange"></span> Histórico de Movimentações
                              </a>
                            </h5>
                          </div>
                          <div id="tab8" class="panel-collapse collapse">
                            <div class="box-body">

                            </div>
                          </div>
                      </div><!-- FIM TAB Histórico de Movimentações -->

                      <!-- TAB Cursos-->
                      <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h5 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#tab9">
                                <span class="fa fa-trophy"></span> Cursos
                              </a>
                            </h5>
                          </div>
                          <div id="tab9" class="panel-collapse collapse">
                            <div class="box-body">
                                 Em Breve
                            </div>
                          </div>
                      </div><!-- FIM TAB Cursos -->

                      <!-- TAB Células -->
                      <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h5 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#tab10">
                                <span class="fa fa-street-view"></span> Células
                              </a>
                            </h5>
                          </div>
                          <div id="tab10" class="panel-collapse collapse">
                            <div class="box-body">
                                Em Breve
                            </div>
                          </div>
                      </div><!-- FIM TAB Células-->



                    </div><!-- end box-group -->



                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
         </div>


   </div><!-- FIM - DADOS ECLISIASTICOS-->