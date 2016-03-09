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

                                             </div>

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

                                           <div class="col-xs-12">

                                                 <!-- Custom Tabs (Pulled to the right) -->
                                                <div class="nav-tabs-custom">
                                                  <ul class="nav nav-tabs">
                                                    <li class="active"><a href="#tab_1-1" data-toggle="tab">Dados Pessoais</a></li>
                                                    <li><a href="#tab_2-2" data-toggle="tab">Dados Profissionais</a></li>
                                                    <li><a href="#tab_2-2" data-toggle="tab">Formação</a></li>
                                                    <li><a href="#tab_3-2" data-toggle="tab">Familiar</a></li>
                                                    <li><a href="#tab_3-2" data-toggle="tab">Hist. Eclesiástico</a></li>
                                                    <li><a href="#tab_3-2" data-toggle="tab">Habilidades, Dons e Cursos</a></li>
                                                    <li><a href="#tab_3-2" data-toggle="tab">Envolvimento Ministerial</a></li>
                                                    <li><a href="#tab_3-2" data-toggle="tab">Hist. de Movimentações</a></li>

                                                  </ul>
                                                  <div class="tab-content">
                                                    <div class="tab-pane active" id="tab_1-1">

                                                       <div class="row">
                                                              <div class="col-xs-3">
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

                                                                <div class="col-xs-3">
                                                                    <label for="opDoadorSangue" class="control-label">Doador Sangue</label>

                                                                    <br/>
                                                                   <label>
                                                                        <input type="radio" name="opDoadorSangue" class="minimal" value="S">
                                                                        Sim
                                                                   </label>

                                                                   <label>
                                                                        <input type="radio" name="opDoadorSangue" class="minimal" value="N">
                                                                        Não
                                                                   </label>

                                                                </div>

                                                                <div class="col-xs-3">
                                                                    <label for="opDoadorOrgaos" class="control-label">Doador Orgãos</label>

                                                                    <br/>
                                                                   <label>
                                                                        <input type="radio" name="opDoadorOrgaos" class="minimal" value="S">
                                                                        Sim
                                                                   </label>

                                                                   <label>
                                                                        <input type="radio" name="opDoadorOrgaos" class="minimal" value="N">
                                                                        Não
                                                                   </label>

                                                                </div>

                                                              <div class="col-xs-3">
                                                                      <label for="grpsangue" class="control-label">Grupo Sanguínio</label>
                                                                      <input id="grpsangue" name = "grpsangue" type="text" class="form-control"  value="{{old('gruposanguinio')}}">
                                                              </div>

                                                       </div>

                                                    </div>
                                                    <!-- /.tab-pane -->
                                                    <div class="tab-pane" id="tab_2-2">
                                                      The European languages are members of the same family. Their separate existence is a myth.
                                                      For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
                                                      in their grammar, their pronunciation and their most common words. Everyone realizes why a
                                                      new common language would be desirable: one could refuse to pay expensive translators. To
                                                      achieve this, it would be necessary to have uniform grammar, pronunciation and more common
                                                      words. If several languages coalesce, the grammar of the resulting language is more simple
                                                      and regular than that of the individual languages.
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                    <div class="tab-pane" id="tab_3-2">
                                                      Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                                                      Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                                      when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                                                      It has survived not only five centuries, but also the leap into electronic typesetting,
                                                      remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                                                      sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                                                      like Aldus PageMaker including versions of Lorem Ipsum.
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                  </div>
                                                  <!-- /.tab-content -->
                                                </div>
                                                <!-- nav-tabs-custom -->

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