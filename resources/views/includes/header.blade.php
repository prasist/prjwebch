<header class="main-header">
    <!-- Logo -->
    <a href={{ url('/home')}} class="logo">SIGMA3</a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Navegação</span>
        </a>

        <!-- Aqui poderá ser colocado empresa e igreja logado -->

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->

                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-envelope-o"></i>
                    <span class="label label-success"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Você não tem novas mensagens</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li><!-- start message -->

                                        <!--
                                        <a href="#">
                                        <div class="pull-left">
                                            <!--<img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image"/>
                                        </div>
                                        <h4>
                                        Support Team
                                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                        </h4>
                                        <p>Why not buy a new awesome theme?</p>
                                        </a>
                                        -->
                                </li><!-- end message -->


                            </ul>
                        </li>
                        <li class="footer"><a href="#">Ver todas mensagens</a></li>
                    </ul>
                </li>
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <span class="label label-warning"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Notificações</li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>

                                </li>

                            </ul>
                        </li>
                        <li class="footer"><a href="#">Ver Todas</a></li>
                    </ul>
                </li>


                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                    <!--<img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image"/>-->
                    @if (Auth::user()->path_foto!="")
                            <img src="{{ url('/images/users/' . Auth::user()->path_foto) }}" class="user-image" alt="Usuário Logado" />
                    @else
                            <img src="{{ url('/dist/img/boxed-bg.jpg') }}" class="user-image" alt="Usuário Logado" />
                    @endif

                    <span class="hidden-xs">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <!--<img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image" />-->
                            @if (Auth::user()->path_foto!="")
                                    <img src="{{ url('/images/users/' . Auth::user()->path_foto) }}" class="user-image" alt="Usuário Logado" />
                            @else
                                    <img src="{{ url('/dist/img/boxed-bg.jpg') }}" class="user-image" alt="Usuário Logado" />
                            @endif

                            <p>
                            {{ Auth::user()->name }}
                            <small>{{ Auth::user()->created_at }}</small>
                            </p>
                        </li>

                        <!--

                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li>-->

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ URL::to('perfil/' . Auth::user()->id . '/perfil') }}" class="btn btn-default btn-flat">Perfil</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Encerrar Sessão</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>