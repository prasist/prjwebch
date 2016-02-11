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

        <!-- search form -->
        <!--
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Pesquisar..."/>
                <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>-->
        <!-- /.search form -->

        <!-- sidebar menu: : style can be found in sidebar.less -->

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
                <i class="fa fa-users"></i> <span>Segurança</span> <i class="fa fa-angle-left pull-right"></i>
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
                    <li><a href={{ url('/igrejas')}}><i class="fa fa-angle-double-right"></i>Igrejas</a></li>
                    <li><a href={{ url('/status')}}><i class="fa fa-angle-double-right"></i>Status</a></li>
                    <li><a href={{ url('/idiomas')}}><i class="fa fa-angle-double-right"></i>Idiomas</a></li>
                    <li><a href={{ url('/graus')}}><i class="fa fa-angle-double-right"></i>Graus de Instrução</a></li>
                    <li><a href={{ url('/profissoes')}}><i class="fa fa-angle-double-right"></i>Profissões</a></li>
                    <li><a href={{ url('/areas')}}><i class="fa fa-angle-double-right"></i>Àreas de Formação</a></li>
                    <li><a href={{ url('/ministerios')}}><i class="fa fa-angle-double-right"></i>Ministérios</a></li>
                    <li><a href={{ url('/areasministerios')}}><i class="fa fa-angle-double-right"></i>Àreas de Ministérios</a></li>
                    <li><a href={{ url('/atividades')}}><i class="fa fa-angle-double-right"></i>Atividades</a></li>
                    <li><a href={{ url('/dons')}}><i class="fa fa-angle-double-right"></i>Dons Espirituais</a></li>
                    <li><a href={{ url('/tipospresenca')}}><i class="fa fa-angle-double-right"></i>Tipos de Presença</a></li>
                    <li><a href={{ url('/tiposmovimentacao')}}><i class="fa fa-angle-double-right"></i>Tipos de Mov. Membros</a></li>
                    <li><a href={{ url('/grausparentesco')}}><i class="fa fa-angle-double-right"></i>Graus de Parentesco</a></li>
                    <li><a href={{ url('/cargos')}}><i class="fa fa-angle-double-right"></i>Cargos / Funções</a></li>
                    <li><a href={{ url('/ramos')}}><i class="fa fa-angle-double-right"></i>Ramos de Atividades</a></li>
                    <li><a href={{ url('/civis')}}><i class="fa fa-angle-double-right"></i>Estados Civis</a></li>
                    <li><a href={{ url('/religioes')}}><i class="fa fa-angle-double-right"></i>Religiões</a></li>
                    <li><a href={{ url('/habilidades')}}><i class="fa fa-angle-double-right"></i>Habilidades</a></li>
                    <li><a href={{ url('/disponibilidades')}}><i class="fa fa-angle-double-right"></i>Disponibilidades de Tempo</a></li>
                    <li><a href={{ url('/situacoes')}}><i class="fa fa-angle-double-right"></i>Situações</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                <i class="fa fa-table"></i> <span>Membros</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/tables/simple.html"><i class="fa fa-angle-double-right"></i> Cadastro</a></li>
                    <li><a href="pages/tables/data.html"><i class="fa fa-angle-double-right"></i> Data tables</a></li>
                </ul>
            </li>

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
            <li class="treeview">
                <a href="#">
                <i class="fa fa-folder"></i> <span>Examples</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/examples/invoice.html"><i class="fa fa-angle-double-right"></i> Invoice</a></li>
                    <li><a href="pages/examples/login.html"><i class="fa fa-angle-double-right"></i> Login</a></li>
                    <li><a href="pages/examples/register.html"><i class="fa fa-angle-double-right"></i> Register</a></li>
                    <li><a href="pages/examples/lockscreen.html"><i class="fa fa-angle-double-right"></i> Lockscreen</a></li>
                    <li><a href="pages/examples/404.html"><i class="fa fa-angle-double-right"></i> 404 Error</a></li>
                    <li><a href="pages/examples/500.html"><i class="fa fa-angle-double-right"></i> 500 Error</a></li>
                    <li><a href="pages/examples/blank.html"><i class="fa fa-angle-double-right"></i> Blank Page</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                <i class="fa fa-share"></i> <span>Multilevel</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-angle-double-right"></i> Level One</a></li>
                    <li>
                        <a href="#"><i class="fa fa-angle-double-right"></i> Level One <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="#"><i class="fa fa-angle-double-right"></i> Level Two</a></li>
                            <li>
                                <a href="#"><i class="fa fa-angle-double-right"></i> Level Two <i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                    <li><a href="#"><i class="fa fa-angle-double-right"></i> Level Three</a></li>
                                    <li><a href="#"><i class="fa fa-angle-double-right"></i> Level Three</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#"><i class="fa fa-angle-double-right"></i> Level One</a></li>
                </ul>
            </li>

            <li><a href="documentation/index.html"><i class="fa fa-book"></i> Documentation</a></li>
            <li class="header">LABELS</li>
            <li><a href="#"><i class="fa fa-angle-double-right text-danger"></i> Important</a></li>
            <li><a href="#"><i class="fa fa-angle-double-right text-warning"></i> Warning</a></li>
            <li><a href="#"><i class="fa fa-angle-double-right text-info"></i> Information</a></li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>