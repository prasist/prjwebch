<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>SIGMA3 - Sistema para Igrejas</title>
        <!-- Est-->
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta http-equiv="x-ua-compatible" content="IE=10">


        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
        <!--<script src="//vitalets.github.io/x-editable/assets/mockjax/jquery.mockjax.js"></script>-->
        <link href="{{ asset('/dist/css/bootstrap-editable.css')}}" rel="stylesheet" type="text/css" />
        <script src="{{ asset('/dist/js/bootstrap-editable.js')}}"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.0/sweetalert.css" rel="stylesheet" type="text/css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.0/sweetalert.min.js"></script>
        <script src="{{ asset('/dist/js/bootstrap-datepicker.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/dist/css/AdminLTE.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/dist/css/skins/skin-green.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Bootstrap time Picker -->
        <link href="{{ asset('/dist/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />

        <!-- jvectormap -->
        <!--<link href="{{ asset('/plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet" type="text/css" />-->
        <!-- Daterange picker -->
        <link href="{{ asset('/plugins/daterangepicker/daterangepicker-bs3.css')}}" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="{{ asset('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('/plugins/datatables/dataTables.bootstrap.css')}}"/>
        <link rel="stylesheet" href="{{ asset('/dist/css/hopscotch.min.css')}}"/>
        <link rel="stylesheet" href="{{ asset('/dist/css/buscapessoas.css')}}"/>

        <link href="{{ asset('/dist/css/bootstrap-switch.min.css')}}" rel="stylesheet"/>
        <link href="{{ asset('/dist/css/bootstrap-treeview.min.css')}}" rel="stylesheet"/>

        <link href="{{ asset('/dist/css/pace.min.css')}}" rel="stylesheet"/>





        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">
        <!-- Date Picker -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker3.css" rel="stylesheet" type="text/css" />

        <link href="{{ asset('/dist/css/pick-a-color-1.1.8.min.css')}}" rel="stylesheet"/>

        <link href="{{ asset('/dist/css/treeview.css')}}" rel="stylesheet"/>


        <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>-->



    </head>

    <body class="hold-transition skin-green sidebar-mini">

        <div class="wrapper">
            @include('includes.header')
            @include('includes.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

                <!-- Content Header (Page header) -->
                <section id="tst" class="content-header">
                    <h1>
                    @if (Session::has('titulo'))
                          {{ Session::get('titulo') }}
                    @endif
                    <small>
                    @if (Session::has('subtitulo'))
                        {{ Session::get('subtitulo') }}
                    @endif
                    </small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">
                        @if (Session::has('route'))
                            <a href="{{ url(Session::get('route'))}}"> {{ Session::get('route') }}</a>
                        @endif
                        </li>
                        <li class="active">
                        @if (Session::has('titulo'))
                            {{ Session::get('titulo') }}
                        @endif
                        </li>
                    </ol>
                </section>


                <!-- Main content -->
                <section class="content">

                    @if (Session::has('flash_message'))

                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-check"></i> Mensagem!</h4>
                                {{ Session::get('flash_message')}}
                            </div>

                    @endif

                    @if (Session::has('flash_message_erro'))

                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-check"></i> Erro!</h4>
                                {{ Session::get('flash_message_erro')}}
                            </div>

                    @endif

                    @yield('content')
                </section><!-- /.content -->


            </div><!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Versão</b> Beta
                </div>
                <strong>Copyright &copy; 2016 <a href="http://www.prasist.com.br">WP Sistemas</a>.</strong> All rights reserved.
            </footer>
        </div><!-- ./wrapper -->


<script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
<script src="{{ asset('/dist/js/tinycolor-0.9.15.min.js')}}"></script> <!-- monetarios-->
<script src="{{ asset('/dist/js/pick-a-color-1.1.8.min.js')}}"></script> <!-- monetarios-->


<script type="text/javascript">

        // To make Pace works on Ajax calls
            $(document).ajaxStart(function() { Pace.restart(); });
            $('.ajax').click(function(){
                $.ajax({url: '#', success: function(result){
                    $('.ajax-content').html('<hr>Ajax Request Completed !');
                }});
            });


                  $(function ()
                  {


                            $(".pick-a-color").pickAColor({
                              showHexInput            : false,
                              showBasicColors         : true,
                              allowBlank              : false,
                              inlineDropdown          : true
                            });

                            //Timepicker
                            //$(".timepicker").timepicker({
                            //     showInputs: false
                            //});

                            /*
                             $('#horario').timepicker({
                                minuteStep: 1,
                                template: 'modal',
                                appendWidgetTo: 'body',
                                showMeridian: false,
                                defaultTime: false
                            });
                            */

                            /*Monetarios - class*/
                            $('.formata_valor').autoNumeric("init",{
                                aSep: '.',
                                aDec: ','
                            });

                            $('.selectpicker').selectpicker({
                                selectAllText: 'Selecionar Todos',
                                deselectAllText: 'Desmarcar Todos'
                            });

                            $("[data-mask]").inputmask();

                            $('div.alert').delay(3500).slideUp(300);

                            $('div.alert2').delay(8000).slideUp(300);

                            /*Tabelas simples
                            Desabilita ordenacao da coluna dos botoes de ações
                            */
                            $("#example1").DataTable({

                                 language: {
                                            paginate: {
                                                first:      "Primeira",
                                                previous:   "Anterior",
                                                next:       "Próxima",
                                                last:       "Última"}
                                        },
                                "columnDefs":
                                  [
                                      {"targets": [1], "sortable": false},
                                      {"targets": [2], "sortable": false},
                                      {"targets": [3], "sortable": false}
                                  ]
                            });


                            $("#tab_login").DataTable({

                                 language: {
                                            paginate: {
                                                first:      "Primeira",
                                                previous:   "Anterior",
                                                next:       "Próxima",
                                                last:       "Última"}
                                        },
                                "columnDefs":
                                  [
                                      {"targets": [1], "sortable": false},
                                      {"targets": [2], "sortable": false}
                                  ]
                            });


                               $("#tab_celulas_pessoas").DataTable({
                                 "pageLength": 50,
                                 "order": [[ 1, "asc" ]],
                                 language: {
                                            paginate: {
                                                first:      "Primeira",
                                                previous:   "Anterior",
                                                next:       "Próxima",
                                                last:       "Última"}
                                        },
                                "columnDefs":
                                  [
                                      {"targets": [3], "sortable": false},
                                      {"targets": [4], "sortable": false},
                                      {"targets": [5], "sortable": false},
                                      {"targets": [6], "sortable": false}
                                  ]
                            });

                            $("#table_celulas").DataTable({
                                "pageLength": 50,
                                "order": [[ 1, "asc" ]],
                                 language: {
                                            paginate: {
                                                first:      "Primeira",
                                                previous:   "Anterior",
                                                next:       "Próxima",
                                                last:       "Última"}
                                        },
                                "columnDefs":
                                  [
                                      {"targets": [6], "sortable": false},
                                      {"targets": [7], "sortable": false},
                                      {"targets": [8], "sortable": false}
                                  ]
                            });


                            $("#table_titulos").DataTable({
                                 "pageLength": 50,
                                 language: {
                                            paginate: {
                                                first:      "Primeira",
                                                previous:   "Anterior",
                                                next:       "Próxima",
                                                last:       "Última"}
                                        },
                                "columnDefs":
                                  [
                                      {"targets": [6], "sortable": false},
                                      {"targets": [7], "sortable": false},
                                      {"targets": [8], "sortable": false},
                                      {"targets": [9], "sortable": false},
                                      {"targets": [10], "sortable": false},
                                      {"targets": [11], "sortable": false},
                                      {"targets": [12], "sortable": false}
                                  ]
                            });


                            $("#tab_simples").DataTable({
                                       language: {
                                            paginate: {
                                                first:      "Primeira",
                                                previous:   "Anterior",
                                                next:       "Próxima",
                                                last:       "Última"}
                                        },
                                "columnDefs":
                                  [
                                      {"targets": [1], "sortable": false},
                                      {"targets": [2], "sortable": false}
                                  ]
                            });

                            $('input.typeahead').typeahead({
                                name: 'typeahead',
                                remote:'{!! url("/buscapessoa/%QUERY") !!}',
                                limit : 50
                            });

                     });

</script>

<script type="text/javascript">

    function validar_data(who)
    {
        if (who.value!="")
        {
            str=who.value;
            str=str.split('/');
            dte=new Date(str[1]+'/'+str[0]+'/'+str[2]);
            mStr=''+(dte.getMonth()+1);
            mStr=(mStr<10)?'0'+mStr:mStr;

            if(mStr!=str[1]||isNaN(dte))
            {
                who.value="";
                alert('Data Inválida!');
                who.focus();
                return;
            }
        }
    }


    /*Função usada para exibir no campo input pessoas[] a pessoa pesquisa da tela modal*/
    function incluir_registro_combo(objInput)
    {
          $('select[name=' + objInput + ']').change(function() {

            if ($('select[name=' + objInput + '] option:selected').text() == '(Incluir Novo Registro)')
            {
                //Abre modal para cadastrar novo item no combo
                $('#modal_' + objInput).modal('show');

                //Foco no campo
                $('#modal_' + objInput).on('shown.bs.modal', function ()
                {
                    $('#novo_valor_' + objInput).focus()
                })

            }
        });
    }


    /*Função usada para exibir no campo input pessoas[] a pessoa pesquisa da tela modal*/
    function confirmar(objInput)
    {
        //Percorre array input (Pois podem existir n modals na mesma pagina)
        $('input.typeahead').each(function()
        {
                if ($(this).val()!="") //Se encontrar valor
                {
                    var pessoa_pesquisada = $(this).val(); // Resultado pesquisa
                    document.getElementById(objInput).value = pessoa_pesquisada;    // Joga no campo passado como parametro
                    $(this).val(""); //Limpa campo após leitura
                }
        });
    }

    //Se não cadatrar nada no MODAL, seleciona vazio no combobox
    function cancelou(objInput)
    {
        $('#' + objInput).prop('selectedIndex', 0);
        $('#' + objInput).trigger("change");
    }

    /*Função usada para exibir no campo input pessoas[] a pessoa pesquisa da tela modal*/
    function confirmar_cadastro(objInput)
    {

        var_parametros = objInput.split(","); //Recebe dois parametros separados por virgula (Nome combo, tabela)

        //Percorre array input (Pois podem existir n modals na mesma pagina)
        $('input.novo_valor_' + objInput).each(function()
        {
                var_qtd=0;

                if ($(this).val()!="") //Se encontrar valor
                {

                    var_qtd++;

                    var var_conteudo = $(this).val(); // Resultado pesquisa

                    //Limpa campo após leitura
                    $(this).val("");

                    //informa tabela e conteudo a ser inserido
                    var_query = var_parametros[1].trim() + '&' + var_conteudo.trim();

                    //Rota a ser disparada
                    var urlRoute = "{!! url('/cadastrar/json/" + var_query + "') !!}";

                    //Gravar novo registro
                    $.ajax({
                        type: 'GET',
                        url: urlRoute,
                        success: function (data){

                                //Carregar novamente a combo com o item recem incluido já selecionado
                                var urlRouteCarregar = "{!! url('/carregar_tabela/" + var_parametros[1].trim() + "') !!}";

                                $.getJSON(urlRouteCarregar, function(data)
                                {
                                    var $stations = $('#' + var_parametros[0].trim()); //Instancia o objeto combo
                                    $stations.empty();

                                    var html='';

                                    html += '<option value=""></option>';
                                    html += '<option  value="" data-icon="glyphicon-pencil">(Incluir Novo Registro)</option>';
                                    html += '<option data-divider="true"></option>';


                                    $.each(data, function(index, value)
                                    {
                                        html += '<option value="' + index +'" ' + (var_conteudo.trim()==value.trim() ? 'selected' : '')+ '>' + value + '</option>';
                                    });

                                    $stations.append(html);
                                    $('#' + var_parametros[0].trim()).trigger("change");
                                    alert('Registro Incluído com Sucesso!!!');
                                    //jAlert('Registro Incluído com Sucesso!!!', 'Alert Dialog');

                                });

                        },
                        error: function (data) {
                            alert('Erro ao inserir o registro.');
                        }
                    });

                }

        });
    }

</script>

@yield('tela_permissoes')

@yield('tela_usuarios')

@yield('tela_pessoas')

@yield('busca_endereco')

@yield('data_table_custom')

<!-- Adicionando JQuery -->

        <script>
          var AdminLTEOptions = {
                    sidebarExpandOnHover: true,
          };
        </script>

        <script src="{{ asset('/dist/js/bootstrap-treeview.min.js')}}"></script>
        <!--<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>-->
        <!--<script src="{{ asset('/js/controller.js')}}"></script>-->
        <script src="{{ asset('/plugins/input-mask/jquery.inputmask.js')}}"></script>
        <script src="{{ asset('/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
        <script src="{{ asset('/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
        <script src="{{ asset('/dist/js/app.min.js')}} " type="text/javascript"></script>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
        <script src="{{ asset('/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
        <script src="{{ asset('/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
        <script src="{{ asset('/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
        <script src="{{ asset('/plugins/knob/jquery.knob.js')}}"></script>
        <script src="{{ asset('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
        <script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
        <script src="{{ asset('/plugins/fastclick/fastclick.js')}}"></script>
        <script src="{{ asset('/dist/js/pages/dashboard.js')}}"></script>
        <script src="{{ asset('/dist/js/hopscotch.min.js')}}"></script>
        <script src="{{ asset('/js/tour_sigma3.js')}}"></script>
        <!--<script src="{{ asset('/js/app_angular.js')}}"></script>-->
        <script src="{{ asset('/js/typeahead.min.js')}}"></script>
        <script src="{{ asset('/dist/webcam.js')}}"></script>
        <script src="{{ asset('/dist/js/bootstrap-checkbox.min.js')}}" defer></script>
        <script src="{{ asset('/dist/js/moment.min.js')}}"></script> <!-- datas-->
        <script src="{{ asset('/dist/js/autoNumeric-min.js')}}"></script> <!-- monetarios-->
        <script src="{{ asset('/dist/js/bootstrap-switch.min.js')}}"></script>
        <!-- bootstrap time picker -->
        <script src="{{ asset('/dist/js/bootstrap-timepicker.min.js')}}"></script>

        <script src="{{ asset('/dist/js/treeview.js')}}"></script>
        <script src="{{ asset('/dist/js/pace.min.js')}}"></script>


        @if (\Session::get('membro')=='')
                <!-- tour rápido-->
                @if (\Session::get('tour_visaogeral')=='' || \Session::get('tour_visaogeral')!='S')
                    @if (\Session::get('dados_login')!='')
                    <script type="text/javascript">
                            hopscotch.startTour(tour_visao_geral);
                    </script>
                    @endif
                @endif

                @if (\Session::get('tour_rapido')==' ' || \Session::get('tour_rapido')!='S')
                    @if (\Session::get('admin')==1)
                        <script type="text/javascript">
                                hopscotch.startTour(tour);
                        </script>
                    @endif
                @endif

               @if (isset($avisos))
                    @if (count($avisos)>0)
                             <script type="text/javascript">
                                    hopscotch.startTour(avisos_sigma3);
                             </script>
                    @endif
                @endif

        @endif


    </body>
</html>