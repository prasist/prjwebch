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


<div class="row">
    <div class="col-md-12">

     <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Visão Geral</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget">

                <div class="box-footer no-padding">

                 <div class="row">

                        <div class="col-xs-3">
                              <h4>&nbsp;&nbsp;&nbsp;&nbsp;Células</h4>
                              <ul class="nav nav-stacked">

                                    <li>
                                        <a href="#">&nbsp;Células Ativas
                                            <span class="pull-left badge bg-blue">{!! $total_celulas !!}</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">Participantes :
                                            <small class="label pull-right bg-green">{!! $resumo_geral[0]->total !!}</small>
                                        </a>

                                        <ul style="list-style-type:none">
                                            @foreach($resumo_tipo_pessoas as $item)
                                            <li>
                                                {!! $item->nome !!}
                                                    <small class="label pull-right bg-blue">{!! $item->total !!}</small>
                                            </li>
                                            @endforeach

                                        </ul>
                                    </li>



                                   <h4>&nbsp;&nbsp;&nbsp;&nbsp;Por Faixa Etária</h4>

                                    @foreach($celulas_faixas as $item)
                                    <li>
                                        <a href="#">&nbsp;{!! $item->nome !!}
                                            <span class="pull-left badge bg-blue">{!! $item->total !!}</span>
                                        </a>
                                    </li>
                                    @endforeach

                                    <h4>&nbsp;&nbsp;&nbsp;&nbsp;Público Alvo</h4>

                                    @foreach($celulas_publicos as $item)
                                    <li>
                                        <a href="#">&nbsp;{!! $item->nome !!}
                                            <span class="pull-left badge bg-blue">{!! $item->total !!}</span>
                                        </a>
                                    </li>
                                    @endforeach

                                </ul>
                          </div>

                          <div class="col-xs-6">
                              <h4>&nbsp;&nbsp;&nbsp;&nbsp;Resumo Encontros (Mês Corrente)</h4>
                              <ul class="nav nav-stacked">

                                    <li>
                                        <a href="#">&nbsp;Total Geral Presentes
                                            <small class="label pull-right bg-green">{!! $resumo[0]->total_geral !!}</small>
                                        </a>
                                    </li>

                                    <ul style="list-style-type:none">
                                          <li>
                                              Visitantes
                                                  <small class="label pull-right bg-blue">{!! $resumo[0]->total_visitantes !!}</small>
                                          </li>

                                          <li>
                                              Membros
                                                  <small class="label pull-right bg-blue">{!! $resumo[0]->total_membros !!}</small>
                                          </li>

                                    </ul>

                                    <br/>
                                    @foreach($resumo_perguntas as $item)
                                    <li>
                                        <a href="#">&nbsp;{!! $item->pergunta !!}
                                            <span class="pull-right badge bg-blue">{!! $item->total !!}</span>
                                        </a>
                                    </li>
                                    @endforeach

                                </ul>
                          </div>


                </div> <!-- end row-->


             </div>
          </div>

      </div>

    </div>

</div>

<script type="text/javascript">

    $(document).ready(function(){

       $("#menu_celulas").addClass("treeview active");

/*
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
*/

  var var_json = (function () {
        var var_json = null;
        var var_month = 8;
        var var_year = 2016;
        var urlGetUser = '{!! url("/grafico_celulas/visitantes/' +  var_month + '/' + var_year + '") !!}';

        $.ajax({
            'async': false,
            'global': false,
            'url': urlGetUser,
            'dataType': "json",
            'success': function (data) {
                var_json = data;
            }
        });
        return var_json;
    })
    ();

      console.log("antes");
      console.log(var_json);
       Morris.Bar({
        element: 'visitantes',
        data: var_json,
        xkey: 'mes',
        ykeys: ['total'],
        labels: ['Visitantes']
      });

/*
var var_json = (function () {
        var var_json = null;
        var urlGetUser = '{!! url("/grafico_celulas/frequencia' +  var_month + '/' + var_year + '") !!}';

        $.ajax({
            'async': false,
            'global': false,
            'url': urlGetUser,
            'dataType': "json",
            'success': function (data) {
                var_json = data;
            }
        });
        return var_json;
    })
    ();

      var months = ["Maio", "Junho", "Julho", "Agosto"];

      Morris.Line({
        element: 'frequencia',
        data: var_json,
        xkey: 'x',
        ykeys: ['total' ],
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
      */

var months = ["Maio", "Junho", "Julho", "Agosto"];
Morris.Line({
        element: 'frequencia',
        data: [{
          mes: '2015-01', // <-- valid timestamp strings
          total: 75
        }, {
          mes: '2015-02',
          total: 70
        }, {
          mes: '2015-03',
          total: 89
        }, {
          mes: '2015-04',
          total: 86
        }, ],
        xkey: 'mes',
        ykeys: ['total' ],
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