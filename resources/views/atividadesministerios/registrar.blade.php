@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Atividades do Ministério') }}
{{ \Session::put('subtitulo', 'Inclusão') }}
{{ \Session::put('route', 'atividadesministerios') }}
{{ \Session::put('id_pagina', '15') }}

    <div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href={{ url('/' . \Session::get('route')) }} class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

     <form method = 'POST'  class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/gravar')}}>

       {!! csrf_field() !!}

        <div class="box box-primary">

                 <div class="box-body">

                          <div class="row{{ $errors->has('ministerio') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">
                                          <label for="ministerio" class="control-label">Ministério</label>

                                          <select name="ministerio" class="form-control select2" style="width: 100%;">

                                          @foreach($dados as $item)
                                                <option  value="{{$item->id}}">{{$item->nome}}</option>
                                          @endforeach
                                          </select>
                                    </div>
                          </div>

                            <div class="row{{ $errors->has('nome') ? ' has-error' : '' }}">
                                    <div class="col-xs-10">

                                              <table class="table table-bordered table-hover" id="tab_logic">
                                                    <thead>
                                                      <tr >
                                                          <th class="text-center">#</th>
                                                          <th class="text-center">Atividades do Ministério</th>
                                                      </tr>
                                                    </thead>

                                                    <tbody>

                                                        <tr id='addr0'>
                                                            <td>1</td>
                                                            <td><input  maxlength="60"  placeholder="Campo Obrigatório" name = "nome[]" type="text" class="form-control" value="{{ old('nome') }}"></td>
                                                        </tr>
                                                        <tr id='addr1'></tr>

                                                      </tbody>

                                                  </table>

                                           <a id="add_row" class="btn btn-default pull-left">Adicionar Linha</a>
                                           <a id='delete_row' class="pull-right btn btn-default">Remover Linha</a>

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

       $(document).ready(function()
       {
            var i=1;
           $("#add_row").click(function()  {

              $('#addr'+i).html("<td>"+ (i+1) +"</td><td><input name='nome["+i+"]' type='text' placeholder='Descrição' class='form-control input-md'  /> </td>");

              $('#tab_logic').append('<tr id="addr'+(i+1)+'"></tr>');
              i++;
        });
           $("#delete_row").click(function(){
             if(i>1){
           $("#addr"+(i-1)).html('');
           i--;
           }
         });

      });
</script>

@endsection