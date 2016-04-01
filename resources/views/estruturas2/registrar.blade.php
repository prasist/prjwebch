@extends('principal.master')

@section('content')

{{ \Session::put('titulo', Session::get('nivel2')) }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'estruturas2') }}
{{ \Session::put('id_pagina', '37') }}

<div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href={{ url('/' . \Session::get('route')) }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

    <form method = 'POST'  class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/gravar')}}>

       {!! csrf_field() !!}

        <div class="box box-primary">

                 <div class="box-body">

                            <div class="row">
                                    <div class="col-xs-5">
                                          <label for="nome" class="control-label">Descrição</label>
                                          <input id="nome" maxlength="60"  placeholder="Descrição Alternativa" name = "nome" type="text" class="form-control" value="">
                                    </div>

                                    <div class="col-xs-5">
                                       @include('carregar_combos', array('dados'=>$nivel1, 'titulo' =>Session::get('nivel1'), 'id_combo'=>'nivel1', 'complemento'=>'', 'comparar'=>''))
                                    </div><!-- col-xs-5-->

                                    <div class="col-xs-5">
                                       @include('carregar_combos', array('dados'=>$pessoas, 'titulo' =>'Pessoa', 'id_combo'=>'pessoa', 'complemento'=>'', 'comparar'=>''))
                                    </div><!-- col-xs-5-->

                            </div>

            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit'>Gravar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>

        </form>

    </div>

</div>

@endsection