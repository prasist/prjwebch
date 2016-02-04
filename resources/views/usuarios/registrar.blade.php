@extends('principal.master')

@section('content')

<div class = 'row'>

    <div class="col-md-12">

        <div>
            <a href="{{ url('/users')}}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
        </div>

        <form method = 'POST' class="form-horizontal" action = {{ url('/users/gravar')}}>

        {!! csrf_field() !!}

            <div class="box box-primary">

                 <div class="box-body"> <!--anterior box-body-->

                            <div class="row{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="name" class="control-label">Nome</label>

                                          <input id="name" maxlength="255"  name = "name" type="text" class="form-control" value="{{ old('name') }}">

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

                                          <input id="email" maxlength="255"  name = "nome" type="text" class="form-control" value="{{ old('email') }}">

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

                                          <input id="password" maxlength="60"  name = "password" type="password" class="form-control" value="">

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

                                          <input id="password_confirmation" maxlength="60"  name = "password_confirmation" type="password" class="form-control" value="">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('password_confirmation'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>



            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit'>Gravar</button>
            <a href="{{ url('/users')}}" class="btn btn-default">Cancelar</a>
        </div>

       </form>

    </div><!-- <col-md-12 -->

</div><!-- row -->

@endsection