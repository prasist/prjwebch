@extends('principal.master')

@section('content')

<div class = 'row'>

    <div class="col-md-12">

        <div>
            <i class="fa fa-arrow-circle-left"></i>
            <a href="{{ url('/permissoes')}}" class="box-title"> Voltar </a>
        </div>

          <div class = 'row'>

                <div class="col-xs-3">
                      <td>{{$grupos['grupos']->id_grupo}}</td>
                      <td>{{$grupos['grupos']->nome}}</td>
               </div>
           </div>


           @foreach($permissoes as $item)

                        <div class = 'row'>

                              <div class="col-xs-3">
                                    <td>{{$item['items']->id_pagina}}</td>
                                    <td>{{$item->items->nome}}</td>
                                    <td>{{$item->items->incluir}}</td>
                                    <td>{{$item->items->alterar}}</td>
                                    <td>{{$item->items->excluir}}</td>
                                    <td>{{$item->items->visualizar}}</td>
                                    <td>{{$item->items->exportar}}</td>
                                    <td>{{$item->items->imprimir}}</td>
                             </div>
                         </div>

          @endforeach


    </div><!-- <col-md-12 -->

</div><!-- row -->

@endsection