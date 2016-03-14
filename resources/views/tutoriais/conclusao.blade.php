@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Tutoriais') }}
{{ \Session::put('subtitulo', 'Conclusão') }}
{{ \Session::put('route', 'quicktour') }}

<div class = 'row'>

    <div class="col-md-12">

        <form method = 'POST'  class="form-horizontal" action = {{ url('/' . \Session::get('route') . '/done')}}>
        {!! csrf_field() !!}

        <div class="row">
                <div class="col-md-12">
                  <div class="box">
                    <div class="box-header">

                        <div class="box-body">

                            <div id="tour8"></div>
                            <div id="tour9"></div>

                            <p>
                             Tour Rápido - Cadastro de Usuários concluído! <br/>
                             Clique no botão abaixo para confirmar e não exibir mais o Tour quando logar novamente.
                            </p>

                        </div>
                     </div>
                   </div>
                </div>

                <div class="box-footer">
                    <button class = 'btn btn-primary' type ='submit'>Confirmar Conclusão</button>
                </div>

         </div>
        </form>
      </div>
   </div>

@endsection