@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Atividades do Ministério') }}
{{ \Session::put('subtitulo', 'Alteração / Visualização') }}
{{ \Session::put('route', 'atividadesministerios') }}
{{ \Session::put('id_pagina', '15') }}

<div class = 'row'>

    <div class="col-md-12">

        <div>
            <a href={{ url('/' . \Session::get('route')) }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
        </div>

        <form method = 'POST' class="form-horizontal"  action = {{ url('/' . \Session::get('route') . '/' . $dados->id . '/update')}}>

        {!! csrf_field() !!}

            <div class="box box-primary">

                 <div class="box-body"> <!--anterior box-body-->

                            <div class="row{{ $errors->has('ministerio') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="ministerio" class="control-label">Ministério</label>

                                          <select name="ministerio" class="form-control select2" style="width: 100%;">

                                          @foreach($ministerios as $item)
                                                <option  {{ ($item->id == $dados->ministerio_id ? 'selected' : '')  }} value="{{$item->id}}">{{$item->nome}}</option>
                                          @endforeach
                                          </select>
                                    </div>
                            </div>

                            <div class="row{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="nome" class="control-label">Descrição</label>

                                          <input id="nome" maxlength="60"  name = "nome" type="text" class="form-control" value="{{ $dados->nome }}">

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
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>

       </form>

    </div><!-- <col-md-12 -->

</div><!-- row -->

@endsection