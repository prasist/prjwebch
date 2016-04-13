@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Células / Pessoas') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'celulaspessoas') }}
{{ \Session::put('id_pagina', '45') }}

<div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href={{ url('/' . \Session::get('route')) }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

    <form method = 'POST'  class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/gravar')}}>

       {!! csrf_field() !!}

    <div class="box box-default">

          <div class="box-body">

                  <div class="row">

                        <div class="col-xs-11 {{ $errors->has('celulas') ? ' has-error' : '' }}">
                                @include('carregar_combos', array('dados'=>$celulas, 'titulo' =>'Célula', 'id_combo'=>'celulas', 'complemento'=>'', 'comparar'=>''))
                        </div>

                        <!-- se houver erros na validacao do form request -->
                        @if ($errors->has('celulas'))
                        <span class="help-block">
                            <strong>{{ $errors->first('celulas') }}</strong>
                        </span>
                        @endif

                  </div>

                  <div class="row">

                        <div class="col-xs-11 {{ $errors->has('pessoas') ? ' has-error' : '' }}">
                                <label for="pessoas" class="control-label">Pessoa</label>
                                <div class="input-group">
                                         <div class="input-group-addon">
                                            <button  id="buscarpessoa2" type="button"  data-toggle="modal" data-target="#modal_pessoas" >
                                                   <i class="fa fa-search"></i> ...
                                             </button>
                                         </div>

                                          @include('modal_buscar_pessoas', array('qual_campo'=>'pessoas', 'modal' => 'modal_pessoas'))

                                          <input id="pessoas"  name = "pessoas" type="text" class="form-control" placeholder="Clica na lupa ao lado para consultar uma pessoa" value="" readonly >

                                          <!-- se houver erros na validacao do form request -->
                                           @if ($errors->has('pessoas'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('pessoas') }}</strong>
                                            </span>
                                           @endif

                                  </div>
                         </div>

                  </div>

                  <div class="row">
                     <div class="col-xs-11">
                     <br/>
                        <button onclick="AddTableRow()" type="button" class="btn btn-info"><i class="fa fa-user-plus"></i> Adicionar</button>
                        <br/>
                        <br/>
                        <table id="example" class="table table-bordered table-hover">
                            <tbody>
                             <tr>
                               <th>Célula</th>
                               <th>Pessoa</th>
                               <th>Ação</th>
                             </tr>
                             <tr>
                               <td>&nbsp;</td>
                               <td>&nbsp;</td>
                               <td>&nbsp;</td>
                             </tr>
                            </tbody>

                        </table>
                       </div>
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

<script type="text/javascript">
    (function($) {
      AddTableRow = function() {

        /*Não deixa adicionar sem conteudo*/
        if (document.getElementById("pessoas").value=="")
        {
            return false;
        }

        var newRow = $("<tr>");
        var cols = "";
        var strCampos="";

        var ind_celula = document.getElementById("celulas").selectedIndex;
        var texto_celula = document.getElementById("celulas").options;

        var str_celula = texto_celula[ind_celula].text;
        var bEncontrou=false;


        /*Verifica se a pessoa já não foi adicionada*/
        $('input').each(function (index, value)
        {
               var nomecampo = $(this).attr('id');
               if (nomecampo=="hidden_pessoas[]")
               {
                   if ($(this).attr('value')==document.getElementById("pessoas").value)
                   {
                        alert('Pessoa já adicionada a esta célula');
                        bEncontrou=true;
                   }
               }

        });

        /*Se encontrou pessoa na listagem sai da rotina sem adicionar novamente*/
        if (bEncontrou==true)
        {
            return false;
        }

        strCampos = '<input id="hidden_celulas[]"  name = "hidden_celulas[]" type="hidden" value="' + document.getElementById("celulas").value + '">';
        strCampos += '<input id="hidden_pessoas[]"  name = "hidden_pessoas[]" type="hidden" value="' + document.getElementById("pessoas").value + '">';
        strCampos += '<input id="hidden_lider_celulas[]"  name = "hidden_lider_celulas[]" type="hidden" value="' + str_celula + '">';

        cols += '<td>' + str_celula + '</td>';
        cols += '<td>' + document.getElementById("pessoas").value + '</td>';
        cols += '<td>';
        cols += '<button data-toggle="tooltip" data-placement="top" title="Remover" type="submit" class="btn btn-danger btn-sm" onclick="RemoveTableRow(this)"><spam class="glyphicon glyphicon-trash"></spam></button>' + strCampos;
        cols += '</td>';

        newRow.append(cols);
        $("#example").append(newRow);
        document.getElementById("pessoas").value="";
        return false;
      };
    })(jQuery);

    (function($) {

      RemoveTableRow = function(handler) {
        var tr = $(handler).closest('tr');

        tr.fadeOut(400, function(){
          tr.remove();
        });

        return false;
      };
    })(jQuery);

</script>


@endsection