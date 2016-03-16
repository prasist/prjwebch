<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>SIGMA3 - Sistema para Igrejas</title>
        <!-- Est-->
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.0/sweetalert.css" rel="stylesheet" type="text/css" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.0/sweetalert.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <!--<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>-->

        <link href="{{ asset('/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/dist/css/skins/skin-green.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/plugins/iCheck/flat/green.css') }}" rel="stylesheet" type="text/css" />

        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="{{ asset('/plugins/iCheck/all.css') }}">

        <!-- jvectormap -->
        <link href="{{ asset('/plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="{{ asset('/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="{{ asset('/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="{{ asset('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css" />
          <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('/plugins/datatables/dataTables.bootstrap.css') }}">

        <link rel="stylesheet" href="{{ asset('dist/css/hopscotch.min.css') }}">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="{{ asset('/plugins/select2/select2.min.css') }}">

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


<!-- DataTables -->



<!--<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>-->
<script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('/plugins/select2/select2.full.min.js') }}"></script>

<script type="text/javascript">

                  $(function ()
                  {

                            $(".select2").select2();

                            $("[data-mask]").inputmask();

                            $('div.alert').delay(3000).slideUp(300);

                            $("#example1").DataTable();

                     });

</script>


@yield('tela_permissoes')

@yield('tela_usuarios')

@yield('tela_pessoas')

@yield('busca_endereco')

@yield('data_table_custom')

<!-- Adicionando JQuery -->


        <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('/plugins/input-mask/jquery.inputmask.js') }}"></script>
        <script src="{{ asset('/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
        <script src="{{ asset('/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
        <script src="{{ asset('/dist/js/app.min.js') }}" type="text/javascript"></script>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
        <script src="{{ asset('plugins/sparkline/jquery.sparkline.min.js') }}"></script>
        <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
        <script src="{{ asset('plugins/knob/jquery.knob.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
        <script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
        <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>
        <script src="{{ asset('dist/js/hopscotch.min.js') }}"></script>
        <script src="{{ asset('js/tour_sigma3.js') }}"></script>


        @if (\Session::get('tour_visaogeral')==' ' || \Session::get('tour_visaogeral')!='S')
        <script type="text/javascript">

                hopscotch.startTour(tour_visao_geral);

        </script>
        @endif

        @if (\Session::get('tour_rapido')==' ' || \Session::get('tour_rapido')!='S')
        <script type="text/javascript">

                hopscotch.startTour(tour);

        </script>
        @endif

    </body>
</html>