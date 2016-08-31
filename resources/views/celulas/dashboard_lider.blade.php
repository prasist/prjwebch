@extends('principal.master')
@section('content')

{{ \Session::put('titulo', 'Dashboard Células') }}
{{ \Session::put('subtitulo', 'Visão Geral') }}
{{ \Session::put('route', 'celulas') }}
{{ \Session::put('id_pagina', '42') }}



<!-- Small boxes (Stat box) -->

<div class="box box-default">
                  <div class="box-header with-border">
                    <h4>Olá <b>{!! strtoupper(Auth::user()->name) !!}</b>, confira abaixo alguns números de sua célula.</h4>
                  </div>
</div>

<div class="row">
      <div class="col-xs-12">

      </div>
</div>

<div class="row">
    <div class="col-lg-12 col-xs-8">
            <div class="nav-tabs-custom">

              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Gráficos</a></li>
                <li><a href="#tab_2" data-toggle="tab">Relatório Mensal</a></li>
              </ul>

              <div class="tab-content">
                        <!-- TABS-->
                        <div class="tab-pane active" id="tab_1">

                                <div class="row">


                                      <div class="col-lg-5 col-xs-8">

                                              <div class="inner">
                                                   <center><h4>Total Participantes</h4>

                                                   </center>

                                              </div>

                                              <div id="tipo_pessoa" style="height: 250px;"></div>
                                      </div>

                                      <div class="col-lg-5 col-xs-8">
                                              <div class="inner">
                                                   <center><h4>Quantidade de Visitantes</h4>
                                                   <p>Últimos 3 meses</p>
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


                          @if ($resumo)
                          <div class="col-xs-3">
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

                          @if ($participantes_presenca)
                          <div class="col-xs-7">
                              <h4>&nbsp;&nbsp;&nbsp;&nbsp;Participantes</h4>
                              <table id="tab_simples" class="table table-responsible table-hover">
                                    <tr>
                                          <td>Foto</td>
                                          <td>Nome</td>
                                          <td>Celular</td>
                                          <td>Email</td>
                                          <td>Compareceu Último Encontro ?</td>
                                    </tr>

                                    @foreach($participantes_presenca as $item)
                                    <tr>
                                        <td>
                                          @if ($item->caminhofoto!="")
                                               <img src="{{ url('/images/persons/' . $item->caminhofoto) }}" width="40" height="40" alt="Participante" />
                                          @endif
                                        </td>
                                        <td>{!! $item->razaosocial !!}</td>
                                        <td>{!! $item->fone_celular !!}</td>
                                        <td>{!! $item->email_membro !!}</td>
                                        <td>
                                              @if ($item->presenca=="S")
                                                  <p class='fa fa-thumbs-o-up text-green'> Sim</p>
                                              @else
                                                  <p class='fa fa-thumbs-o-down text-red'>Não</p>
                                              @endif
                                        </td>
                                    </tr>
                                    @endforeach

                              </table>
                          </div>
                          @endif

                </div> <!-- end row-->


             </div>
          </div>

      </div>

    </div>

</div>

<script type="text/javascript">

    $(document).ready(function(){

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



@endsection