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

<div class="row">
        <div class="col-md-10">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-gray">
              <h4 class="widget-user-username">Resumo Geral</h4>
            </div>
            <div class="box-footer no-padding">
            <h4>&nbsp;&nbsp;&nbsp;&nbsp;Pessoas</h4>
              <ul class="nav nav-stacked">

               @foreach($pessoas_tipos as $item)
                <li>
                    <a href="#">&nbsp;{!! $item->nome !!}
                        <span class="pull-left badge bg-blue">{!! $item->total !!}</span>
                    </a>
                </li>
                @endforeach

              </ul>

              <h4>&nbsp;&nbsp;&nbsp;&nbsp;Células</h4>
              <ul class="nav nav-stacked">

                <li>
                    <a href="#">&nbsp;Células Ativas
                        <span class="pull-left badge bg-blue">{!! $total_celulas !!}</span>
                    </a>
                </li>

                <li>
                    <a href="#">&nbsp;Participantes
                        <span class="pull-left badge bg-blue">{!! $total_participantes !!}</span>
                    </a>
                </li>

              </ul>

              <h4>&nbsp;&nbsp;&nbsp;&nbsp;Famílias</h4>
              <ul class="nav nav-stacked">

                <li>
                    <a href="#">&nbsp;Total
                        <span class="pull-left badge bg-blue">{!! $total_familias !!}</span>
                    </a>
                </li>

              </ul>

            </div>
          </div>
          <!-- /.widget-user -->
        </div>

   </div>

<div class="row">

   </div>

@endsection