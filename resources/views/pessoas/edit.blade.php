@extends('principal.master')

@section('content')

{{ \Session::put('titulo', $interface->nome) }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'pessoas') }}
{{ \Session::put('id_pagina', '28') }}

<div class = 'row'>

    <div class="col-md-12">

        <form name="form_endereco" method="get" action=".">
        </form>

        <form method = 'POST' class="form-horizontal"  enctype="multipart/form-data" action = {{ url('/' . \Session::get('route') . '/' . $pessoas[0]->id . '/update')}}>

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
                                        <a href="#compl" role="tab" data-toggle="tab">
                                            <i class="fa fa-cog"></i> Complementos
                                        </a>
                                   </li>

                                   <li>
                                        <a href="#obs" role="tab" data-toggle="tab">
                                            <i class="fa fa-edit"></i> Observações
                                        </a>
                                   </li>

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
                                                              <input type="radio" name="opStatus" class="minimal" {{ $pessoas[0]->ativo==1 ? 'checked' : '' }}>
                                                              Ativo
                                                         </label>

                                                         <label>
                                                              <input type="radio" name="opStatus" class="minimal" {{ $pessoas[0]->ativo==0 ? 'checked' : '' }}>
                                                              Inativo
                                                         </label>

                                                </div>


                                                <div class="col-xs-3">

                                                      <label for="opPessoa" class="control-label">Tipo Pessoa :</label>
                                                      <br/>

                                                        @if ($interface->fisica)
                                                         <label>
                                                              <input type="radio" id="opFisica" name="opPessoa" value="F" class="opFisica" {{ ( ($pessoas[0]->tipopessoa="F") ? 'checked' : '') }}>
                                                              Física
                                                         </label>
                                                         @endif

                                                         @if ($interface->juridica)
                                                         <label>
                                                              <input type="radio" id="opJuridica" name="opPessoa" value="J" class="opJuridica" {{ ( ($pessoas[0]->tipopessoa="J") ? 'checked' : '') }}>
                                                              Jurídica
                                                         </label>
                                                         @endif

                                                </div>


                                             <div class="col-xs-5">
                                                    <label for="grupo" class="control-label">Grupo</label>

                                                    <select name="grupo" class="form-control select2" style="width: 100%;">
                                                    <option  value="">(Selecione um Grupo)</option>
                                                    @foreach($grupos as $item)
                                                          <option  value="{{$item->id}}" {{ $pessoas[0]->grupos_pessoas_id==$item->id ? 'selected' : '' }} >{{$item->nome}}</option>
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

                                                      <input id="razaosocial" maxlength="150"  placeholder="Campo Obrigatório" name = "razaosocial" type="text" class="form-control" value="{{$pessoas[0]->razaosocial }}">

                                                         <!-- se houver erros na validacao do form request -->
                                                         @if ($errors->has('razaosocial'))
                                                          <span class="help-block">
                                                              <strong>{{ $errors->first('razaosocial') }}</strong>
                                                          </span>
                                                         @endif

                                                </div>

                                               <div class="col-xs-6">
                                                    <label for="nomefantasia" class="control-label">{{ $interface->fisica==true ? 'Nome Abrev.' : 'Nome Fantasia'}}</label>
                                                    <input id="nomefantasia" maxlength="100" name = "nomefantasia" type="text" class="form-control" value="{{$pessoas[0]->nomefantasia}}">
                                               </div>

                                        </div>

                                        <input id="cnpj" type="hidden" name="cnpj" value="">
                                        <input id="cpf"  type="hidden" name="cpf"  value="">

                                        <div class="row">

                                                    <div class="col-xs-2">
                                                           <label id="lb_cnpj_cpf" for="cnpj_cpf" class="control-label">{{ $pessoas[0]->tipopessoa=="F" ? 'CPF' : 'CNPJ'}}</label>

                                                           <input id="cnpj" style='{{ $pessoas[0]->tipopessoa=='F' ? 'display:none' : '' }}' data-inputmask='"mask": "99.999.999/9999-99"' data-mask name="cnpj" type="text" class="cnpj form-control" value="{{$pessoas[0]->cnpj_cpf}}">
                                                           <input id="cpf"  style='{{ $pessoas[0]->tipopessoa=='J' ? 'display:none' : '' }}' data-inputmask='"mask": "999.999.999-99"' data-mask name="cpf" type="text" class="cpf form-control" value="{{$pessoas[0]->cnpj_cpf}}">

                                                    </div>

                                                    <div class="col-xs-2">
                                                         <label id="lb_inscricaoestadual_rg" for="inscricaoestadual_rg" class="control-label">{{ $interface->fisica==true ? 'RG' : 'Insc. Estadual'}}</label>
                                                         <input id="inscricaoestadual_rg"  maxlength="15" name = "inscricaoestadual_rg" type="text" class="form-control" value="{{ $pessoas[0]->inscricaoestadual_rg }}">
                                                    </div>

                                                    <div class="col-xs-2">
                                                              <label id="lb_datanasc" for="datanasc" class="control-label">{{ $interface->fisica==true ? 'Data Nasc.' : 'Data Fundação'}}</label>

                                                              <div class="input-group">
                                                                     <div class="input-group-addon">
                                                                      <i class="fa fa-calendar"></i>
                                                                      </div>

                                                                      <input id ="datanasc" name = "datanasc" type="text" class="form-control" data-inputmask='"mask": "99/99/9999"' data-mask  value="{{$pessoas[0]->datanasc}}">
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

                                                            <input id="foneprincipal" placeholder="Campo Obrigatório" name = "foneprincipal" type="text" class="form-control" value="{{$pessoas[0]->fone_principal}}"  data-inputmask='"mask": "(99) 9999-9999"' data-mask >

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

                                                                <input id="fonesecundario" name = "fonesecundario" type="text" class="form-control" data-inputmask='"mask": "(99) 9999-9999"' data-mask  value="{{$pessoas[0]->fone_secundario}}">
                                                        </div>

                                                 </div>

                                                <div class="col-xs-2">
                                                        <label for="fonerecado" class="control-label">Fone Recado</label>

                                                        <div class="input-group">
                                                               <div class="input-group-addon">
                                                                <i class="fa fa-phone"></i>
                                                                </div>

                                                                <input id="fonerecado" name = "fonerecado" type="text" class="form-control" data-inputmask='"mask": "(99) 9999-9999"' data-mask  value="{{$pessoas[0]->fone_recado}}">
                                                        </div>

                                                 </div>

                                                <div class="col-xs-2">
                                                    <label for="celular" class="control-label">Celular</label>

                                                    <div class="input-group">
                                                               <div class="input-group-addon">
                                                                <i class="fa fa-phone"></i>
                                                                </div>
                                                                <input id="celular" data-inputmask='"mask": "(99) 9999-9999"' data-mask  name = "celular" type="text" class="form-control" value="{{$pessoas[0]->fone_celular}}">
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
                                                                    <input id="emailprincipal" maxlength="150" name = "emailprincipal" type="text" class="form-control" value="{{$pessoas[0]->emailprincipal}}">

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
                                                                    <input id="emailsecundario" maxlength="150" name = "emailsecundario" type="text" class="form-control" value="{{$pessoas[0]->emailsecundario}}">

                                                                     <!-- se houver erros na validacao do form request -->
                                                                     @if ($errors->has('emailsecundario'))
                                                                      <span class="help-block">
                                                                             <strong>{{ $errors->first('emailsecundario') }}</strong>
                                                                      </span>
                                                                     @endif
                                                            </div>

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

                                                                <input id="cep" maxlength="8" name = "cep" type="text" class="form-control" value="{{$pessoas[0]->cep}}">
                                                        </div>
                                           </div>


                                            <div class="col-xs-7">
                                                    <label for="endereco" class="control-label">Endereço</label>
                                                    <input id="endereco" maxlength="150" name = "endereco" type="text" class="form-control" value="{{$pessoas[0]->endereco}}">
                                            </div>

                                            <div class="col-xs-1">
                                                    <label for="numero" class="control-label">Número</label>
                                                    <input id="numero" maxlength="10" name = "numero" type="text" class="form-control" value="{{$pessoas[0]->numero}}">
                                            </div>
                                      </div>

                                      <div class="row">
                                            <div class="col-xs-5">
                                                  <label for="bairro" class="control-label">Bairro</label>
                                                  <input id="bairro" maxlength="50" name = "bairro" type="text" class="form-control" value="{{$pessoas[0]->bairro}}">
                                             </div>

                                            <div class="col-xs-5">
                                                <label for="complemento" class="control-label">Complemento</label>
                                                <input id="complemento" name = "complemento" type="text" class="form-control" value="{{$pessoas[0]->complemento}}">
                                            </div>

                                      </div>

                                    <div class="row">
                                            <div class="col-xs-5">
                                                    <label for="cidade" class="control-label">Cidade</label>
                                                    <input id="cidade" maxlength="60" name = "cidade" type="text" class="form-control" value="{{$pessoas[0]->cidade}}">
                                            </div>

                                            <div class="col-xs-1">
                                                <label for="estado" class="control-label">Estado</label>
                                                <input id="estado" maxlength="2" name = "estado" type="text" class="form-control" value="{{$pessoas[0]->estado}}">
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
                                                        <option  value="{{$item->id}}"  {{ ($pessoas[0]->bancos_id==$item->id ? 'selected=selected' : '') }} >{{$item->nome}}</option>
                                                  @endforeach
                                                  </select>

                                            </div>
                                      </div>

                                      <div class="row">
                                                <div class="col-xs-5">
                                                            <p></p>
                                                            <label for="check_endcobranca">
                                                                  <input  id="check_endcobranca" name="check_endcobranca" type="checkbox" class="minimal-red" {{ ($pessoas[0]->endereco_cobranca!="" ? 'checked' : '') }} value="1" />
                                                                  Endereço de Cobrança diferente do principal
                                                            </label>
                                                </div>
                                      </div>

                                      <div id="exibir_endereco_cobranca" {{ ($pessoas[0]->endereco_cobranca!="" ? "": "style='display: none'") }} >
                                              <div class="row">

                                                      <div class="col-xs-2">
                                                           <label for="cep_cobranca" class="control-label">CEP</label>
                                                           <input id="cep_cobranca" maxlength="8" name = "cep_cobranca" type="text" class="form-control" value="{{$pessoas[0]->cep_cobranca}}">
                                                      </div>

                                                      <div class="col-xs-7">
                                                              <label for="endereco_cobranca" class="control-label">Endereço para Cobrança</label>
                                                              <input id="endereco_cobranca" maxlength="150" name = "endereco_cobranca" type="text" class="form-control" value="{{$pessoas[0]->endereco_cobranca}}">
                                                      </div>

                                                      <div class="col-xs-1">
                                                              <label for="numero_cobranca" class="control-label">Número</label>
                                                              <input id="numero_cobranca" maxlength="10" name = "numero_cobranca" type="text" class="form-control" value="{{$pessoas[0]->numero_cobranca}}">
                                                      </div>
                                              </div>

                                              <div class="row">
                                                      <div class="col-xs-5">
                                                            <label for="bairro_cobranca" class="control-label">Bairro</label>
                                                            <input id="bairro_cobranca" maxlength="50" name = "bairro_cobranca" type="text" class="form-control" value="{{$pessoas[0]->bairro_cobranca}}">
                                                       </div>

                                                      <div class="col-xs-5">
                                                          <label for="complemento_cobranca" class="control-label">Complemento</label>
                                                          <input id="complemento_cobranca" name = "complemento_cobranca" type="text" class="form-control" value="{{$pessoas[0]->complemento_cobranca}}">
                                                      </div>


                                              </div>

                                              <div class="row">
                                                      <div class="col-xs-5">
                                                              <label for="cidade_cobranca" class="control-label">Cidade</label>
                                                              <input id="cidade_cobranca" maxlength="60" name = "cidade_cobranca" type="text" class="form-control" value="{{$pessoas[0]->cidade_cobranca}}">
                                                      </div>

                                                      <div class="col-xs-1">
                                                          <label for="estado_cobranca" class="control-label">Estado</label>
                                                          <input id="estado_cobranca" maxlength="2" name = "estado_cobranca" type="text" class="form-control" value="{{$pessoas[0]->estado_cobranca}}">
                                                      </div>
                                              </div>
                                       </div>

                                </div><!--  FIM TAB FINANCEIRO-->


                                <!-- TAB COMPLEMENTO-->
                                <div class="tab-pane fade" id="compl">

                                    <div class="row">
                                            <div class="col-xs-9">
                                                <label for="website" class="control-label">Website</label>
                                                <input id="website" maxlength="255" name = "website" type="text" class="form-control" value="{{$pessoas[0]->website}}">
                                            </div>
                                    </div>

                                    <div class="row">
                                            <div class="col-xs-5">
                                                    <label for="caminhologo" class="control-label">Logo</label>
                                                    <input type="file" id="caminhologo" maxlength="255" name = "caminhologo" >
                                            </div>

                                            @if ($pessoas[0]->caminhofoto!="")
                                                  <p></p>
                                                  <div class="col-xs-3">
                                                        <img src="{{ url('/images/persons/' . $pessoas[0]->caminhofoto) }}" width="200px" height="100px">

                                                        @can('verifica_permissao', [ \Session::get('id_pagina') ,'excluir'])
                                                        <a href="{{ url('/pessoas/' . $pessoas[0]->id . '/remover')}}"><i class="fa fa-remove"> Remover Imagem</i> </a>
                                                        @endcan
                                                  </div>

                                              @endif

                                    </div>

                                </div><!--  FIM TAB COMPLEMENTO-->


                                <!-- TAB OBSERVACOES -->
                                <div class="tab-pane fade" id="obs">

                                        <div class="row">
                                                <div class="col-xs-10">

                                                    <label for="obs" class="control-label">Observações</label>
                                                    <textarea name="obs" class="form-control" rows="6" placeholder="Digite o texto...">{{$pessoas[0]->obs}}</textarea>

                                                </div>
                                         </div>
                                </div><!-- FIM - TAB OBSERVACOES -->


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

                        $('#check_endcobranca').click(function()
                        {
                            if ($(this).prop('checked'))
                            {
                                $("#exibir_endereco_cobranca").show();
                            } else
                            {
                                $("#exibir_endereco_cobranca").hide();
                            }
                        });

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