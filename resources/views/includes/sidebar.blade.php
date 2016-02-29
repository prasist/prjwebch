<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">

            <!--Foto usuário -->
            <div class="pull-left image">

                @if (Auth::user()->path_foto!="")
                        <img src="{{ url('/images/users/' . Auth::user()->path_foto) }}" class="img-circle" alt="Usuário Logado" />
                @else
                        <img src="{{ url('/dist/img/boxed-bg.jpg') }}" class="img-circle" alt="Usuário Logado" />
                @endif

            </div>
            <!-- ************* -->

            <!-- Usuário logado-->
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
            </div>
            <!-- ************** -->

        </div>

        <!--Menu Principal -->
        <ul class="sidebar-menu">
            <li class="header">Menu Principal</li>

            <li class="treeview">
                <a href="#">
                <i class="fa fa-wrench"></i> <span>Configurações</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href={{ url('/clientes')}}><i class="fa fa-angle-double-right"></i> Igreja Sede</a></li>
                    <li><a href={{ url('/empresas')}}><i class="fa fa-angle-double-right"></i> Igrejas / Instituições </a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                <i class="fa fa-lock"></i> <span>Segurança</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="active">
                        <a href={{ url('/grupos')}}><i class="fa fa-angle-double-right"></i>Grupos de Usuário</a>
                    </li>

                    <li>
                        <a href={{ url('/permissoes')}}><i class="fa fa-angle-double-right"></i>Grupos / Permissões</a>
                    </li>

                    <li>
                        <a href={{ url('/usuarios')}}><i class="fa fa-angle-double-right"></i>Usuários</a>
                    </li>
                </ul>
            </li>

           <li class="treeview">
                <a href="#">
                <i class="fa fa-edit"></i> <span>Cadastro Base</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    <li class="text">&nbsp;</li>
                    <li><a href={{ url('/status')}}><i class="fa fa-angle-double-right"></i>Status</a></li>
                    <li><a href={{ url('/situacoes')}}><i class="fa fa-angle-double-right"></i>Situações</a></li>
                    <li><a href={{ url('/cargos')}}><i class="fa fa-angle-double-right"></i>Cargos / Funções</a></li>
                    <li><a href={{ url('/ramos')}}><i class="fa fa-angle-double-right"></i>Ramos de Atividades</a></li>
                    <li><a href={{ url('/civis')}}><i class="fa fa-angle-double-right"></i>Estados Civis</a></li>
                    <li><a href={{ url('/idiomas')}}><i class="fa fa-angle-double-right"></i>Idiomas</a></li>
                    <li><a href={{ url('/graus')}}><i class="fa fa-angle-double-right"></i>Graus de Instrução</a></li>
                    <li><a href={{ url('/areas')}}><i class="fa fa-angle-double-right"></i>Àreas de Formação</a></li>
                    <li><a href={{ url('/profissoes')}}><i class="fa fa-angle-double-right"></i>Profissões</a></li>
                    <li><a href={{ url('/grausparentesco')}}><i class="fa fa-angle-double-right"></i>Graus de Parentesco</a></li>
                    <li><a href={{ url('/disponibilidades')}}><i class="fa fa-angle-double-right"></i>Disponibilidades de Tempo</a></li>

                    <li class="text">&nbsp;</li>

                    <li><a href={{ url('/igrejas')}}><i class="fa fa-angle-double-right"></i>Igrejas</a></li>
                    <li><a href={{ url('/religioes')}}><i class="fa fa-angle-double-right"></i>Religiões</a></li>
                    <li><a href={{ url('/ministerios')}}><i class="fa fa-angle-double-right"></i>Ministérios</a></li>
                    <li><a href={{ url('/atividades')}}><i class="fa fa-angle-double-right"></i>Atividades</a></li>
                    <li><a href={{ url('/dons')}}><i class="fa fa-angle-double-right"></i>Dons Espirituais</a></li>
                    <li><a href={{ url('/habilidades')}}><i class="fa fa-angle-double-right"></i>Habilidades</a></li>

                    <li class="text">&nbsp;</li>
                    <li><a href={{ url('/grupospessoas')}}><i class="fa fa-angle-double-right"></i>Grupos de Pessoas</a></li>
                    <li><a href={{ url('/tipospresenca')}}><i class="fa fa-angle-double-right"></i>Tipos de Presença</a></li>
                    <li><a href={{ url('/tiposmovimentacao')}}><i class="fa fa-angle-double-right"></i>Tipos de Mov. Membros</a></li>

                </ul>
            </li>

            <li class="treeview">
                <a href={{ url('/pessoas')}}><i class="fa fa-users"></i>Pessoas</a>
            </li>

            <!--
            <li>
                <a href="pages/calendar.html">
                <i class="fa fa-calendar"></i> <span>Calendar</span>
                <small class="label pull-right bg-red">3</small>
                </a>
            </li>
            <li>
                <a href="pages/mailbox/mailbox.html">
                <i class="fa fa-envelope"></i> <span>Mailbox</span>
                <small class="label pull-right bg-yellow">12</small>
                </a>
            </li>
            -->

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>