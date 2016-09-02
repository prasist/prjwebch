@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Avisos do Sistema') }}
{{ \Session::put('subtitulo', 'Avisos') }}
{{ \Session::put('route', 'home') }}
{{ \Session::put('id_pagina', '34') }}

<div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">


                <div class="content body">

                      <section id="introduction">
                        <h2 class="page-header"><a href="#introduction">{!!$dados->titulo!!}</a></h2>
                        <p class="lead">
                        {!!$dados->texto!!}
                        </p>
                      </section><!-- /#introduction -->

                </div>

            </div>
</div>
</div>
</div>


@endsection