@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Relatório de Pessoas') }}
{{ \Session::put('subtitulo', 'Listagem') }}
{{ \Session::put('route', 'relpessoas') }}
{{ \Session::put('id_pagina', '47') }}

<div class = 'row'>

 <div class="col-md-12">

    <button class = 'btn btn-primary' type ='button' onclick="javascript: history.back();">Voltar</button>

    <div class="box box-default">

          <div class="box-body">

            <div class="row">
                <div class="col-md-12">
                     @if ($emails)
                      <div class="row">
                            <div class="col-xs-12">
                            <p>
                            Filtros Utilizados : {!! $filtros !!}

                            @if ($emails)
                            <br/>
                            @if ($resultado=="email")
                                <b>Atenção, o resultado retornará somente pessoas que tenham o email cadastrado.</b>
                                <b>No campo abaixo, tecle CTRL + A para selecionar os emails e CTRL + C para copiar.</b>
                            @else
                                <b>Atenção, o resultado retornará somente pessoas que tenham o telefone celular cadastrado.</b>
                            @endif
                            <br/>
                            @endif
                            </p>
                            <br/>
                            @if ($emails)

                                @if ($resultado=="email")
                                    <textarea class="form-control" rows="30">
                                    @foreach($emails as $item)
                                          {!! $item->razaosocial . ' <' . $item->emailprincipal . '>'!!},
                                    @endforeach
                                    </textarea>
                               @else
                                    <textarea class="form-control" rows="15" name="telefone" id="telefone">@foreach($emails as $item) @if (rtrim(ltrim($item->fone_celular))!="")  {!! $item->fone_celular !!}; @endif @endforeach</textarea>
                               @endif
                           @else
                              <b>Nenhum Registro Encontrado ou Email/Celular não preenchido no cadastro da Pessoa.</b>
                           @endif

                            </div>
                      </div>
                      @else
                          <b>Nenhum Registro Encontrado ou Email/Celular não preenchido no cadastro da Pessoa.</b>
                      @endif

                </div><!-- /.col -->
            </div><!-- /.row -->

            @if ($resultado=="celular")

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

                                <textarea name="mensagem" class="form-control" rows="2" placeholder="Digite a mensagem..." ></textarea>

                                   <!-- se houver erros na validacao do form request -->
                                   @if ($errors->has('mensagem'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mensagem') }}</strong>
                                    </span>
                                   @endif

                          </div>
                  </div>

                  <div class="box-footer">
                      <a href="{{ url('/mensagens/enviar')}}" class="btn btn-info">Enviar Mensagem</a>
                 </div>

            @endif


         </div><!-- fim box-body"-->
     </div><!-- box box-primary -->

      <div class="box-footer">
          <button class = 'btn btn-primary' type ='button' onclick="javascript: history.back();">Voltar</button>
      </div>

    </div>

</div>

@endsection