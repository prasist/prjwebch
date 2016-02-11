<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>SIGMA3 - Sistema para Igrejas</title>
        <!-- Est-->
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.0/sweetalert.css" rel="stylesheet" type="text/css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.0/sweetalert.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <link href="{{ asset('/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/dist/css/AdminLTE.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/dist/css/skins/_all-skins.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('/plugins/iCheck/flat/blue.css') }}" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="{{ asset('/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
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
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="{{ asset('/plugins/select2/select2.min.css') }}">
        <script src="{{ asset('/plugins/select2/select2.full.min.js') }}"></script>

    </head>

    <body class="hold-transition skin-blue sidebar-mini">

        <div class="wrapper">
            @include('includes.header')
            @include('includes.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

                <!-- Content Header (Page header) -->
                <section class="content-header">
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

                <!--Aqui o conteudo será as páginas chamadas...-->
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
                    <b>Versão</b> 1.0
                </div>
                <strong>Copyright &copy; 2016 <a href="http://www.prasist.com.br">WP Sistemas</a>.</strong> All rights reserved.
            </footer>
        </div><!-- ./wrapper -->


        <!--retirado daqui js -->
       <!-- Page script -->

       <!-- jQuery 2.1.4 -->
       <!--<script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>-->


<!-- DataTables -->
<script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>


  <script type="text/javascript">

                  $(function () {

                        $("[data-mask]").inputmask();

                        //Initialize Select2 Elements
                        $(".select2").select2();

                        $('div.alert').delay(3000).slideUp(300);

                        $('#selecionar_todos').click(function() {

                            if ($(this).prop('checked')) {
                                $('.acessar').prop('checked', true);
                            } else {
                                $('.acessar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.incluir').prop('checked', true);
                            } else {
                                $('.incluir').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.alterar').prop('checked', true);
                            } else {
                                $('.alterar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.excluir').prop('checked', true);
                            } else {
                                $('.excluir').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.visualizar').prop('checked', true);
                            } else {
                                $('.visualizar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.exportar').prop('checked', true);
                            } else {
                                $('.exportar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.imprimir').prop('checked', true);
                            } else {
                                $('.imprimir').prop('checked', false);
                            }

                             if ($(this).prop('checked')) {
                                $('.selecionar_acessar').prop('checked', true);
                            } else {
                                $('.selecionar_acessar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.selecionar_incluir').prop('checked', true);
                            } else {
                                $('.selecionar_incluir').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.selecionar_alterar').prop('checked', true);
                            } else {
                                $('.selecionar_alterar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.selecionar_excluir').prop('checked', true);
                            } else {
                                $('.selecionar_excluir').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.selecionar_visualizar').prop('checked', true);
                            } else {
                                $('.selecionar_visualizar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.selecionar_exportar').prop('checked', true);
                            } else {
                                $('.selecionar_exportar').prop('checked', false);
                            }

                            if ($(this).prop('checked')) {
                                $('.selecionar_imprimir').prop('checked', true);
                            } else {
                                $('.selecionar_imprimir').prop('checked', false);
                            }

                        });

                        $('#selecionar_acessar').click(function() {
                            if ($(this).prop('checked')) {
                                $('.acessar').prop('checked', true);
                            } else {
                                $('.acessar').prop('checked', false);
                            }
                        });

                        $('#selecionar_incluir').click(function() {
                            if ($(this).prop('checked')) {
                                $('.incluir').prop('checked', true);
                            } else {
                                $('.incluir').prop('checked', false);
                            }
                        });

                        $('#selecionar_alterar').click(function() {
                            if ($(this).prop('checked')) {
                                $('.alterar').prop('checked', true);
                            } else {
                                $('.alterar').prop('checked', false);
                            }
                        });

                        $('#selecionar_excluir').click(function() {
                            if ($(this).prop('checked')) {
                                $('.excluir').prop('checked', true);
                            } else {
                                $('.excluir').prop('checked', false);
                            }
                        });

                        $('#selecionar_visualizar').click(function() {
                            if ($(this).prop('checked')) {
                                $('.visualizar').prop('checked', true);
                            } else {
                                $('.visualizar').prop('checked', false);
                            }
                        });

                        $('#selecionar_exportar').click(function() {
                            if ($(this).prop('checked')) {
                                $('.exportar').prop('checked', true);
                            } else {
                                $('.exportar').prop('checked', false);
                            }
                        });

                        $('#selecionar_imprimir').click(function() {
                            if ($(this).prop('checked')) {
                                $('.imprimir').prop('checked', true);
                            } else {
                                $('.imprimir').prop('checked', false);
                            }
                        });

                            $("#example1").DataTable();
                            $('#example2').DataTable({
                              "paging": true,
                              "lengthChange": false,
                              "searching": false,
                              "ordering": true,
                              "info": true,
                              "autoWidth": false
                            });

                   });

   </script>

<!-- bootbox code -->



  <!-- Bootstrap 3.3.2 JS -->
        <script src="{{ asset('/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>


        <!-- jQuery UI 1.11.2 -->
        <!--<script src="{{ asset('/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" type="text/javascript"></script>-->
        <!--<script src="{{ asset('/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript"></script>-->

       <!-- jQuery Knob Chart -->
        <!--<script src="{{ asset('/plugins/knob/jquery.knob.js') }}" type="text/javascript"></script>-->

        <!-- Slimscroll -->
        <!--<script src="{{ asset('/plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>-->


     <!-- DataTables -->
      <!--  <script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>-->

        <!-- InputMask -->
        <script src="{{ asset('/plugins/input-mask/jquery.inputmask.js') }}"></script>
        <script src="{{ asset('/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
        <script src="{{ asset('/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>


        <!-- Morris.js charts -->
       <!-- <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="{{ asset('/plugins/morris/morris.min.js') }}" type="text/javascript"></script>-->


        <!-- daterangepicker -->
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
        <script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>-->

        <!-- datepicker -->
        <!--<script src="{{ asset('/plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>-->
        <!-- Bootstrap WYSIHTML5 -->
        <!--<script src="{{ asset('/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}" type="text/javascript"></script>-->

        <!-- iCheck -->
        <!--<script src="{{ asset('/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>-->
     <!-- FastClick -->
       <!-- <script src="{{ asset('/plugins/fastclick/fastclick.min.js') }}"></script>-->

        <!-- AdminLTE App -->
        <script src="{{ asset('/dist/js/app.min.js') }}" type="text/javascript"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!--<script src="{{ asset('/dist/js/pages/dashboard.js') }}" type="text/javascript"></script>-->
        <!-- AdminLTE for demo purposes -->
        <!--<script src="{{ asset('/dist/js/demo.js') }}" type="text/javascript"></script>-->

       <!-- Select2 -->
       <!-- <script src="{{ asset('/plugins/select2/select2.full.min.js') }}"></script>-->



<!--
        <script type="text/javascript">

          $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();

            //Datemask dd/mm/yyyy
            $("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
            //Datemask2 mm/dd/yyyy
            $("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});

            $("[data-mask]").inputmask();

               $("#example1").DataTable();
                $('#example2').DataTable({
                  "paging": true,
                  "lengthChange": false,
                  "searching": false,
                  "ordering": true,
                  "info": true,
                  "autoWidth": false
                });


            //Date range picker
            $('#reservation').daterangepicker();
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
            //Date range as a button
            $('#daterange-btn').daterangepicker(
                {
                  ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                  },
                  startDate: moment().subtract(29, 'days'),
                  endDate: moment()
                },
                function (start, end) {
                  $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                }
            );

            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
              checkboxClass: 'icheckbox_minimal-blue',
              radioClass: 'iradio_minimal-blue'
            });
            //Red color scheme for iCheck
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
              checkboxClass: 'icheckbox_minimal-red',
              radioClass: 'iradio_minimal-red'
            });
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
              checkboxClass: 'icheckbox_flat-green',
              radioClass: 'iradio_flat-green'
            });

            //Colorpicker
            $(".my-colorpicker1").colorpicker();
            //color picker with addon
            $(".my-colorpicker2").colorpicker();

            //Timepicker
            $(".timepicker").timepicker({
              showInputs: false
            });
          });

        </script>
        -->
    </body>
</html>