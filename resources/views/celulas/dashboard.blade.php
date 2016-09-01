@extends('principal.master')
@section('content')

{{ \Session::put('titulo', 'Dashboard Células') }}
{{ \Session::put('subtitulo', 'Visão Geral') }}
{{ \Session::put('route', 'celulas') }}
{{ \Session::put('id_pagina', '42') }}



<!-- Small boxes (Stat box) -->

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

                                      <div class="col-lg-3 col-xs-6">
                                              <div class="inner">
                                                   <center><h4>Total Participantes</h4>

                                                   </center>

                                              </div>

                                              <div id="tipo_pessoa" style="height: 250px;"></div>
                                      </div>

                                      <div class="col-lg-3 col-xs-6">
                                              <div class="inner">
                                                   <center><h4>Quantidade de Visitantes</h4>
                                                   <p>Últimos 3 meses</p>
                                                   </center>
                                              </div>
                                              <div id="visitantes" style="height: 250px;"></div>
                                      </div>

                                      <!--

                                      <div class="col-lg-4 col-xs-7">
                                              <div id="tree"></div>
                                      </div>-->

                                </div><!-- /.row -->

                        </div><!-- /.tab-pane -->

                        <div class="tab-pane" id="tab_2">

                               @include('celulas.filtro_rel_encontro')

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
                                            <span class="pull-right badge bg-green">{!! $total_participantes !!}</span>
                                        </a>

                                        @if ($resumo_tipo_pessoas)
                                        <ul style="list-style-type:none">
                                            @foreach($resumo_tipo_pessoas as $item)
                                            <li>
                                                {!! $item->nome !!}
                                                    <span class="pull-right badge bg-blue">{!! $item->total !!}</span>
                                            </li>
                                            @endforeach

                                        </ul>
                                        @endif
                                    </li>


                                   @if ($celulas_faixas)
                                         <h4>&nbsp;&nbsp;&nbsp;&nbsp;Por Faixa Etária</h4>

                                          @foreach($celulas_faixas as $item)
                                          <li>
                                              <a href="#">&nbsp;{!! $item->nome !!}
                                                  <span class="pull-left badge bg-blue">{!! $item->total !!}</span>
                                              </a>
                                          </li>
                                          @endforeach
                                    @endif

                                    @if ($celulas_publicos)
                                          <h4>&nbsp;&nbsp;&nbsp;&nbsp;Público Alvo</h4>

                                          @foreach($celulas_publicos as $item)
                                          <li>
                                              <a href="#">&nbsp;{!! $item->nome !!}
                                                  <span class="pull-left badge bg-blue">{!! $item->total !!}</span>
                                              </a>
                                          </li>
                                          @endforeach
                                    @endif

                                </ul>
                          </div>

                          @if ($resumo)
                          <div class="col-xs-6">
                              <h4>&nbsp;&nbsp;&nbsp;&nbsp;Resumo Encontros (Mês Corrente)</h4>
                              <ul class="nav nav-stacked">

                                    <li>
                                        <a href="#">&nbsp;Total Geral Presentes
                                            <span class="pull-right badge bg-green">{!! $resumo[0]->total_geral !!}</span>
                                        </a>
                                    </li>

                                    <ul style="list-style-type:none">
                                          <li>
                                              Visitantes<span class="pull-right badge bg-blue">{!! $resumo[0]->total_visitantes !!}</span>
                                          </li>

                                          <li>
                                              Membros
                                              <span class="pull-right badge bg-yellow">{!! $resumo[0]->total_membros !!}</span>
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
                          @endif

                </div> <!-- end row-->


             </div>
          </div>

      </div>

    </div>

</div>

<script type="text/javascript">

  function getTree() {
        // Some logic to retrieve, or generate tree structure

        var urlGetUser = '{!! url("/celulas/buscar_estruturas/") !!}';

        $.getJSON(urlGetUser, function( data, status )
        {
                console.log(data);
                return data;
        });

  }

    $(document).ready(function(){




       $('#tree').treeview({data: getTree()});

       $("#menu_celulas").addClass("treeview active");


      //-------------------------Grafico visitantes
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

         Morris.Bar({
          element: 'visitantes',
          data: var_json,
          xkey: 'mes',
          ykeys: ['total'],
          labels: ['Visitantes']
        });
     //---------------------FIM



     //-----------------------Grafico Total Por Tipo de Pessoa
      var var_json = (function () {
            var var_json = null;
            var var_month = 8;
            var var_year = 2016;
            var urlGetUser = '{!! url("/grafico_celulas/tipo_pessoa/' +  var_month + '/' + var_year + '") !!}';

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

        Morris.Donut({
          element: 'tipo_pessoa',
           colors: [
            '#0BA462',
            '#39B580',
            '#67C69D',
            '#95D7BB'
          ],
          data: var_json
        });

        //---------------------FIM


     });


</script>


@include('configuracoes.script_estruturas')


@endsection