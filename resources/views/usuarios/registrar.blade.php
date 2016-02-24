@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Usuários') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'usuarios') }}

<div class = 'row'>

    <div class="col-md-12">

        <div>
            <a href="{{ url('/usuarios')}}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
        </div>

        <form method = 'POST' class="form-horizontal" action = {{ url('/usuarios/gravar')}}>

        {!! csrf_field() !!}

            <div class="box box-primary">

                 <div class="box-body"> <!--anterior box-body-->

                            <div class="row{{ $errors->has('empresa') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="empresa" class="control-label">Igreja / Instituição</label>

                                          <select name="empresa" class="form-control select2" style="width: 100%;">
                                          <option  value="">(Selecione uma Igreja/Instituição</option>

                                          @foreach($empresas as $item)
                                                <option  value="{{$item->id}}">{{$item->razaosocial}}</option>
                                          @endforeach
                                          </select>

                                          <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('empresa'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('empresa') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>

                            <div class="row{{ $errors->has('grupo') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
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

                          <!--Somente usuário MASTER poderá criar usuários ADMIN-->
                          <input  name="admin" type="hidden"  value="0" />
                          @if ($dados_login->master==1)
                          <div class="row">
                                    <div class="col-xs-10">
                                          <label for="admin" class="control-label">É Administrador ?</label>

                                          <input  name="admin" type="checkbox" class="checkbox" value="1" />

                                    </div>
                          </div>
                          @endif

                            <div class="row{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="name" class="control-label">Nome</label>

                                          <input id="name" maxlength="50"  placeholder = "Campo Obrigatório" name = "name" type="text" class="form-control" value="{{ old('name') }}">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('name'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('name') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>

                            <div class="row{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="email" class="control-label">Email</label>

                                          <input id="email" maxlength="255"  placeholder = "Campo Obrigatório" name = "email" type="text" class="form-control" value="{{ old('email') }}">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('email'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('email') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>

                            <div class="row{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="password" class="control-label">Senha</label>

                                          <input id="password" maxlength="60" placeholder = "Campo Obrigatório" name = "password" type="password" class="form-control" value="">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('password'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('password') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>

                            <div class="row{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="password_confirmation" class="control-label">Confirmação Senha</label>

                                          <input id="password_confirmation" placeholder = "Campo Obrigatório" maxlength="60"  name = "password_confirmation" type="password" class="form-control" value="">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('password_confirmation'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>

                            <div class="row">
                                  <div class="col-xs-5">
                                          <label for="caminhologo" class="control-label">Foto</label>
                                          <input type="file" id="caminhologo" maxlength="255" name = "caminhologo" class="form-control" >
                                  </div>
                          </div>

            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit'>Gravar</button>
            <a href="{{ url('/usuarios')}}" class="btn btn-default">Cancelar</a>
        </div>

       </form>

    </div><!-- <col-md-12 -->

</div><!-- row -->
<script type="text/javascript">

  function

</script>
@endsection