@extends('principal.master')
@section('content')

{{ \Session::put('titulo', 'Dashboard Células') }}
{{ \Session::put('subtitulo', 'Visão Geral') }}
{{ \Session::put('route', 'celulas') }}
{{ \Session::put('id_pagina', '42') }}



<!-- Small boxes (Stat box) -->

<div class="row">
      <div class="col-lg-12 col-xs-8">
            <div class="box box-primary">
                  <div class="box-header with-border">
                          <h5 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#tab2">
                              <span class="fa fa-search"></span> Filtros
                            </a>
                          </h5>
                  </div>


            </div>
      </div>
</div>

<div class="row">
    <div class="col-lg-12 col-xs-8">
            <div class="nav-tabs-custom">

              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Gráficos</a></li>
                <li><a href="#tab_2" data-toggle="tab">Relatórios Estatísticos</a></li>
              </ul>

              <div class="tab-content">
                        <!-- TABS-->
                        <div class="tab-pane active" id="tab_1">

                                <div class="row">

                                      <div class="col-lg-5 col-xs-8">
                                              <div class="inner">
                                                   <center><h4>% Frequência</h4>
                                                    <p>Últimos 4 meses</p>
                                                   </center>

                                              </div>

                                              <div id="frequencia" style="height: 250px;"></div>
                                      </div>

                                      <div class="col-lg-5 col-xs-8">
                                              <div class="inner">
                                                   <center><h4>Quantidade de Visitantes (4 Meses)</h4>
                                                   <p>Últimos 4 meses</p>
                                                   </center>
                                              </div>
                                              <div id="visitantes" style="height: 250px;"></div>
                                      </div>

                                </div><!-- /.row -->

                        </div><!-- /.tab-pane -->

                        <div class="tab-pane" id="tab_2">

                        </div>
                        <!--  END TABS-->

             </div> <!-- TAB CONTENTS -->

          </div> <!-- nav-tabs-custom -->
    </div>

</div>

<script type="text/javascript">

    $(document).ready(function(){

       $("#menu_celulas").addClass("treeview active");

       Morris.Bar({
        element: 'visitantes',
        data: [
          { y: 'Maio', a: 5 },
          { y: 'Junho', a: 3 },
          { y: 'Julho', a: 7 },
          { y: 'Agosto', a: 2 }
        ],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Visitantes']
      });


      var months = ["Maio", "Junho", "Julho", "Agosto"];

      Morris.Line({
        element: 'frequencia',
        data: [{
          m: '2015-01', // <-- valid timestamp strings
          a: 75
        }, {
          m: '2015-02',
          a: 70
        }, {
          m: '2015-03',
          a: 89
        }, {
          m: '2015-04',
          a: 86
        }, ],
        xkey: 'm',
        ykeys: ['a' ],
        labels: ['% Frequencia'],
        xLabelFormat: function(x) { // <--- x.getMonth() returns valid index
          var month = months[x.getMonth()];
          return month;
        },
        dateFormat: function(x) {
          var month = months[new Date(x).getMonth()];
          return month;
        },
      });


     });



</script>

@endsection