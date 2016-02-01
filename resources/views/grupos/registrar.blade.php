@extends('principal.master')

@section('content')

<div class = 'row'>

    <div class="col-md-12">

        <form method = 'POST'  class="form-horizontal" action = {{ url('/grupos/gravar')}}>
            <!--<input type = 'hidden' name = '_token' value = '{{Session::token()}}'>-->
            {!! csrf_field() !!}

        <div class="box box-primary">

                 <div class="box-body">

                            <div class="row{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="nome" class="control-label">Nome Grupo</label>

                                          <input id="nome" maxlength="150"  placeholder="Campo Obrigatório" name = "nome" type="text" class="form-control" value="{{ old('nome') }}">

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('nome'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('nome') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>


            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit'>Gravar</button>
        </div>

        </form>

    </div>

</div>

@endsection