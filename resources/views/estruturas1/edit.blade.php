@extends('principal.master')

@section('content')

{{ \Session::put('titulo', Session::get('nivel1')) }}
{{ \Session::put('subtitulo', 'Alteração/Visualização') }}
{{ \Session::put('route', 'estruturas1') }}
{{ \Session::put('id_pagina', '36') }}

<div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href={{ url('/' . \Session::get('route')) }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

    <form method = 'POST' class="form-horizontal"  action = {{ url('/' . \Session::get('route') . '/' . $dados[0]->id . '/update')}}>

       {!! csrf_field() !!}

        <div class="box box-primary">

                 <div class="box-body">

                            <div class="row">
                                    <div class="col-xs-5">
                                          <label for="nome" class="control-label">Descrição</label>
                                          <input id="nome" maxlength="60"  placeholder="Descrição Alternativa" name = "nome" type="text" class="form-control" value="{{ $dados[0]->nome }}">
                                    </div>

                                    <div class="col-xs-5">
                                       @include('carregar_combos', array('dados'=>$pessoas, 'titulo' =>'Pessoa', 'id_combo'=>'pessoa', 'complemento'=>'', 'comparar'=>$dados[0]->pessoas_id))
                                    </div><!-- col-xs-5-->

                            </div>

            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}>Gravar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>

        </form>

    </div>

</div>

@endsection