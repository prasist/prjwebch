@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Grupos de Usuário') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'grupos') }}


<div class = 'row'>

    <div class="col-md-12">

        <div>
            <a href="{{ url('/grupos')}}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
        </div>

        <form method = 'POST' class="form-horizontal" enctype="multipart/form-data" action = {{ url('/grupos/' . $grupos->id . '/update')}}>
            <!--<input type = 'hidden' name = '_token' value = '{{Session::token()}}'>-->
            {!! csrf_field() !!}

            <div class="box box-primary">

                 <div class="box-body"> <!--anterior box-body-->

                            <div class="row{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="nome" class="control-label">Nome Grupo</label>

                                          <input id="nome" maxlength="45"  name = "nome" type="text" class="form-control" value="{{ $grupos->nome }}">

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
            <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}>Gravar</button>
            <a href="{{ url('/grupos')}}" class="btn btn-default">Cancelar</a>
        </div>

       </form>

    </div><!-- <col-md-12 -->

</div><!-- row -->

@endsection