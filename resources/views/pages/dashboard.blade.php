@extends('principal.master')
@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>12</h3>
                <p>Novos Membros</p>
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
                <h3>5<sup style="font-size: 20px">%</sup></h3>
                <p>Novas Células</p>
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
                <h3>44</h3>
                <p>Aniversariantes</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">Mais... <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div  class="inner">
                <h3>65</h3>
                <p>Visitantes</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">Mais... <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div><!-- ./col -->
</div><!-- /.row -->

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-7 connectedSortable">

        <!-- Custom tabs (Charts with tabs)-->
        <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
                <li class="active"><a href="#revenue-chart" data-toggle="tab">Gráfico Area</a></li>
                <li><a href="#sales-chart" data-toggle="tab">Gráfico Donut</a></li>
                <li class="pull-left header"><i class="fa fa-inbox"></i> Contribuições</li>
            </ul>
            <div class="tab-content no-padding">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
                <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
            </div>
        </div><!-- /.nav-tabs-custom -->



    </section><!-- /.Left col -->
    <!-- right col (We are only adding the ID to make the widgets sortable)-->
    <section class="col-lg-5 connectedSortable">
        <!-- Map box -->

        <!-- /.box -->
        <!-- solid sales graph -->
        <div class="box box-solid bg-teal-gradient">
            <div class="box-header">
                <i class="fa fa-th"></i>
                <h3 class="box-title">Sales Graph</h3>
                <div class="box-tools pull-right">
                    <button class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body border-radius-none">
                <div class="chart" id="line-chart" style="height: 250px;"></div>
            </div><!-- /.box-body -->


        </div><!-- /.box -->

    </section><!-- right col -->

</div><!-- /.row (main row) -->

<script type="text/javascript">

    $(function () {
            /* Morris.js Charts */
          // Sales chart
          var area = new Morris.Area({
            element: 'revenue-chart',
            resize: true,
            data: [
              {y: '2011 Q1', item1: 2666, item2: 2666},
              {y: '2011 Q2', item1: 2778, item2: 2294},
              {y: '2011 Q3', item1: 4912, item2: 1969},
              {y: '2011 Q4', item1: 3767, item2: 3597},
              {y: '2012 Q1', item1: 6810, item2: 1914},
              {y: '2012 Q2', item1: 5670, item2: 4293},
              {y: '2012 Q3', item1: 4820, item2: 3795},
              {y: '2012 Q4', item1: 15073, item2: 5967},
              {y: '2013 Q1', item1: 10687, item2: 4460},
              {y: '2013 Q2', item1: 8432, item2: 5713}
            ],
            xkey: 'y',
            ykeys: ['item1', 'item2'],
            labels: ['Item 1', 'Item 2'],
            lineColors: ['#a0d0e0', '#3c8dbc'],
            hideHover: 'auto'
          });
          var line = new Morris.Line({
            element: 'line-chart',
            resize: true,
            data: [
              {y: '2011 Q1', item1: 2666},
              {y: '2011 Q2', item1: 2778},
              {y: '2011 Q3', item1: 4912},
              {y: '2011 Q4', item1: 3767},
              {y: '2012 Q1', item1: 6810},
              {y: '2012 Q2', item1: 5670},
              {y: '2012 Q3', item1: 4820},
              {y: '2012 Q4', item1: 15073},
              {y: '2013 Q1', item1: 10687},
              {y: '2013 Q2', item1: 8432}
            ],
            xkey: 'y',
            ykeys: ['item1'],
            labels: ['Item 1'],
            lineColors: ['#efefef'],
            lineWidth: 2,
            hideHover: 'auto',
            gridTextColor: "#fff",
            gridStrokeWidth: 0.4,
            pointSize: 4,
            pointStrokeColors: ["#efefef"],
            gridLineColor: "#efefef",
            gridTextFamily: "Open Sans",
            gridTextSize: 10
          });

          //Donut Chart
          var donut = new Morris.Donut({
            element: 'sales-chart',
            resize: true,
            colors: ["#3c8dbc", "#f56954", "#00a65a"],
            data: [
              {label: "Download Sales", value: 12},
              {label: "In-Store Sales", value: 30},
              {label: "Mail-Order Sales", value: 20}
            ],
            hideHover: 'auto'
          });

          //Fix for charts under tabs
          $('.box ul.nav a').on('shown.bs.tab', function () {
            area.redraw();
            donut.redraw();
            line.redraw();
          });

});
</script>
@endsection