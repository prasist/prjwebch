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
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-yellow">
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Pessoas</h3>
              <h5 class="widget-user-desc"></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="#">Membros <span class="pull-right badge bg-blue">31</span></a></li>
                <li><a href="#">Clientes <span class="pull-right badge bg-aqua">5</span></a></li>
                <li><a href="#">Fornecedores <span class="pull-right badge bg-green">12</span></a></li>
                <li><a href="#">Outros <span class="pull-right badge bg-red">842</span></a></li>

              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>

        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-green">
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Famílias</h3>
              <h5 class="widget-user-desc"></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="#">Total <span class="pull-right badge bg-blue">31</span></a></li>
                <li><a href="#">Chefe de Família <span class="pull-right badge bg-aqua">5</span></a></li>
                <li><a href="#">Crianças <span class="pull-right badge bg-green">12</span></a></li>
                <li><a href="#">Outros <span class="pull-right badge bg-red">842</span></a></li>

              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>

        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-blue">
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username">Células</h3>
              <h5 class="widget-user-desc"></h5>
            </div>
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="#">Total <span class="pull-right badge bg-blue">31</span></a></li>
                <li><a href="#">Participantes <span class="pull-right badge bg-aqua">5</span></a></li>
                <li><a href="#">Visitantes <span class="pull-right badge bg-green">12</span></a></li>

              </ul>
            </div>
          </div>
          <!-- /.widget-user -->
        </div>

   </div>

<div class="row">

   </div>

@endsection