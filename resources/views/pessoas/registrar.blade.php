@extends('principal.master')

@section('content')

{{ \Session::put('titulo', $interface->nome) }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'pessoas') }}
{{ \Session::put('id_pagina', '28') }}

<div class = 'row'>

    <div class="col-md-12">

        <form name="form_endereco" method="get" action=".">
        </form>

        <form name ="form_principal" method = 'POST' class="form-horizontal"  enctype="multipart/form-data" action = {{ url('/' . \Session::get('route') . '/gravar')}}>

        {!! csrf_field() !!}

          <div>

                 <div class="nav-tabs-custom"> <!--anterior box-body-->

                        <!-- Guarda ID tipo pessoa-->
                        <input  name="tipos_pessoas_id" type="hidden"  value="{{ $interface->id }}" />

                         <!-- Nav tabs -->
                          <ul class="nav nav-tabs" role="tablist">
                                  <li class="active">
                                      <a href="#home" role="tab" data-toggle="tab">
                                          <icon class="fa fa-user"></icon> Dados Cadastrais
                                      </a>
                                  </li>
                                  <li>
                                        <a href="#panel_endereco" role="tab" data-toggle="tab">
                                            <i class="fa fa-map-marker"></i> Endereço
                                        </a>
                                  </li>

                                    <li>
                                        <a href="#financ" role="tab" data-toggle="tab">
                                            <i class="fa fa-money"></i> Dados Financeiros
                                        </a>
                                   </li>

                                   <li>
                                        <a href="#obs" role="tab" data-toggle="tab">
                                            <i class="fa fa-edit"></i> Observações
                                        </a>
                                   </li>

                                   @if ($interface->membro)
                                   <li>
                                        <a href="#eclesia" role="tab" data-toggle="tab">
                                            <i class="fa fa-child"></i> Dados Eclesiásticos
                                        </a>
                                   </li>
                                   @endif

                          </ul>

                              <!-- Tab panes -->
                              <!-- DADOS CADASTRAIS-->
                           <div class="tab-content">

                                  <div class="tab-pane fade active in" id="home">

                                        <div class="row">
                                                <div class="col-xs-3">

                                                    <label for="opStatus" class="control-label">Status :</label>
                                                    <br/>

                                                         <label>
                                                              <input type="radio" name="opStatus" class="minimal" checked>
                                                              Ativo
                                                         </label>

                                                         <label>
                                                              <input type="radio" name="opStatus" class="minimal">
                                                              Inativo
                                                         </label>

                                                </div>

                                                <div class="col-xs-3">

                                                      <label for="opPessoa" class="control-label">Tipo Pessoa :</label>
                                                      <br/>

                                                        @if ($interface->fisica)
                                                         <label>
                                                              <input type="radio" id="opFisica" name="opPessoa" value="F" class="opFisica" {{ ( ($interface->fisica==true && $interface->juridica==false) ? 'checked' : '') }}>
                                                              Física
                                                         </label>
                                                         @endif

                                                         @if ($interface->juridica)
                                                         <label>
                                                              <input type="radio" id="opJuridica" name="opPessoa" value="J" class="opJuridica" {{ ( ($interface->fisica==false && $interface->juridica==true) ? 'checked' : '') }}>
                                                              Jurídica
                                                         </label>
                                                         @endif

                                                </div>


                                             <div class="col-xs-5">
                                                    <label for="grupo" class="control-label">Grupo</label>

                                                    <select name="grupo" class="form-control select2" style="width: 100%;">
                                                    <option  value="">(Selecione um Grupo)</option>
                                                    @foreach($dados as $item)
                                                          <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                    @endforeach
                                                    </select>

                                                    <!-- se houver erros na validacao do form request -->
                                                       @if ($errors->has('grupo'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('grupo') }}</strong>
                                                        </span>
                                                       @endif

                                             </div><!-- col-xs-5-->

                                        </div>

                                        <div class="row{{ $errors->has('razaosocial') ? ' has-error' : '' }}">
                                                <div class="col-xs-6">

                                                      <label for="razaosocial" class="control-label">{{ $interface->fisica==true ? 'Nome' : 'Razão Social'}}</label>

                                                      <input id="razaosocial" maxlength="150"  placeholder="Campo Obrigatório" name = "razaosocial" type="text" class="form-control" value="{{ old('razaosocial') }}">

                                                         <!-- se houver erros na validacao do form request -->
                                                         @if ($errors->has('razaosocial'))
                                                          <span class="help-block">
                                                              <strong>{{ $errors->first('razaosocial') }}</strong>
                                                          </span>
                                                         @endif

                                                </div>

                                               <div class="col-xs-6">
                                                    <label for="nomefantasia" class="control-label">{{ $interface->fisica==true ? 'Nome Abrev.' : 'Nome Fantasia'}}</label>
                                                    <input id="nomefantasia" maxlength="100" name = "nomefantasia" type="text" class="form-control" value="{{old('nomefantasia')}}">
                                               </div>

                                        </div>

                                        <input id="cnpj" type="hidden" name="cnpj" value="">
                                        <input id="cpf"  type="hidden" name="cpf"  value="">

                                        <div class="row">

                                                    <div class="col-xs-2">
                                                           <label id="lb_cnpj_cpf" for="cnpj_cpf" class="control-label">{{ $interface->fisica==true ? 'CPF' : 'CNPJ'}}</label>

                                                           <input id="cnpj" style='{{ $interface->fisica==true ? 'display:none' : '' }}' data-inputmask='"mask": "99.999.999/9999-99"' data-mask name="cnpj" type="text" class="cnpj form-control" value="{{old('cnpj_cpf')}}">
                                                           <input id="cpf"  style='{{ $interface->juridica==true ? 'display:none' : '' }}' data-inputmask='"mask": "999.999.999-99"' data-mask name="cpf" type="text" class="cpf form-control" value="{{old('cnpj_cpf')}}">

                                                    </div>

                                                    <div class="col-xs-2">
                                                         <label id="lb_inscricaoestadual_rg" for="inscricaoestadual_rg" class="control-label">{{ $interface->fisica==true ? 'RG' : 'Insc. Estadual'}}</label>
                                                         <input id="inscricaoestadual_rg"  maxlength="15" name = "inscricaoestadual_rg" type="text" class="form-control" value="{{ old('inscricaoestadual_rg') }}">
                                                    </div>

                                                    <div class="col-xs-2">
                                                              <label id="lb_datanasc" for="datanasc" class="control-label">{{ $interface->fisica==true ? 'Data Nasc.' : 'Data Fundação'}}</label>

                                                              <div class="input-group">
                                                                     <div class="input-group-addon">
                                                                      <i class="fa fa-calendar"></i>
                                                                      </div>

                                                                      <input id ="datanasc" name = "datanasc" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{old('datanasc')}}">
                                                              </div>

                                                     </div>

                                       </div>

                                       <div class="row">
                                                <div class="col-xs-2">
                                                    <label for="foneprincipal" class="control-label">Fone Principal</label>

                                                    <div class="input-group{{ $errors->has('foneprincipal') ? ' has-error' : '' }}">
                                                           <div class="input-group-addon">
                                                            <i class="fa fa-phone"></i>
                                                            </div>

                                                            <input id="foneprincipal" placeholder="Campo Obrigatório" name = "foneprincipal" type="text" class="form-control" value="{{old('foneprincipal')}}"  data-inputmask='"mask": "(99) 9999-9999"' data-mask >

                                                             <!-- se houver erros na validacao do form request -->
                                                             @if ($errors->has('foneprincipal'))
                                                              <span class="help-block">
                                                                  <strong>{{ $errors->first('foneprincipal') }}</strong>
                                                              </span>
                                                             @endif

                                                    </div>

                                              </div>

                                                 <div class="col-xs-2">
                                                        <label for="fonesecundario" class="control-label">Fone Secundário</label>

                                                        <div class="input-group">
                                                               <div class="input-group-addon">
                                                                <i class="fa fa-phone"></i>
                                                                </div>

                                                                <input id="fonesecundario" name = "fonesecundario" type="text" class="form-control" data-inputmask='"mask": "(99) 9999-9999"' data-mask  value="{{old('fonesecundario')}}">
                                                        </div>

                                                 </div>

                                                <div class="col-xs-2">
                                                        <label for="fonerecado" class="control-label">Fone Recado</label>

                                                        <div class="input-group">
                                                               <div class="input-group-addon">
                                                                <i class="fa fa-phone"></i>
                                                                </div>

                                                                <input id="fonerecado" name = "fonerecado" type="text" class="form-control" data-inputmask='"mask": "(99) 9999-9999"' data-mask  value="{{old('fonerecado')}}">
                                                        </div>

                                                 </div>

                                                <div class="col-xs-2">
                                                    <label for="celular" class="control-label">Celular</label>

                                                    <div class="input-group">
                                                               <div class="input-group-addon">
                                                                <i class="fa fa-phone"></i>
                                                                </div>
                                                                <input id="celular" data-inputmask='"mask": "(99) 9999-9999"' data-mask  name = "celular" type="text" class="form-control" value="{{old('celular')}}">
                                                    </div>
                                                </div>

                                         </div>


                                        <div class="row">
                                                  <div class="col-xs-6">
                                                        <label for="emailprincipal" class="control-label">Email</label>

                                                        <div class="input-group{{ $errors->has('emailprincipal') ? ' has-error' : '' }}">
                                                                   <div class="input-group-addon">
                                                                    <i class="fa fa-envelope"></i>
                                                                    </div>
                                                                    <input id="emailprincipal" maxlength="150" name = "emailprincipal" type="text" class="form-control" value="{{old('emailprincipal')}}">

                                                                     <!-- se houver erros na validacao do form request -->
                                                                     @if ($errors->has('emailprincipal'))
                                                                      <span class="help-block">
                                                                          <strong>{{ $errors->first('emailprincipal') }}</strong>
                                                                      </span>
                                                                     @endif

                                                        </div>

                                                   </div>

                                                    <div class="col-xs-6">
                                                            <label for="emailsecundario" class="control-label">Email Secundário</label>

                                                             <div class="input-group{{ $errors->has('emailsecundario') ? ' has-error' : '' }}">
                                                                   <div class="input-group-addon">
                                                                         <i class="fa fa-envelope"></i>
                                                                    </div>
                                                                    <input id="emailsecundario" maxlength="150" name = "emailsecundario" type="text" class="form-control" value="{{old('emailsecundario')}}">

                                                                     <!-- se houver erros na validacao do form request -->
                                                                     @if ($errors->has('emailsecundario'))
                                                                      <span class="help-block">
                                                                             <strong>{{ $errors->first('emailsecundario') }}</strong>
                                                                      </span>
                                                                     @endif
                                                            </div>

                                                    </div>


                                        </div>

                                        <div class="row">
                                                    <div class="col-xs-6">
                                                        <label for="website" class="control-label">Website</label>
                                                        <input id="website" maxlength="255" name = "website" type="text" class="form-control" value="{{old('website')}}">
                                                    </div>

                                                    <div class="col-xs-5">
                                                            <label for="caminhologo" class="control-label">Foto</label>
                                                            <input type="file" id="caminhologo" maxlength="255" name = "caminhologo" >
                                                    </div>
                                        </div>


                                  </div> <!-- FIM DADOS CADASTRAIS-->


                                 <!-- ENDEREÇO-->
                                 <div class="tab-pane fade" id="panel_endereco">

                                      <div class="row">

                                           <div class="col-xs-2">
                                                      <label for="cep" class="control-label">CEP</label>
                                                      <div class="input-group">
                                                               <div class="input-group-addon">
                                                                  <a href="#" data-toggle="tooltip" title="Digite o CEP para buscar automaticamente o endereço. Não informar pontos ou traços.">
                                                                        <img src="{{ url('/images/help.png') }}" class="user-image" alt="Ajuda"  />
                                                                   </a>
                                                                </div>

                                                                <input id="cep" maxlength="8" name = "cep" type="text" class="form-control" value="{{old('cep')}}">
                                                        </div>
                                           </div>

                                            <div class="col-xs-7">
                                                    <label for="endereco" class="control-label">Endereço</label>
                                                    <input id="endereco" maxlength="150" name = "endereco" type="text" class="form-control" value="{{old('endereco')}}">
                                            </div>

                                            <div class="col-xs-1">
                                                    <label for="numero" class="control-label">Número</label>
                                                    <input id="numero" maxlength="10" name = "numero" type="text" class="form-control" value="{{old('numero')}}">
                                            </div>
                                      </div>

                                      <div class="row">
                                            <div class="col-xs-5">
                                                  <label for="bairro" class="control-label">Bairro</label>
                                                  <input id="bairro" maxlength="50" name = "bairro" type="text" class="form-control" value="{{old('bairro')}}">
                                             </div>

                                            <div class="col-xs-5">
                                                <label for="complemento" class="control-label">Complemento</label>
                                                <input id="complemento" name = "complemento" type="text" class="form-control" value="{{old('complemento')}}">
                                            </div>

                                      </div>

                                    <div class="row">
                                            <div class="col-xs-5">
                                                    <label for="cidade" class="control-label">Cidade</label>
                                                    <input id="cidade" maxlength="60" name = "cidade" type="text" class="form-control" value="{{old('cidade')}}">
                                            </div>

                                            <div class="col-xs-1">
                                                <label for="estado" class="control-label">Estado</label>
                                                <input id="estado" maxlength="2" name = "estado" type="text" class="form-control" value="{{old('estado')}}">
                                            </div>
                                    </div>



                                </div><!-- FIM TAB ENDERECO-->


                                <!-- TAB FINANCEIRO-->
                                <div class="tab-pane" id="financ">
                                    <br/>

                                      <div class="row">
                                            <div class="col-xs-8">
                                                  <label for="banco" class="control-label">Banco Emissão boleto</label>

                                                  <select name="banco" class="form-control select2" style="width: 100%;">
                                                  <option  value="">(Selecione um Banco)</option>
                                                  @foreach($bancos as $item)
                                                        <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                  @endforeach
                                                  </select>

                                            </div>
                                      </div>

                                      <div class="row">
                                                <div class="col-xs-5">
                                                            <p></p>
                                                            <label for="endcobranca">
                                                                  <input  id="endcobranca" name="endcobranca" type="checkbox" class="minimal-red" value="1" />
                                                                  Endereço de Cobrança diferente do principal
                                                            </label>
                                                </div>
                                      </div>

                                      <div id="exibir_endereco_cobranca" style="display: none">
                                              <div class="row">

                                                      <div class="col-xs-2">

                                                          <label for="cep_cobranca" class="control-label">CEP</label>
                                                          <div class="input-group">
                                                                   <div class="input-group-addon">
                                                                      <a href="#" data-toggle="tooltip" title="Digite o CEP para buscar automaticamente o endereço. Não informar pontos ou traços.">
                                                                            <img src="{{ url('/images/help.png') }}" class="user-image" alt="Ajuda"  />
                                                                       </a>
                                                                    </div>

                                                                    <input id="cep_cobranca" maxlength="8" name = "cep_cobranca" type="text" class="form-control" value="{{old('cep')}}">
                                                            </div>

                                                      </div>

                                                      <div class="col-xs-7">
                                                              <label for="endereco_cobranca" class="control-label">Endereço para Cobrança</label>
                                                              <input id="endereco_cobranca" maxlength="150" name = "endereco_cobranca" type="text" class="form-control" value="{{old('endereco')}}">
                                                      </div>

                                                      <div class="col-xs-1">
                                                              <label for="numero_cobranca" class="control-label">Número</label>
                                                              <input id="numero_cobranca" maxlength="10" name = "numero_cobranca" type="text" class="form-control" value="{{old('numero')}}">
                                                      </div>
                                              </div>

                                              <div class="row">
                                                      <div class="col-xs-5">
                                                            <label for="bairro_cobranca" class="control-label">Bairro</label>
                                                            <input id="bairro_cobranca" maxlength="50" name = "bairro_cobranca" type="text" class="form-control" value="{{old('bairro')}}">
                                                       </div>

                                                      <div class="col-xs-5">
                                                          <label for="complemento_cobranca" class="control-label">Complemento</label>
                                                          <input id="complemento_cobranca" name = "complemento_cobranca" type="text" class="form-control" value="{{old('complemento')}}">
                                                      </div>


                                              </div>

                                              <div class="row">
                                                      <div class="col-xs-5">
                                                              <label for="cidade_cobranca" class="control-label">Cidade</label>
                                                              <input id="cidade_cobranca" maxlength="60" name = "cidade_cobranca" type="text" class="form-control" value="{{old('cidade')}}">
                                                      </div>

                                                      <div class="col-xs-2">
                                                          <label for="estado_cobranca" class="control-label">Estado</label>
                                                          <input id="estado_cobranca" maxlength="2" name = "estado_cobranca" type="text" class="form-control" value="{{old('estado')}}">
                                                      </div>
                                              </div>
                                       </div>

                                </div><!--  FIM TAB FINANCEIRO-->


                                <!-- TAB OBSERVACOES -->
                                <div class="tab-pane fade" id="obs">

                                        <div class="row">
                                                <div class="col-xs-10">

                                                    <label for="obs" class="control-label">Observações</label>
                                                    <textarea name="obs" class="form-control" rows="6" placeholder="Digite o texto..." value="{{old('obs')}}"></textarea>

                                                </div>
                                         </div>
                                </div><!-- FIM - TAB OBSERVACOES -->


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


                                                            <div class="row">

                                                                    <div class="col-md-12">
                                                                            <div class="box box-default">
                                                                                <div class="box-body">

                                                                                      <div class="col-xs-12">
                                                                                          <label for="familia" class="control-label">Família</label>

                                                                                          <select name="familia" class="form-control select2" style="width: 100%;">
                                                                                          <option  value="">(Selecionar)</option>
                                                                                          @foreach($familias as $item)
                                                                                                <option  value="{{$item->id}}">{{$item->razaosocial}}</option>
                                                                                          @endforeach
                                                                                          </select>

                                                                                      </div><!-- col-xs-5-->


                                                                                       <div class="col-xs-6">
                                                                                              <label for="status" class="control-label">Status</label>

                                                                                              <select name="status" class="form-control select2" style="width: 100%;">
                                                                                              <option  value="">(Selecionar)</option>
                                                                                              @foreach($status as $item)
                                                                                                    <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                              @endforeach
                                                                                              </select>

                                                                                       </div><!-- col-xs-5-->

                                                                                       <div class="col-xs-6">
                                                                                              <label for="situacoes" class="control-label">Situações</label>

                                                                                              <select name="situacoes" class="form-control select2" multiple="multiple" style="width: 100%;">
                                                                                              <option  value="">(Selecionar)</option>
                                                                                              @foreach($situacoes as $item)
                                                                                                    <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                              @endforeach
                                                                                              </select>

                                                                                       </div><!-- col-xs-5-->
                                                                               </div>
                                                                            </div>
                                                                      </div>

                                                            </div><!-- end row-->


                                                            <div class="row">


                                                                     <div class="col-md-6">
                                                                            <div class="box box-default">
                                                                                <div class="box-body">

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

                                                                                    <div class="col-xs-4">
                                                                                          <label for="opDoadorSangue" class="control-label">Doador Sangue</label>

                                                                                          <br/>
                                                                                         <label>
                                                                                              <input type="radio" name="opDoadorSangue" class="minimal" value="true">
                                                                                              Sim
                                                                                         </label>

                                                                                         <label>
                                                                                              <input type="radio" name="opDoadorSangue" class="minimal" value="false">
                                                                                              Não
                                                                                         </label>

                                                                                    </div>

                                                                                    <div class="col-xs-4">
                                                                                            <label for="opDoadorOrgaos" class="control-label">Doador Orgãos</label>

                                                                                            <br/>
                                                                                           <label>
                                                                                                <input type="radio" name="opDoadorOrgaos" class="minimal" value="true">
                                                                                                Sim
                                                                                           </label>

                                                                                           <label>
                                                                                                <input type="radio" name="opDoadorOrgaos" class="minimal" value="false">
                                                                                                Não
                                                                                           </label>
                                                                                    </div>

                                                                                 </div>
                                                                            </div>
                                                                      </div>

                                                                       <div class="col-md-6">
                                                                              <div class="box box-default">
                                                                                    <div class="box-body">

                                                                                             <div class="col-xs-3">
                                                                                                      <label for="grpsangue" class="control-label">Grupo Sanguínio</label>
                                                                                                      <input id="grpsangue" name = "grpsangue" type="text" class="form-control"  value="{{old('gruposanguinio')}}">
                                                                                              </div>

                                                                                              <div class="col-xs-7">

                                                                                                      <label for="ck_necessidades">Possui Necessidades Especiais ?</label>
                                                                                                      <div class="input-group">
                                                                                                           <div class="input-group-addon">
                                                                                                                    <input  id="ck_necessidades" name="ck_necessidades" type="checkbox" class="minimal-red" value="true" />
                                                                                                            </div>

                                                                                                            <input id="necessidades" name = "necessidades" type="text" class="form-control" placeholder="Descrição Tipo Necessidade"  value="{{old('necessidades')}}">
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
                                                                                                      <input id="naturalidade" name = "naturalidade" type="text" class="form-control"  value="{{old('naturalidade')}}">
                                                                                            </div>

                                                                                            <div class="col-xs-2">
                                                                                                      <label for="ufnaturalidade" class="control-label">UF</label>
                                                                                                      <input id="ufnaturalidade" name = "naturalidade" type="text" class="form-control"  value="{{old('ufnaturalidade')}}">
                                                                                            </div>

                                                                                              <div class="col-xs-3">
                                                                                                        <label for="nacionalidade" class="control-label">Nacionalidade</label>
                                                                                                        <input id="nacionalidade" name = "nacionalidade" type="text" class="form-control"  value="{{old('nacionalidade')}}">
                                                                                              </div>

                                                                                              <div class="col-xs-3">
                                                                                                    <label for="lingua" class="control-label">Lingua Oficial</label>

                                                                                                      <select name="lingua" class="form-control select2" style="width: 100%;">
                                                                                                      <option  value="">(Selecione)</option>
                                                                                                      @foreach($idiomas as $item)
                                                                                                            <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                                      @endforeach
                                                                                                      </select>
                                                                                              </div>


                                                                                      </div>

                                                                                </div>
                                                                          </div>


                                                                          <div class="col-md-6">

                                                                                <div class="box box-default">

                                                                                      <div class="box-body">

                                                                                             <div class="col-xs-7">
                                                                                                     <label for="igreja" class="control-label">Igreja</label>

                                                                                                     <select name="igreja" class="form-control select2" style="width: 100%;">
                                                                                                     <option  value="">(Selecione)</option>
                                                                                                     @foreach($igrejas as $item)
                                                                                                           <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                                     @endforeach
                                                                                                     </select>
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
                                                                                                      <input id="facebook" name = "facebook" type="text" class="form-control"  value="{{old('facebook')}}">
                                                                                            </div>

                                                                                            <div class="col-xs-10">
                                                                                                      <label for="google" class="control-label">Google+</label>
                                                                                                      <input id="google" name = "google" type="text" class="form-control"  value="{{old('google')}}">
                                                                                            </div>

                                                                                              <div class="col-xs-10">
                                                                                                        <label for="instagram" class="control-label">Instagram</label>
                                                                                                        <input id="instagram" name = "instagram" type="text" class="form-control"  value="{{old('instagram')}}">
                                                                                              </div>

                                                                                              <div class="col-xs-10">
                                                                                                        <label for="linkedin" class="control-label">LinkedIn</label>
                                                                                                        <input id="linkedin" name = "linkedin" type="text" class="form-control"  value="{{old('linkedin')}}">
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
                                                                                                    <label for="endereco" class="control-label">Empresa</label>
                                                                                                    <input id="endereco" maxlength="150" name = "endereco" type="text" class="form-control" value="{{old('endereco')}}">
                                                                                            </div>
                                                                                       </div>

                                                                                       <div class="row">

                                                                                              <div class="col-xs-2">
                                                                                                          <label for="cep" class="control-label">CEP</label>
                                                                                                          <div class="input-group">
                                                                                                                   <div class="input-group-addon">
                                                                                                                      <a href="#" data-toggle="tooltip" title="Digite o CEP para buscar automaticamente o endereço. Não informar pontos ou traços.">
                                                                                                                            <img src="{{ url('/images/help.png') }}" class="user-image" alt="Ajuda"  />
                                                                                                                       </a>
                                                                                                                    </div>

                                                                                                                    <input id="cep" maxlength="8" name = "cep" type="text" class="form-control" value="{{old('cep')}}">
                                                                                                            </div>
                                                                                              </div>

                                                                                                <div class="col-xs-7">
                                                                                                        <label for="endereco" class="control-label">Endereço</label>
                                                                                                        <input id="endereco" maxlength="150" name = "endereco" type="text" class="form-control" value="{{old('endereco')}}">
                                                                                                </div>

                                                                                                <div class="col-xs-1">
                                                                                                        <label for="numero" class="control-label">Número</label>
                                                                                                        <input id="numero" maxlength="10" name = "numero" type="text" class="form-control" value="{{old('numero')}}">
                                                                                                </div>

                                                                                         </div>

                                                                                        <div class="row">
                                                                                              <div class="col-xs-5">
                                                                                                    <label for="bairro" class="control-label">Bairro</label>
                                                                                                    <input id="bairro" maxlength="50" name = "bairro" type="text" class="form-control" value="{{old('bairro')}}">
                                                                                               </div>

                                                                                              <div class="col-xs-5">
                                                                                                  <label for="complemento" class="control-label">Complemento</label>
                                                                                                  <input id="complemento" name = "complemento" type="text" class="form-control" value="{{old('complemento')}}">
                                                                                              </div>
                                                                                         </div>

                                                                                        <div class="row">
                                                                                                <div class="col-xs-5">
                                                                                                        <label for="cidade" class="control-label">Cidade</label>
                                                                                                        <input id="cidade" maxlength="60" name = "cidade" type="text" class="form-control" value="{{old('cidade')}}">
                                                                                                </div>

                                                                                                <div class="col-xs-1">
                                                                                                    <label for="estado" class="control-label">Estado</label>
                                                                                                    <input id="estado" maxlength="2" name = "estado" type="text" class="form-control" value="{{old('estado')}}">
                                                                                                </div>

                                                                                                <div class="col-xs-6"><!-- col-xs-6-->
                                                                                                    <label for="emailprincipal" class="control-label">Email</label>

                                                                                                    <div class="input-group{{ $errors->has('emailprincipal') ? ' has-error' : '' }}">
                                                                                                               <div class="input-group-addon">
                                                                                                                <i class="fa fa-envelope"></i>
                                                                                                                </div>
                                                                                                                <input id="emailprincipal" maxlength="150" name = "emailprincipal" type="text" class="form-control" value="{{old('emailprincipal')}}">

                                                                                                                 <!-- se houver erros na validacao do form request -->
                                                                                                                 @if ($errors->has('emailprincipal'))
                                                                                                                  <span class="help-block">
                                                                                                                      <strong>{{ $errors->first('emailprincipal') }}</strong>
                                                                                                                  </span>
                                                                                                                 @endif
                                                                                                    </div>
                                                                                               </div><!-- end col-xs-6-->

                                                                                        </div>

                                                                                        <div class="row"><!-- row-->

                                                                                               <div class="col-xs-4">
                                                                                                      <label for="cargo" class="control-label">Cargo/Função</label>

                                                                                                      <select name="cargo" class="form-control select2" style="width: 100%;">
                                                                                                      <option  value="">(Selecionar)</option>
                                                                                                      @foreach($cargos as $item)
                                                                                                            <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                                      @endforeach
                                                                                                      </select>

                                                                                               </div><!-- col-xs-5-->

                                                                                               <div class="col-xs-4">
                                                                                                      <label for="ramos" class="control-label">Ramo de Atividade</label>

                                                                                                      <select name="ramos" class="form-control select2" style="width: 100%;">
                                                                                                      <option  value="">(Selecionar)</option>
                                                                                                      @foreach($ramos as $item)
                                                                                                            <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                                      @endforeach
                                                                                                      </select>

                                                                                               </div><!-- col-xs-5-->

                                                                                               <div class="col-xs-4">
                                                                                                      <label for="profissoes" class="control-label">Profissão</label>

                                                                                                      <select name="profissoes" class="form-control select2" style="width: 100%;">
                                                                                                      <option  value="">(Selecionar)</option>
                                                                                                      @foreach($profissoes as $item)
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

                                                                                               <div class="col-xs-4">
                                                                                                      <label for="grauinstrucao" class="control-label">Grau de Instrução</label>

                                                                                                      <select name="grauinstrucao" class="form-control select2" style="width: 100%;">
                                                                                                      <option  value="">(Selecione um registro)</option>
                                                                                                      @foreach($dados as $item)
                                                                                                            <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                                      @endforeach
                                                                                                      </select>

                                                                                               </div><!-- col-xs-5-->

                                                                                               <div class="col-xs-4">
                                                                                                      <label for="formacao" class="control-label">Áreas de Formação</label>

                                                                                                      <select name="formacao" multiple="multiple" data-placeholder="Selecione um ou vários" class="form-control select2" style="width: 100%;">
                                                                                                      <option  value="">(Selecione um ou vários)</option>
                                                                                                      @foreach($dados as $item)
                                                                                                            <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                                      @endforeach
                                                                                                      </select>

                                                                                               </div><!-- col-xs-5-->

                                                                                               <div class="col-xs-4">
                                                                                                      <label for="idiomas" class="control-label">Idiomas</label>

                                                                                                      <select name="idiomas" multiple="multiple" data-placeholder="Selecione um ou vários" class="form-control select2" style="width: 100%;">
                                                                                                      <option  value="">(Selecione um ou vários)</option>
                                                                                                      @foreach($dados as $item)
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
                                                                                      <label for="estadocivil" class="control-label">Estado Civil</label>

                                                                                      <select name="estadocivil" class="form-control select2" style="width: 100%;">
                                                                                      <option  value="">(Selecionar)</option>
                                                                                      @foreach($dados as $item)
                                                                                            <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                      @endforeach
                                                                                      </select>
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
                                                                                                    <label for="conjuge" class="control-label">Nome</label>
                                                                                                    <select name="estadocivil" class="form-control select2" style="width: 100%;">
                                                                                                    <option  value="">(Selecionar)</option>
                                                                                                    @foreach($dados as $item)
                                                                                                          <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                                    @endforeach
                                                                                                    </select>
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
                                                                                                    <label for="status_conjuge" class="control-label">Status</label>
                                                                                                    <select name="status_conjuge" class="form-control select2" style="width: 100%;">
                                                                                                    <option  value="">(Selecionar)</option>
                                                                                                    @foreach($dados as $item)
                                                                                                          <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                                    @endforeach
                                                                                                    </select>
                                                                                          </div>

                                                                                          <div class="col-xs-4">
                                                                                                    <label for="profissao_conjuge" class="control-label">Profissão</label>
                                                                                                    <select name="profissao_conjuge" class="form-control select2" style="width: 100%;">
                                                                                                    <option  value="">(Selecionar)</option>
                                                                                                    @foreach($dados as $item)
                                                                                                          <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                                    @endforeach
                                                                                                    </select>
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
                                                                                                    @foreach($dados as $item)
                                                                                                          <option  value="{{$item->id}}">{{$item->nome}}</option>
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
                                                                                                    @foreach($dados as $item)
                                                                                                          <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                                    @endforeach
                                                                                                    </select>
                                                                                          </div>

                                                                                          <div class="col-xs-4">
                                                                                                    <label for="profissao_conjuge" class="control-label">Estado Civil</label>
                                                                                                    <select name="profissao_conjuge" class="form-control select2" style="width: 100%;">
                                                                                                    <option  value="">(Selecionar)</option>
                                                                                                    @foreach($dados as $item)
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
                                                                                                    <label for="filhos" class="control-label">Nome do Pai</label>
                                                                                                    <select name="filhos" class="form-control select2" style="width: 100%;">
                                                                                                    <option  value="">(Selecionar)</option>
                                                                                                    @foreach($dados as $item)
                                                                                                          <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                                    @endforeach
                                                                                                    </select>
                                                                                               </div>

                                                                                               <div class="col-xs-5">
                                                                                                    <label for="status_conjuge" class="control-label">Status</label>
                                                                                                    <select name="status_conjuge" class="form-control select2" style="width: 100%;">
                                                                                                    <option  value="">(Selecionar)</option>
                                                                                                    @foreach($dados as $item)
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

                                                                                      <div class="row"><!-- row mãe-->

                                                                                               <div class="col-xs-5">
                                                                                                    <label for="filhos" class="control-label">Nome da Mãe</label>
                                                                                                    <select name="filhos" class="form-control select2" style="width: 100%;">
                                                                                                    <option  value="">(Selecionar)</option>
                                                                                                    @foreach($dados as $item)
                                                                                                          <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                                    @endforeach
                                                                                                    </select>
                                                                                               </div>

                                                                                               <div class="col-xs-5">
                                                                                                    <label for="status_conjuge" class="control-label">Status</label>
                                                                                                    <select name="status_conjuge" class="form-control select2" style="width: 100%;">
                                                                                                    <option  value="">(Selecionar)</option>
                                                                                                    @foreach($dados as $item)
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

                                                                                                        <input id="foneigrejaanterior"  name = "foneprincipal" type="text" class="form-control" value="{{old('foneigrejaanterior')}}"  data-inputmask='"mask": "(99) 9999-9999"' data-mask >

                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-xs-3">
                                                                                                      <label for="religiao" class="control-label">Religião Anterior</label>

                                                                                                      <select name="religiao" class="form-control select2" style="width: 100%;">
                                                                                                      <option  value="">(Selecione)</option>
                                                                                                      @foreach($dados as $item)
                                                                                                            <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                                      @endforeach
                                                                                                      </select>
                                                                                            </div><!-- col-xs-5-->


                                                                                       </div><!-- end row-->


                                                                                       <div class="row">

                                                                                              <div class="col-xs-2">
                                                                                                          <label for="cep" class="control-label">CEP</label>
                                                                                                          <div class="input-group">
                                                                                                                   <div class="input-group-addon">
                                                                                                                      <a href="#" data-toggle="tooltip" title="Digite o CEP para buscar automaticamente o endereço. Não informar pontos ou traços.">
                                                                                                                            <img src="{{ url('/images/help.png') }}" class="user-image" alt="Ajuda"  />
                                                                                                                       </a>
                                                                                                                    </div>

                                                                                                                    <input id="cep" maxlength="8" name = "cep" type="text" class="form-control" value="{{old('cep')}}">
                                                                                                            </div>
                                                                                              </div>

                                                                                                <div class="col-xs-7">
                                                                                                        <label for="endereco" class="control-label">Endereço</label>
                                                                                                        <input id="endereco" maxlength="150" name = "endereco" type="text" class="form-control" value="{{old('endereco')}}">
                                                                                                </div>

                                                                                                <div class="col-xs-1">
                                                                                                        <label for="numero" class="control-label">Número</label>
                                                                                                        <input id="numero" maxlength="10" name = "numero" type="text" class="form-control" value="{{old('numero')}}">
                                                                                                </div>

                                                                                        </div><!-- end row  -->

                                                                                        <div class="row">
                                                                                              <div class="col-xs-5">
                                                                                                    <label for="bairro" class="control-label">Bairro</label>
                                                                                                    <input id="bairro" maxlength="50" name = "bairro" type="text" class="form-control" value="{{old('bairro')}}">
                                                                                               </div>

                                                                                              <div class="col-xs-5">
                                                                                                  <label for="complemento" class="control-label">Complemento</label>
                                                                                                  <input id="complemento" name = "complemento" type="text" class="form-control" value="{{old('complemento')}}">
                                                                                              </div>
                                                                                        </div><!-- end row  -->

                                                                                        <div class="row">
                                                                                                <div class="col-xs-5">
                                                                                                        <label for="cidade" class="control-label">Cidade</label>
                                                                                                        <input id="cidade" maxlength="60" name = "cidade" type="text" class="form-control" value="{{old('cidade')}}">
                                                                                                </div>

                                                                                                <div class="col-xs-1">
                                                                                                    <label for="estado" class="control-label">Estado</label>
                                                                                                    <input id="estado" maxlength="2" name = "estado" type="text" class="form-control" value="{{old('estado')}}">
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
                                                                                                    <label for="endereco" class="control-label">Igreja</label>
                                                                                                    <input id="endereco" maxlength="150" name = "endereco" type="text" class="form-control" value="{{old('endereco')}}">
                                                                                            </div>

                                                                                            <div class="col-xs-4">
                                                                                                    <label for="numero" class="control-label">Celebrador</label>
                                                                                                    <input id="numero" maxlength="10" name = "numero" type="text" class="form-control" value="{{old('numero')}}">
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
                                                                                                      @foreach($dados as $item)
                                                                                                            <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                                      @endforeach
                                                                                                      </select>
                                                                                            </div><!-- col-xs-5-->

                                                                                            <div class="col-xs-4">
                                                                                                    <label for="ataentrada" class="control-label">Registrado em Ata n.:</label>
                                                                                                    <input id="ataentrada" maxlength="10" name = "numero" type="text" class="form-control" value="{{old('ata_entrada')}}">
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
                                                                                                      @foreach($dados as $item)
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
                                                                                                    <label for="reintegracao" class="control-label">Observação</label>
                                                                                                    <input id="reintegracao" maxlength="10" name = "reintegracao" type="text" class="form-control" value="{{old('reintegracao')}}">
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
                                                                                                    <label for="opDoadorSangue" class="control-label">Prefere trabalhar com :</label>

                                                                                                    <br/>
                                                                                                   <label>
                                                                                                        <input type="radio" name="opDoadorSangue" class="minimal" value="S">
                                                                                                        Tarefas
                                                                                                   </label>

                                                                                                   <label>
                                                                                                        <input type="radio" name="opDoadorSangue" class="minimal" value="N">
                                                                                                        Pessoas
                                                                                                   </label>
                                                                                              </div><!-- end col-xs-->

                                                                                              <div class="col-xs-4">
                                                                                                    <label for="opDoadorSangue" class="control-label">Considera-se :</label>

                                                                                                    <br/>
                                                                                                   <label>
                                                                                                        <input type="radio" name="opDoadorSangue" class="minimal" value="S">
                                                                                                        Muito Estruturado
                                                                                                   </label>

                                                                                                   <label>
                                                                                                        <input type="radio" name="opDoadorSangue" class="minimal" value="N">
                                                                                                        Estruturado
                                                                                                   </label>

                                                                                                   <label>
                                                                                                        <input type="radio" name="opDoadorSangue" class="minimal" value="S">
                                                                                                        Pouco Estruturado
                                                                                                   </label>

                                                                                              </div><!-- end col-xs-->

                                                                                        </div><!-- end row-->

                                                                                        <div class="row"><!-- row-->

                                                                                               <div class="col-xs-4">
                                                                                                      <label for="disponibilidade" class="control-label">Disponibilidade de Tempo</label>

                                                                                                      <select name="disponibilidade" class="form-control select2" style="width: 100%;">
                                                                                                      <option  value="">(Selecione um registro)</option>
                                                                                                      @foreach($dados as $item)
                                                                                                            <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                                      @endforeach
                                                                                                      </select>

                                                                                               </div><!-- col-xs-5-->

                                                                                               <div class="col-xs-4">
                                                                                                      <label for="dons" class="control-label">Dons Espirituais</label>

                                                                                                      <select name="dons" multiple="multiple" data-placeholder="Selecione um ou vários" class="form-control select2" style="width: 100%;">
                                                                                                      <option  value="">(Selecione um ou vários)</option>
                                                                                                      @foreach($dados as $item)
                                                                                                            <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                                      @endforeach
                                                                                                      </select>

                                                                                               </div><!-- col-xs-5-->

                                                                                               <div class="col-xs-4">
                                                                                                      <label for="habilidades" class="control-label">Habilidades</label>

                                                                                                      <select name="habilidades" multiple="multiple" data-placeholder="Selecione um ou vários" class="form-control select2" style="width: 100%;">
                                                                                                      <option  value="">(Selecione um ou vários)</option>
                                                                                                      @foreach($dados as $item)
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

                                                                                                       <div class="col-xs-6">
                                                                                                              <label for="ministerio" class="control-label">Ministério</label>

                                                                                                              <select name="ministerio" multiple="multiple" class="form-control select2" style="width: 100%;">
                                                                                                              <option  value="">(Selecione um ou vários)</option>
                                                                                                              @foreach($dados as $item)
                                                                                                                    <option  value="{{$item->id}}">{{$item->nome}}</option>
                                                                                                              @endforeach
                                                                                                              </select>

                                                                                                       </div><!-- col-xs-5-->

                                                                                                       <div class="col-xs-6">
                                                                                                              <label for="atividades" class="control-label">Atividade</label>

                                                                                                              <select name="atividades" multiple="multiple" class="form-control select2" style="width: 100%;">
                                                                                                              <option  value="">(Selecionar)</option>
                                                                                                              @foreach($dados as $item)
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


                                 </div>
                                 <!-- FIM - DADOS ECLISIASTICOS-->


                         </div><!-- Fim tab panes-->

            </div><!-- fim box-body"-->

       </div>


        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit'>Gravar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>

        </form>

    </div>

</div>

@endsection

@section('tela_pessoas')
     <script type="text/javascript">

                  $(function ()
                  {

                       $('[data-toggle="tooltip"]').tooltip();

                        $('#endcobranca').click(function()
                        {
                            if ($(this).prop('checked'))
                            {
                                $("#exibir_endereco_cobranca").show();
                            } else
                            {
                                $("#exibir_endereco_cobranca").hide();
                            }
                        });

                        $(".cpf").show();

                        $('.opFisica').click(function()
                        {
                              $("#lb_cnpj_cpf").text('CPF');
                              $("#lb_inscricaoestadual_rg").text('RG');
                              $("#lb_datanasc").text('Data Nasc.');
                              $(".cpf").show();
                              $(".cnpj").hide();
                        });

                        $('.opJuridica').click(function()
                        {
                              $("#lb_cnpj_cpf").text('CNPJ');
                              $("#lb_inscricaoestadual_rg").text('Insc. Estadual');
                              $("#lb_datanasc").text('Data Fundação');
                              $(".cpf").hide();
                              $(".cnpj").show();
                        });

                   });
     </script>
@endsection

@section('busca_endereco')
<script type="text/javascript">

                  $(function ()
                  {

                            function limpa_formulario_cep()
                            {
                                // Limpa valores do formulário de cep.
                                $("#endereco").val("");
                                $("#bairro").val("");
                                $("#cidade").val("");
                                $("#estado").val("");
                                $("#ibge").val("");
                            }

                             function limpa_formulario_cep_cobranca()
                            {
                                // Limpa valores do formulário de cep.
                                $("#endereco_cobranca").val("");
                                $("#bairro_cobranca").val("");
                                $("#cidade_cobranca").val("");
                                $("#estado_cobranca").val("");
                                $("#ibge_cobranca").val("");
                            }

                                        //Quando o campo cep perde o foco.
                                        $("#cep").blur(function() {

                                            //Nova variável "cep" somente com dígitos.
                                            var cep = $(this).val().replace(/\D/g, '');

                                            //Verifica se campo cep possui valor informado.
                                            if (cep != "") {

                                                //Expressão regular para validar o CEP.
                                                var validacep = /^[0-9]{8}$/;

                                                //Valida o formato do CEP.
                                                if(validacep.test(cep)) {

                                                    //Preenche os campos com "..." enquanto consulta webservice.
                                                    $("#endereco").val("...")
                                                    $("#bairro").val("...")
                                                    $("#cidade").val("...")
                                                    $("#estado").val("...")
                                                    $("#ibge").val("...")

                                                    //Consulta o webservice viacep.com.br/
                                                    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                                                        if (!("erro" in dados)) {
                                                            //Atualiza os campos com os valores da consulta.
                                                            $("#endereco").val(dados.logradouro);
                                                            $("#bairro").val(dados.bairro);
                                                            $("#cidade").val(dados.localidade);
                                                            $("#estado").val(dados.uf);
                                                            $("#ibge").val(dados.ibge);
                                                        } //end if.
                                                        else {
                                                            //CEP pesquisado não foi encontrado.
                                                            limpa_formulario_cep();
                                                            alert("CEP não encontrado.");
                                                        }
                                                    });
                                                } //end if.
                                                else {
                                                    //cep é inválido.
                                                    limpa_formulario_cep();
                                                    alert("Formato de CEP inválido.");
                                                }
                                            } //end if.
                                            else {
                                                //cep sem valor, limpa formulário.
                                                limpa_formulario_cep();
                                            }
                                        });


                                        //Quando o campo cep perde o foco.
                                        $("#cep_cobranca").blur(function() {

                                            //Nova variável "cep" somente com dígitos.
                                            var cep = $(this).val().replace(/\D/g, '');

                                            //Verifica se campo cep possui valor informado.
                                            if (cep != "") {

                                                //Expressão regular para validar o CEP.
                                                var validacep = /^[0-9]{8}$/;

                                                //Valida o formato do CEP.
                                                if(validacep.test(cep)) {

                                                    //Preenche os campos com "..." enquanto consulta webservice.
                                                    $("#endereco_cobranca").val("...")
                                                    $("#bairro_cobranca").val("...")
                                                    $("#cidade_cobranca").val("...")
                                                    $("#estado_cobranca").val("...")
                                                    $("#ibge_cobranca").val("...")

                                                    //Consulta o webservice viacep.com.br/
                                                    $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                                                        if (!("erro" in dados)) {
                                                            //Atualiza os campos com os valores da consulta.
                                                            $("#endereco_cobranca").val(dados.logradouro);
                                                            $("#bairro_cobranca").val(dados.bairro);
                                                            $("#cidade_cobranca").val(dados.localidade);
                                                            $("#estado_cobranca").val(dados.uf);
                                                            $("#ibge_cobranca").val(dados.ibge);
                                                        } //end if.
                                                        else {
                                                            //CEP pesquisado não foi encontrado.
                                                            limpa_formulario_cep_cobranca();
                                                            alert("CEP não encontrado.");
                                                        }
                                                    });
                                                } //end if.
                                                else {
                                                    //cep é inválido.
                                                    limpa_formulario_cep_cobranca();
                                                    alert("Formato de CEP inválido.");
                                                }
                                            } //end if.
                                            else {
                                                //cep sem valor, limpa formulário.
                                                limpa_formulario_cep_cobranca();
                                            }
                                        });

                   });
</script>
@endsection