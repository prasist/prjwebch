@extends('principal.master')

@section('content')

<div class = 'row'>

    <div class="col-md-12">

        <form method = 'POST' class="form-horizontal" enctype="multipart/form-data" action = {{ url('/cliente/' . $clientes_cloud->id . '/update')}}>
            <!--<input type = 'hidden' name = '_token' value = '{{Session::token()}}'>-->
            {!! csrf_field() !!}

            <div class="box box-primary">

                 <div class="box-body">

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
                                        <a href="#compl" role="tab" data-toggle="tab">
                                            <i class="fa fa-cog"></i> Complementos
                                        </a>
                                   </li>
                          </ul>

                              <!-- Tab panes -->
                              <!-- DADOS CADASTRAIS-->
                           <div class="tab-content">

                                  <div class="tab-pane fade active in" id="home">

                                        <br/>

                                        <div class="row{{ $errors->has('razaosocial') ? ' has-error' : '' }}">
                                                <div class="col-xs-10">
                                                      <label for="razaosocial" class="control-label">Razão Social</label>

                                                      <input id="razaosocial" maxlength="150"  name = "razaosocial" type="text" class="form-control" value="{{ $clientes_cloud->razaosocial }}">

                                                         <!-- se houver erros na validacao do form request -->
                                                         @if ($errors->has('razaosocial'))
                                                          <span class="help-block">
                                                              <strong>{{ $errors->first('razaosocial') }}</strong>
                                                          </span>
                                                         @endif

                                                </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-10">
                                                    <label for="nomefantasia" class="control-label">Nome Fantasia</label>
                                                    <input id="nomefantasia" maxlength="100" name = "nomefantasia" type="text" class="form-control" value="{{$clientes_cloud->nomefantasia}}">
                                            </div>
                                        </div>

                                        <div class="row">

                                                <div class="col-xs-3">
                                                       <label for="cnpj" class="control-label">CNPJ</label>
                                                       <input id="cnpj" data-inputmask='"mask": "99.999.999/9999-99"' data-mask name = "cnpj" type="text" class="form-control" value="{{$clientes_cloud->cnpj}}">
                                                </div>

                                                <div class="col-xs-3">
                                                     <label for="inscricaoestadual" class="control-label">Inscr. Estadual</label>
                                                     <input id="inscricaoestadual"  maxlength="15" name = "inscricaoestadual" type="text" class="form-control" value="{{$clientes_cloud->inscricaoestadual}}">
                                                </div>

                                                <div class="col-xs-3">
                                                    <label for="foneprincipal" class="control-label">Fone Principal</label>

                                                    <div class="input-group{{ $errors->has('foneprincipal') ? ' has-error' : '' }}">
                                                           <div class="input-group-addon">
                                                            <i class="fa fa-phone"></i>
                                                            </div>

                                                            <input id="foneprincipal" name = "foneprincipal" type="text" class="form-control" value="{{$clientes_cloud->foneprincipal}}"  data-inputmask='"mask": "(99) 9999-9999"' data-mask >

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

                                                                <input id="fonesecundario" name = "fonesecundario" type="text" class="form-control" data-inputmask='"mask": "(99) 9999-9999"' data-mask  value="{{$clientes_cloud->fonesecundario}}">
                                                        </div>

                                                 </div>

                                         </div>


                                        <div class="row">
                                                <div class="col-xs-3">
                                                    <label for="nomecontato" class="control-label">Contato</label>
                                                    <input id="nomecontato" maxlength="45" name = "nomecontato" type="text" class="form-control" value="{{$clientes_cloud->nomecontato}}">
                                                </div>

                                                <div class="col-xs-3">
                                                    <label for="celular" class="control-label">Celular</label>

                                                    <div class="input-group">
                                                               <div class="input-group-addon">
                                                                <i class="fa fa-phone"></i>
                                                                </div>
                                                                <input id="celular" data-inputmask='"mask": "(99) 9999-9999"' data-mask  name = "celular" type="text" class="form-control" value="{{$clientes_cloud->celular}}">
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
                                                                    <input id="emailprincipal" maxlength="150" name = "emailprincipal" type="text" class="form-control" value="{{$clientes_cloud->emailprincipal}}">

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
                                                                    <input id="emailsecundario" maxlength="150" name = "emailsecundario" type="text" class="form-control" value="{{$clientes_cloud->emailsecundario}}">

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
                                 <div class="tab-pane fade" id="endereco">
                                    <br/>

                                     <div class="row">
                                            <div class="col-xs-7">
                                                    <label for="endereco" class="control-label">Endereço</label>
                                                    <input id="endereco" maxlength="150" name = "endereco" type="text" class="form-control" value="{{$clientes_cloud->endereco}}">
                                            </div>

                                            <div class="col-xs-2">
                                                    <label for="numero" class="control-label">Número</label>
                                                    <input id="numero" maxlength="10" name = "numero" type="text" class="form-control" value="{{$clientes_cloud->numero}}">
                                            </div>
                                    </div>

                                    <div class="row">
                                            <div class="col-xs-7">
                                                  <label for="bairro" class="control-label">Bairro</label>
                                                  <input id="bairro" maxlength="50" name = "bairro" type="text" class="form-control" value="{{$clientes_cloud->bairro}}">
                                             </div>

                                            <div class="col-xs-2">
                                                 <label for="cep" class="control-label">CEP</label>
                                                 <input id="cep" maxlength="8" name = "cep" type="text" class="form-control" value="{{$clientes_cloud->cep}}">
                                            </div>

                                    </div>


                                    <div class="row">
                                            <div class="col-xs-9">
                                                <label for="complemento" class="control-label">Complemento</label>
                                                <input id="complemento" name = "complemento" type="text" class="form-control" value="{{$clientes_cloud->complemento}}">
                                            </div>
                                    </div>

                                    <div class="row">
                                            <div class="col-xs-7">
                                                    <label for="cidade" class="control-label">Cidade</label>
                                                    <input id="cidade" maxlength="60" name = "cidade" type="text" class="form-control" value="{{$clientes_cloud->cidade}}">
                                            </div>

                                            <div class="col-xs-2">
                                                <label for="estado" class="control-label">Estado</label>
                                                <input id="estado" maxlength="2" name = "estado" type="text" class="form-control" value="{{$clientes_cloud->estado}}">
                                            </div>
                                    </div>
                             </div><!-- FIM TAB ENDERECO-->


                                <!-- TAB COMPLEMENTO-->
                                <div class="tab-pane fade" id="compl">
                                    <br/>

                                    <!--
                                    <div class="row">
                                            <div class="col-xs-1">
                                                    <label for="ativo" class="control-label">Ativo</label>
                                                    <input id="ativo" maxlength="1" name = "ativo" type="text" class="form-control" value="{{$clientes_cloud->ativo}}" >
                                            </div>
                                    </div>
                                    -->

                                    <div class="row">
                                            <div class="col-xs-9">
                                                <label for="website" class="control-label">Website</label>
                                                <input id="website" maxlength="255" name = "website" type="text" class="form-control" value="{{$clientes_cloud->website}}">
                                            </div>
                                    </div>

                                    <div class="row">
                                            <div class="col-xs-9">
                                                    <label for="caminhologo" class="control-label">Logo</label>
                                                    <input type="file" id="caminhologo" maxlength="255" name = "caminhologo" class="form-control" >
                                            </div>
                                    </div>

                                    @if ($clientes_cloud->caminhologo!="")
                                    <div class="row">
                                        <div class="col-xs-9">
                                              <img src="{{ url('/images/clients/' . $clientes_cloud->caminhologo) }}" width="200px" height="100px">
                                        </div>
                                        <a href="{{ url('/cliente/' . $clientes_cloud->id . '/remover')}}">Remover Imagem</a>
                                    </div>
                                    @endif

                                </div><!--  FIM TAB COMPLEMENTO-->

                         </div><!-- Fim tab panes-->

            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit'>Gravar</button>
            <button class = 'btn btn-default' >Voltar</button>
        </div>

       </form>

    </div><!-- <col-md-12 -->

</div><!-- row -->

@endsection