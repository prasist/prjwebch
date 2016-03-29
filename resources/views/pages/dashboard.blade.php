@extends('principal.master')
@section('content')
<!-- Small boxes (Stat box) -->

<div class="row">
    <div class="col-lg-3 col-xs-6">
    <div id="tour1_visaogeral"></div>
    <div id="tour3_visaogeral"></div>
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{$total_pessoas}}</h3>
                <p>Pessoas Cadastradas</p>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">Mais <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{$total_membros}}</h3>
                <p>Membros</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">Mais... <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{$total_aniversariantes}}</h3>
                <p>Aniversariantes no mês</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">Mais... <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
            <div  class="inner">
                <h3>{{$total_inativos}}</h3>
                <p>Cadastros Inativos</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">Mais... <i class="fa fa-arrow-circle-right"></i></a>
        </div>



    </div><!-- ./col -->
</div><!-- /.row -->

@endsection