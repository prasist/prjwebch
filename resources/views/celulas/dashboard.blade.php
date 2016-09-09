@extends('principal.master')
@section('content')

{{ \Session::put('titulo', 'Dashboard Células') }}
{{ \Session::put('subtitulo', 'Visão Geral') }}
{{ \Session::put('route', 'celulas') }}
{{ \Session::put('id_pagina', '42') }}


<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <!-- Widget: user widget style 1 -->
    <div id="arvore" class="box box-widget" style="display: none">

      <div class="box-footer no-padding">

       <div class="row">
          <div class="col-md-12">
           <div class="box-header with-border">
            <h3 class="box-title">Árvore Hierárquica da Rede</h3>
            &nbsp;(<i class="text-info">Clique no nível para expandir e exibir os relatório disponíveis.</i>)
            {!! $gerar_treeview !!}
          </div>

         </div>

         <!--
            <div class="col-xs-6">

                  <label for="resultado" class="control-label">Formato de Saída : </label>
                  <select id="resultado" name="resultado" class="form-control selectpicker">
                  <option  value="pdf" data-icon="fa fa-file-pdf-o" selected>PDF (.pdf)</option>
                  <option  value="xlsx" data-icon="fa fa-file-excel-o">Planilha Excel (.xls)</option>
                  <option  value="csv" data-icon="fa fa-file-excel-o">CSV (.csv)</option>
                  <option  value="docx" data-icon="fa fa-file-word-o">Microsoft Word (.docx)</option>
                  <option  value="html" data-icon="fa fa-file-word-o">HTML (.html)</option>
                  <option  value="email" data-icon="fa fa-envelope-o">Listagem de E-mails</option>
                  </select>


                   @if ($var_download=="")

                         @if ($var_mensagem=="Nenhum Registro Encontrado")
                                <br/>
                                <br/>
                                 <div class="alert2 alert-info">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h4>
                                    <i class="icon fa fa-check"></i> {{$var_mensagem}}</h4>
                                </div>
                                {{$var_mensagem}}
                          @endif

                   @else
                      <br/>
                      <br/>
                      <div class="alert2 alert-info">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-check"></i> Relatório gerado com Sucesso!</h4>
                        Clique no link abaixo para baixar o arquivo.
                      </div>
                      <a href="{!! url($var_download) !!}" class="text" target="_blank">
                        CLIQUE AQUI PARA VISUALIZAR / BAIXAR
                        @if (substr($var_download,-3)=="pdf")
                          <img src="{{ url('/images/pdf.png') }}" alt="Baixar Arquivo" />
                        @elseif (substr($var_download,-4)=="xlsx")
                          <img src="{{ url('/images/excel.png') }}" alt="Baixar Arquivo" />
                        @elseif (substr($var_download,-3)=="csv")
                          <img src="{{ url('/images/csv.jpg') }}" alt="Baixar Arquivo" />
                        @elseif (substr($var_download,-4)=="docx")
                           <img src="{{ url('/images/microsoft-word-icon.png') }}" alt="Baixar Arquivo" />
                        @endif
                      </a>
                    @endif

            </div>
            -->


      </div>

    </div>
  </div>
</div>
</div>

<div class="row">
          <div class="col-lg-4 col-xs-7">
                    <div class="inner">
                         <center><h4>Total Participantes</h4>
                         </center>
                    </div>
                    <div id="tipo_pessoa" style="height: 250px;"></div>
          </div>

          <div class="col-lg-4 col-xs-7">
                    <div class="inner">
                         <center><h4>Quantidade de Visitantes</h4>
                         <p>Últimos 3 meses</p>
                         </center>
                    </div>
                    <div id="visitantes" style="height: 250px;"></div>
          </div>

          <!--
           <div class="col-lg-4 col-xs-7">

                <div class="input-group margin">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"><span class="fa fa-print"></span>  Estatísticas
                        <span class="fa fa-caret-down"></span></button>
                        <ul class="dropdown-menu">

                              <li><a href="#" onclick="abrir_relatorio('1');">Total Geral de Células</a></li>
                              <li><a href="#" onclick="abrir_relatorio('2');">Resumo</a></li>

                        </ul>
                  </div>
                  <br/>
              </div>

            </div>-->

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

                        <div class="col-xs-4">
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
                          @else
                            <div class="col-xs-6">
                                  <h4>&nbsp;&nbsp;&nbsp;&nbsp;Resumo Encontros (Mês Corrente)</h4>
                                  <ul class="nav nav-stacked">

                                        <li>
                                            Sem dados estatísticos dos encontros até o momento.
                                        </li>
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

   function changeFunc(objeto, nivel, valor, nome)
   {
        var selectBox =  objeto;
        var selectedValue = selectBox.options[selectBox.selectedIndex].value;

        //var selectSaida =  document.getElementById("resultado");
        //var saida = selectSaida.options[selectSaida.selectedIndex].value;

        if (selectedValue!="")
        {
            //Abre Relatorio conforme parametros passados
            abrir_relatorio_nivel(selectedValue, nivel, valor, nome, "pdf");
        }

   }

    //resumo anual por estrutura
      function abrir_relatorio_nivel(tipo, nivel, valor, nome, saida)
      {
             var urlGetUser = '';
             urlGetUser = '{!! url("/estatisticas_nivel/' +  tipo + '/' + nivel+ '/' + valor + '/' + nome + '/' + saida + '") !!}';
             window.location.href =urlGetUser;
      }

      //resumo anual
      function abrir_relatorio(tipo)
      {
              var urlGetUser = '{!! url("/estatisticas/' +  tipo + '") !!}';
              window.location.href =urlGetUser;
      }

    $(document).ready(function(){

      //so mostrat div quando load pagina
       $('#arvore').show();

       //expandir menu
       $("#menu_celulas").addClass("treeview active");


      //-------------------------Grafico visitantes
      var var_json = (function () {


            var var_json = null;
            var var_month = moment().format('M');
            var var_year = moment().format('YYYY');
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
            var var_month = moment().format('M');
            var var_year = moment().format('YYYY');
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