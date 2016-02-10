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
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Pesquisar..."/>
                <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
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

            <!--
            <li class="treeview">
                <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Layout Options</span>
                <span class="label label-primary pull-right">4</span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/layout/top-nav.html"><i class="fa fa-angle-double-right"></i> Top Navigation</a></li>
                    <li><a href="pages/layout/boxed.html"><i class="fa fa-angle-double-right"></i> Boxed</a></li>
                    <li><a href="pages/layout/fixed.html"><i class="fa fa-angle-double-right"></i> Fixed</a></li>
                    <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-angle-double-right"></i> Collapsed Sidebar</a></li>
                </ul>
            </li>

            <li>
                <a href="pages/widgets.html">
                <i class="fa fa-th"></i> <span>Widgets</span> <small class="label pull-right bg-green">new</small>
                </a>
            </li>

            <li class="treeview">
                <a href="#">
                <i class="fa fa-pie-chart"></i>
                <span>Charts</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/charts/morris.html"><i class="fa fa-angle-double-right"></i> Morris</a></li>
                    <li><a href="pages/charts/flot.html"><i class="fa fa-angle-double-right"></i> Flot</a></li>
                    <li><a href="pages/charts/inline.html"><i class="fa fa-angle-double-right"></i> Inline charts</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                <i class="fa fa-laptop"></i>
                <span>UI Elements</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/UI/general.html"><i class="fa fa-angle-double-right"></i> General</a></li>
                    <li><a href="pages/UI/icons.html"><i class="fa fa-angle-double-right"></i> Icons</a></li>
                    <li><a href="pages/UI/buttons.html"><i class="fa fa-angle-double-right"></i> Buttons</a></li>
                    <li><a href="pages/UI/sliders.html"><i class="fa fa-angle-double-right"></i> Sliders</a></li>
                    <li><a href="pages/UI/timeline.html"><i class="fa fa-angle-double-right"></i> Timeline</a></li>
                    <li><a href="pages/UI/modals.html"><i class="fa fa-angle-double-right"></i> Modals</a></li>
                </ul>
            </li>
            -->

            <li class="treeview">
                <a href="#">
                <i class="fa fa-edit"></i> <span>Cadastro Base</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="pages/forms/general.html"><i class="fa fa-angle-double-right"></i> Tipo Pessoas</a></li>
                    <li><a href="pages/forms/advanced.html"><i class="fa fa-angle-double-right"></i> Estado Cívil</a></li>
                    <li><a href="pages/forms/editors.html"><i class="fa fa-angle-double-right"></i> Situações</a></li>
                    <li><a href="pages/forms/general.html"><i class="fa fa-angle-double-right"></i> Tipo Pessoas</a></li>
                    <li><a href="pages/forms/advanced.html"><i class="fa fa-angle-double-right"></i> Estado Cívil</a></li>
                    <li><a href="pages/forms/editors.html"><i class="fa fa-angle-double-right"></i> Situações</a></li>
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