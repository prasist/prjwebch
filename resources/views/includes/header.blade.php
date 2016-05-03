<header class="main-header">
    <!-- Logo -->
    <a href={{ url('/home')}} class="logo">
        <img src="{{ url('/images/clients/logo.png') }}" class="user-image" alt="Usuário Logado" width="100" height="30" />
    </a>

    <nav class="navbar navbar-static-top" role="navigation">

        <div id="tour4_visaogeral"></div>
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Navegação</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

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

                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <span class="label label-warning"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">Notificações</li>
                        <li>

                            <ul class="menu">
                                <li>

                                </li>

                            </ul>
                        </li>
                        <li class="footer"><a href="#">Ver Todas</a></li>
                    </ul>
                </li>


                <li class="dropdown user user-menu">
                    <div id="tour2_visaogeral"></div>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                    <!--<img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="user-image" alt="User Image"/>-->
                    @if (Auth::user()->path_foto!="")
                            <img src="{{ url('/images/users/' . Auth::user()->path_foto) }}" class="user-image" alt="Usuário Logado" />
                    @else
                            <img src="{{ url('/images/users/user.png') }}" class="user-image" alt="Usuário Logado" />
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
                                    <img src="{{ url('/images/users/user.png') }}" class="user-image" alt="Usuário Logado" />
                            @endif

                            <p>
                            {{ Auth::user()->name }}
                            <small>
                                Último Acesso : {!! \Session::get('ultimo_acesso') !!}
                                <br/>
                                I.P. : {!! \Session::get('ip') !!}
                            </small>
                            </p>
                        </li>


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