@extends('principal.master')
@section('content')

{{ \Session::put('titulo', 'Dashboard Financeiro') }}
{{ \Session::put('subtitulo', 'Visão Geral') }}
{{ \Session::put('route', 'titulos') }}
{{ \Session::put('id_pagina', '54') }}



<!-- Small boxes (Stat box) -->

<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{$total_receber_aberto==0 ? "0,00" : $total_receber_aberto}}</h3>
                <p>Total À Receber (Em Aberto)</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-arrow-down"></i>
            </div>
            <a href="#" class="small-box-footer">Total do Mês (A/B) : <i class="fa fa-arrow-circle-right"></i> <h4>{{$total_receber_mes==0 ? "0,00" : $total_receber_mes}}</h4></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{$total_pagar_aberto==0 ? "0,00" : $total_pagar_aberto}}</h3>
                <p>Total À Pagar (Em Aberto)</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-arrow-up"></i>
            </div>
             <a href="#" class="small-box-footer">Total do Mês (A/B) : <i class="fa fa-arrow-circle-right"></i> <h4>{{$total_pagar_mes==0 ? "0,00" : $total_pagar_mes}}</h4></a>
        </div>
    </div><!-- ./col -->


    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{$saldo_contas==0 ? "0,00" : $saldo_contas}}</h3>
                <p>Saldo de Todas Contas</p>
            </div>
            <div class="icon">
                <i class="ion ion-social-usd"></i>
            </div>
        </div>

        <div class="row" class="list">
            <ul>
                @foreach($todas_contas as $item)
                       <li class="text-info">{!! $item->nome !!} - Saldo : {!! number_format($item->saldo_atual, 2, ',', '.') !!}</li>
                @endforeach
           </ul>
        </div>
    </div><!-- ./col -->


</div><!-- /.row -->

<div class="row">
    <div class="col-lg-3 col-xs-6">
            <a href="{{ url('/' . \Session::get('route') . '/registrar/R')}}"><i class="fa fa-arrow-up"></i> Incluir Nova Receita/Contas à Receber</a><br/>
            <a href="{{ url('/' . \Session::get('route') . '/R')}}"><i class="fa fa-list-ol"></i> Mostrar Lançamentos</a>
    </div>

    <div class="col-lg-3 col-xs-6">
            <a href="{{ url('/' . \Session::get('route') . '/registrar/P')}}"><i class="fa fa-arrow-down"></i> Incluir Nova Despesa/Contas à Pagar</a><br/>
            <a href="{{ url('/' . \Session::get('route') . '/P')}}"><i class="fa fa-list-ol"></i> Mostrar Lançamentos</a>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){

       $("#financ").addClass("treeview active");

    });

</script>

@endsection

