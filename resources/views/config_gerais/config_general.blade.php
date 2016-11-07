@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Configurações Gerais') }}
{{ \Session::put('subtitulo', 'Atualização') }}
{{ \Session::put('route', 'config_gerais') }}
{{ \Session::put('id_pagina', '70') }}


<div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href="{{ url('/' . \Session::get('route')) }}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

     <form method = 'POST' class="form-horizontal"  action = "{{ url('/' . \Session::get('route') . '/' . $dados[0]->id . '/update')}}">

       {!! csrf_field() !!}

        <div class="box box-primary">

                 <div class="box-body">

                            <!--
                            <div class="row">
                                    <div class="col-xs-10">
                                          <label for="padrao_textos" class="control-label">Padrão para gravação de conteúdo</label>
                                          <select id="padrao_textos" placeholder="(Selecionar)" name="padrao_textos" data-live-search="true" data-none-selected-text="Nenhum item selecionado" class="form-control" style="width: 100%;">
                                              <option  value="1">Primeira Letra Maiúscula De Cada Palavra</option>
                                              <option  value="2">todas minúsculas</option>
                                              <option  value="3">TODAS MAIÚSCULAS</option>
                                              <option  value="4" selected>Texto LiVrE</option>
                                          </select>
                                    </div>
                            </div>
                            -->

                           <div class="row">
                                    <div class="col-xs-6">
                                          <label for="label_celulas_singular" class="control-label">Nomenclatura Célula (Singular)</label>
                                          <input id="label_celulas_singular"  name = "label_celulas_singular" type="text" class="form-control" value="{{ $dados[0]->label_celulas_singular }}">
                                    </div>

                                    <div class="col-xs-6">
                                          <label for="label_celulas" class="control-label">Nomenclatura Células (Plural)</label>
                                          <input id="label_celulas"  name = "label_celulas" type="text" class="form-control" value="{{ $dados[0]->label_celulas }}">
                                    </div>
                           </div>

                           <div class="row">
                                    <div class="col-xs-6">
                                          <label for="label_encontros_singular" class="control-label">Nomenclatura Encontro (Singular)</label>
                                          <input id="label_encontros_singular"  name = "label_encontros_singular" type="text" class="form-control" value="{{ $dados[0]->label_encontros_singular }}">
                                    </div>

                                    <div class="col-xs-6">
                                          <label for="label_encontros" class="control-label">Nomenclatura Encontros (Plural)</label>
                                          <input id="label_encontros"  name = "label_encontros" type="text" class="form-control" value="{{ $dados[0]->label_encontros }}">
                                    </div>
                           </div>


                           <div class="row">
                                    <div class="col-xs-6">
                                          <label for="label_lider_singular" class="control-label">Nomenclatura Líder (Singular)</label>
                                          <input id="label_lider_singular"  name = "label_lider_singular" type="text" class="form-control" value="{{ $dados[0]->label_lider_singular }}">
                                    </div>

                                    <div class="col-xs-6">
                                          <label for="label_lider_plural" class="control-label">Nomenclatura Líderes (Plural)</label>
                                          <input id="label_lider_plural"  name = "label_lider_plural" type="text" class="form-control" value="{{ $dados[0]->label_lider_plural }}">
                                    </div>
                           </div>


                           <div class="row">
                                    <div class="col-xs-6">
                                          <label for="label_lider_treinamento" class="control-label">Nomenclatura Líder em Treinamento</label>
                                          <input id="label_lider_treinamento"  name = "label_lider_treinamento" type="text" class="form-control" value="{{ $dados[0]->label_lider_treinamento }}">
                                    </div>

                                    <div class="col-xs-6">
                                          <label for="label_anfitriao" class="control-label">Nomenclatura anfitrião</label>
                                          <input id="label_anfitriao"  name = "label_anfitriao" type="text" class="form-control" value="{{ $dados[0]->label_anfitriao }}">
                                    </div>
                           </div>


                           <div class="row">
                                    <div class="col-xs-6">
                                          <label for="label_participantes" class="control-label">Nomenclatura Participantes</label>
                                          <input id="label_participantes"  name = "label_participantes" type="text" class="form-control" value="{{ $dados[0]->label_participantes }}">
                                    </div>

                                    <div class="col-xs-6">
                                          <label for="label_lider_suplente" class="control-label">Nomenclatura Líder Suplente</label>
                                          <input id="label_lider_suplente"  name = "label_lider_suplente" type="text" class="form-control" value="{{ $dados[0]->label_lider_suplente }}">
                                    </div>
                           </div>


            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-save"></i> Salvar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>

        </form>

    </div>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_celulas").addClass("treeview active");
    });
</script>
@endsection