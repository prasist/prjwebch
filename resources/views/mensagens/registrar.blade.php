@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Mensagens') }}
{{ \Session::put('subtitulo', 'Envio') }}
{{ \Session::put('route', 'mensagens') }}
{{ \Session::put('id_pagina', '59') }}

<div class = 'row'>

    <div class="col-md-12">

        <div>
            <a href={{ url('/' . \Session::get('route')) }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
        </div>

        <form method = 'POST' class="form-horizontal"  action = "{{ url('/' . \Session::get('route') . '/' .  'enviar')}}">

        {!! csrf_field() !!}

            <div class="box box-primary">

                 <div class="box-body"> <!--anterior box-body-->

                          <div class="row">
                                      <div class="col-xs-10">
                                          <label for="lista" class="control-label">Tema padrão</label>
                                          <select id="lista" placeholder="(Selecionar)" name="lista" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control selectpicker" style="width: 100%;">
                                                <option  value=""></option>
                                                <option  value="1">Aniversariantes</option>
                                                <option  value="2">Aniversario de Casamento</option>
                                                <option  value="3">Aniversario de Batismo</option>
                                                <option  value="4">Visitantes</option>
                                                <option  value="5">Parabenização Batismo</option>
                                                <option  value="6">Parabenização Conclução Curso</option>
                                          </select>
                                      </div>
                          </div>

                            <div class="row{{ $errors->has('mensagem') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="mensagem" class="control-label">Mensagem</label>

                                          <textarea name="mensagem" class="form-control" rows="2" placeholder="Digite a mensagem..." >Olá |nome|, ficamos muito felizes com sua visita, esperamos vê-lo em breve. </textarea>

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('mensagem'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('mensagem') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>

                            <div class="row{{ $errors->has('telefone') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="telefone" class="control-label">Telefone(s)</label>

                                          <textarea name="telefone" class="form-control" rows="2" placeholder="Informe o(s) número(s) de telefone(s)..." ></textarea>

                                             <!-- se houver erros na validacao do form request -->
                                             @if ($errors->has('telefone'))
                                              <span class="help-block">
                                                  <strong>{{ $errors->first('telefone') }}</strong>
                                              </span>
                                             @endif

                                    </div>
                            </div>


            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' ><i class="fa fa-save"></i> Enviar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>

       </form>

    </div><!-- <col-md-12 -->

</div><!-- row -->

@endsection