@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Login Membros') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'loginmembro') }}

<div class = 'row'>

    <div class="col-md-12">

        <div>
            <a href="{{ url('/loginmembro')}}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
        </div>

        <form method = 'POST' class="form-horizontal" enctype="multipart/form-data"  action = "{{ url('/loginmembro/gravar')}}">

        {!! csrf_field() !!}

            <div class="box box-primary">

                 <div class="box-body"> <!--anterior box-body-->


                          <div class="row{{ $errors->has('grupo') ? ' has-error' : '' }}">
                                  <div class="col-xs-10">
                                        <label for="grupo" class="control-label">Grupo</label>

                                        <select name="grupo" class="form-control select2" style="width: 100%;">

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

                          <div class="row">
                                  <div class="col-xs-5">

                                        <label for="gerar" class="control-label">Como gerar a senha</label>
                                        <select id="gerar" name="gerar" data-live-search="true" data-none-selected-text="(Selecionar)" class="form-control selectpicker" style="width: 100%;">
                                            <option  value="1">6 Primeiros dígitos CPF (Ou 6 dígitos iniciais do telefone ou 6 mês e ano nascimento (mmaaaa))</option>
                                            <option  value="2">Senha Específica</option>
                                        </select>
                                  </div>
                          </div>

                          <div class="row" style="display: none">
                                  <div class="col-xs-5">
                                          <label for="password" class="control-label">Senha Específica</label>
                                          <input id="password" maxlength="60" placeholder = "Informar um senha..." name = "password" type="password" class="form-control" value="">
                                  </div>
                          </div>






            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' id='gravar'>Gravar</button>
            <a href="{{ url('/loginmembro')}}" class="btn btn-default">Cancelar</a>
        </div>

       </form>

    </div><!-- <col-md-12 -->

</div><!-- row -->
@endsection