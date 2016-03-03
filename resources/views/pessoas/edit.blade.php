@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Pessoas') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'pessoas') }}
{{ \Session::put('id_pagina', '28') }}

<div class = 'row'>

    <div class="col-md-12">

        <div>
            <a href={{ url('/' . \Session::get('route')) }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
        </div>

        <form method = 'POST' class="form-horizontal"  action = {{ url('/' . \Session::get('route') . '/' . $dados->id . '/update')}}>
            <!--<input type = 'hidden' name = '_token' value = '{{Session::token()}}'>-->
            {!! csrf_field() !!}

            <div class="">

                 <div class="nav-tabs-custom"> <!--anterior box-body-->

                         <!-- Nav tabs -->
                          <ul class="nav nav-tabs" role="tablist">
                                  <li class="active">
                                      <a href="#home" role="tab" data-toggle="tab">
                                          <icon class="fa fa-user"></icon> Dados Cadastrais
                                      </a>
                                  </li>
                                  <li>
                                        <a href="#endereco" role="tab" data-toggle="tab">
                                            <i class="fa fa-map-marker"></i> Endereço
                                        </a>
                                  </li>

                                  <li>
                                        <a href="#financ" role="tab" data-toggle="tab">
                                            <i class="fa fa-map-marker"></i> Dados Financeiros
                                        </a>
                                  </li>

                                   <li>
                                        <a href="#compl" role="tab" data-toggle="tab">
                                            <i class="fa fa-cog"></i> Complementos
                                        </a>
                                   </li>
                          </ul>

                              <!-- Tab panes -->
                              <!-- DADOS CADASTRAIS-->
                           <div class="tab-content">

                                  <div class="tab-pane active in" id="home">

                                        <br/>

                                        <div class="row{{ $errors->has('razaosocial') ? ' has-error' : '' }}">
                                                <div class="col-xs-6">
                                                      <label for="razaosocial" class="control-label">Razão Social</label>

                                                      <input id="razaosocial" maxlength="150"  name = "razaosocial" type="text" class="form-control" value="{{ $dados->razaosocial }}">

                                                         <!-- se houver erros na validacao do form request -->
                                                         @if ($errors->has('razaosocial'))
                                                          <span class="help-block">
                                                              <strong>{{ $errors->first('razaosocial') }}</strong>
                                                          </span>
                                                         @endif

                                                </div>

                                                <div class="col-xs-6">
                                                    <label for="nomefantasia" class="control-label">Nome Fantasia</label>
                                                    <input id="nomefantasia" maxlength="100" name = "nomefantasia" type="text" class="form-control" value="{{$dados->nomefantasia}}">
                                                </div>

                                        </div>


                                        <div class="row">

                                                <div class="col-xs-3">
                                                       <label for="cnpj" class="control-label">CNPJ</label>
                                                       <input id="cnpj" data-inputmask='"mask": "99.999.999/9999-99"' data-mask name = "cnpj" type="text" class="form-control" value="{{$dados->cnpj}}">
                                                </div>

                                                <div class="col-xs-3">
                                                     <label for="inscricaoestadual" class="control-label">Inscr. Estadual</label>
                                                     <input id="inscricaoestadual"  maxlength="15" name = "inscricaoestadual" type="text" class="form-control" value="{{$dados->inscricaoestadual}}">
                                                </div>

                                                <div class="col-xs-3">
                                                    <label for="foneprincipal" class="control-label">Fone Principal</label>

                                                    <div class="input-group{{ $errors->has('foneprincipal') ? ' has-error' : '' }}">
                                                           <div class="input-group-addon">
                                                            <i class="fa fa-phone"></i>
                                                            </div>

                                                            <input id="foneprincipal" name = "foneprincipal" type="text" class="form-control" value="{{$dados->foneprincipal}}"  data-inputmask='"mask": "(99) 9999-9999"' data-mask >

                                                             <!-- se houver erros na validacao do form request -->
                                                             @if ($errors->has('foneprincipal'))
                                                              <span class="help-block">
                                                                  <strong>{{ $errors->first('foneprincipal') }}</strong>
                                                              </span>
                                                             @endif

                                                    </div>

                                              </div>

                                                 <div class="col-xs-3">
                                                        <label for="fonesecundario" class="control-label">Fone Secundário</label>

                                                        <div class="input-group">
                                                               <div class="input-group-addon">
                                                                <i class="fa fa-phone"></i>
                                                                </div>

                                                                <input id="fonesecundario" name = "fonesecundario" type="text" class="form-control" data-inputmask='"mask": "(99) 9999-9999"' data-mask  value="{{$dados->fonesecundario}}">
                                                        </div>

                                                 </div>

                                         </div>


                                        <div class="row">
                                                <div class="col-xs-3">
                                                    <label for="fonerecado" class="control-label">Fone Recado</label>

                                                    <div class="input-group">
                                                               <div class="input-group-addon">
                                                                <i class="fa fa-phone"></i>
                                                                </div>
                                                                <input id="fonerecado" data-inputmask='"mask": "(99) 9999-9999"' data-mask  name = "fonerecado" type="text" class="form-control" value="{{$dados->fonerecado}}">
                                                    </div>
                                                </div>

                                                <div class="col-xs-3">
                                                    <label for="celular" class="control-label">Celular</label>

                                                    <div class="input-group">
                                                               <div class="input-group-addon">
                                                                <i class="fa fa-phone"></i>
                                                                </div>
                                                                <input id="celular" data-inputmask='"mask": "(99) 9999-9999"' data-mask  name = "celular" type="text" class="form-control" value="{{$dados->celular}}">
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
                                                                    <input id="emailprincipal" maxlength="150" name = "emailprincipal" type="text" class="form-control" value="{{$dados->emailprincipal}}">

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
                                                                    <input id="emailsecundario" maxlength="150" name = "emailsecundario" type="text" class="form-control" value="{{$dados->emailsecundario}}">

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
                                 <div class="tab-pane" id="endereco">
                                    <br/>

                                     <div class="row">
                                            <div class="col-xs-7">
                                                    <label for="endereco" class="control-label">Endereço</label>
                                                    <input id="endereco" maxlength="150" name = "endereco" type="text" class="form-control" value="{{$dados->endereco}}">
                                            </div>

                                            <div class="col-xs-2">
                                                    <label for="numero" class="control-label">Número</label>
                                                    <input id="numero" maxlength="10" name = "numero" type="text" class="form-control" value="{{$dados->numero}}">
                                            </div>
                                    </div>

                                    <div class="row">
                                            <div class="col-xs-7">
                                                  <label for="bairro" class="control-label">Bairro</label>
                                                  <input id="bairro" maxlength="50" name = "bairro" type="text" class="form-control" value="{{$dados->bairro}}">
                                             </div>

                                            <div class="col-xs-2">
                                                 <label for="cep" class="control-label">CEP</label>
                                                 <input id="cep" maxlength="8" name = "cep" type="text" class="form-control" value="{{$dados->cep}}">
                                            </div>

                                    </div>


                                    <div class="row">
                                            <div class="col-xs-9">
                                                <label for="complemento" class="control-label">Complemento</label>
                                                <input id="complemento" name = "complemento" type="text" class="form-control" value="{{$dados->complemento}}">
                                            </div>
                                    </div>

                                    <div class="row">
                                            <div class="col-xs-7">
                                                    <label for="cidade" class="control-label">Cidade</label>
                                                    <input id="cidade" maxlength="60" name = "cidade" type="text" class="form-control" value="{{$dados->cidade}}">
                                            </div>

                                            <div class="col-xs-2">
                                                <label for="estado" class="control-label">Estado</label>
                                                <input id="estado" maxlength="2" name = "estado" type="text" class="form-control" value="{{$dados->estado}}">
                                            </div>
                                    </div>
                             </div><!-- FIM TAB ENDERECO-->



                                <!-- TAB FINANCEIRO-->
                                <div class="tab-pane" id="financeiro">
                                    <br/>

                                    <div class="row">
                                            <div class="col-xs-10">
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
                                            <div class="col-xs-7">
                                                    <label for="endereco_cobranca" class="control-label">Endereço para Cobrança</label>
                                                    <input id="endereco_cobranca" maxlength="150" name = "endereco_cobranca" type="text" class="form-control" value="{{$financeiro->endereco}}">
                                            </div>

                                            <div class="col-xs-2">
                                                    <label for="numero_cobranca" class="control-label">Número</label>
                                                    <input id="numero_cobranca" maxlength="10" name = "numero_cobranca" type="text" class="form-control" value="{{$financeiro->numero}}">
                                            </div>
                                    </div>

                                    <div class="row">
                                            <div class="col-xs-7">
                                                  <label for="bairro_cobranca" class="control-label">Bairro</label>
                                                  <input id="bairro_cobranca" maxlength="50" name = "bairro_cobranca" type="text" class="form-control" value="{{$financeiro->bairro}}">
                                             </div>

                                            <div class="col-xs-2">
                                                 <label for="cep_cobranca" class="control-label">CEP</label>
                                                 <input id="cep_cobranca" maxlength="8" name = "cep_cobranca" type="text" class="form-control" value="{{$financeiro->cep}}">
                                            </div>

                                    </div>


                                    <div class="row">
                                            <div class="col-xs-9">
                                                <label for="complemento_cobranca" class="control-label">Complemento</label>
                                                <input id="complemento_cobranca" name = "complemento_cobranca" type="text" class="form-control" value="{{$financeiro->complemento}}">
                                            </div>
                                    </div>

                                    <div class="row">
                                            <div class="col-xs-7">
                                                    <label for="cidade_cobranca" class="control-label">Cidade</label>
                                                    <input id="cidade_cobranca" maxlength="60" name = "cidade_cobranca" type="text" class="form-control" value="{{$financeiro->cidade}}">
                                            </div>

                                            <div class="col-xs-2">
                                                <label for="estado_cobranca" class="control-label">Estado</label>
                                                <input id="estado_cobranca" maxlength="2" name = "estado_cobranca" type="text" class="form-control" value="{{$financeiro->estado}}">
                                            </div>
                                    </div>


                                </div><!--  FIM TAB FINANCEIRO-->

                                <!-- TAB COMPLEMENTO-->
                                <div class="tab-pane" id="compl">
                                    <br/>

                                    <div class="row">
                                            <div class="col-xs-9">
                                                <label for="website" class="control-label">Website</label>
                                                <input id="website" maxlength="255" name = "website" type="text" class="form-control" value="{{$dados->website}}">
                                            </div>
                                    </div>

                                    <div class="row">
                                            <div class="col-xs-5">
                                                    <label for="caminhologo" class="control-label">Logo</label>
                                                    <input type="file" id="caminhologo" maxlength="255" name = "caminhologo" class="form-control" >
                                            </div>

                                              @if ($dados->caminhologo!="")
                                                  <p></p>
                                                  <div class="col-xs-3">
                                                        <img src="{{ url('/images/clients/' . $dados->caminhologo) }}" width="200px" height="100px">
                                                        <a href="{{ url('/clientes/' . $dados->id . '/remover')}}"><i class="fa fa-remove"> Remover Imagem</i> </a>
                                                  </div>

                                              @endif
                                    </div>


                                </div><!--  FIM TAB COMPLEMENTO-->

                         </div><!-- Fim tab panes-->

            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}>Gravar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>

       </form>

    </div><!-- <col-md-12 -->

</div><!-- row -->

@endsection