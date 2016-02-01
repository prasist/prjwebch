@extends('principal.master')

@section('content')

<div class = 'row'>

    <div class="col-md-12">

        <div>
            <i class="fa fa-arrow-circle-left"></i>
            <a href="{{ url('/grupos')}}" class="box-title"> Voltar </a>
        </div>

        <form method = 'POST' class="form-horizontal" enctype="multipart/form-data" action = {{ url('/grupos/' . $grupos->id . '/update')}}>
            <!--<input type = 'hidden' name = '_token' value = '{{Session::token()}}'>-->
            {!! csrf_field() !!}

            <div class="">

                 <div class="box-body"> <!--anterior box-body-->

                            <div class="row{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="nome" class="control-label">Nome Grupo</label>

                                          <input id="nome" maxlength="150"  name = "nome" type="text" class="form-control" value="{{ $grupos->nome }}">

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

    </div><!-- <col-md-12 -->

</div><!-- row -->

@endsection