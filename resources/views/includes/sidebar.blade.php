<!-- Left side column. contains the logo and sidebar -->


<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">

            <div id="tour1"></div>
            <div id="tour3_visaogeral"></div>

            <!--Foto usuário -->
            <div class="pull-left image">

                @if (Auth::user()->path_foto!="")
                        <img src="{{ url('/images/users/' . Auth::user()->path_foto) }}" class="img-circle" alt="Usuário Logado" />
                @else
                        <img src="{{ url('/images/users/user.png') }}" class="img-circle" alt="Usuário Logado" />
                @endif

            </div>
            <!-- ************* -->

            <!-- Usuário logado-->
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="{{ URL::to('perfil/' . Auth::user()->id . '/perfil') }}"><i class="fa fa-user text-success"></i> Alterar Perfil</a>
            </div>
            <!-- ************** -->

        </div>

         <!-- search form -->
      <!--<form action="#" method="get" id="form_procurar_pessoa" class="sidebar-form">-->
      <form name ="form_principal" method = 'get' class="sidebar-form"  action = {{ url('/pessoas/buscar_nome')}}>
        <div class="input-group">
          <input type="text" name="razaosocial" id="razaosocial" class="form-control" placeholder="Localizar Pessoas...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>


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
                <ul  class="treeview-menu">
                    <li>
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

            <div id="tour2"></div>

           <li class="treeview">
                <a href="#">
                <i class="fa fa-edit"></i> <span>Cadastros Base</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    <li class="text">&nbsp;</li>
                    <li><a href={{ url('/bancos')}}><i class="fa fa-angle-double-right"></i>Bancos</a></li>
                    <li><a href={{ url('/cargos')}}><i class="fa fa-angle-double-right"></i>Cargos / Funções</a></li>
                    <li><a href={{ url('/ramos')}}><i class="fa fa-angle-double-right"></i>Ramos de Atividades</a></li>
                    <li><a href={{ url('/civis')}}><i class="fa fa-angle-double-right"></i>Estados Civis</a></li>
                    <li><a href={{ url('/idiomas')}}><i class="fa fa-angle-double-right"></i>Idiomas</a></li>
                    <li><a href={{ url('/graus')}}><i class="fa fa-angle-double-right"></i>Graus de Instrução</a></li>
                    <li><a href={{ url('/areas')}}><i class="fa fa-angle-double-right"></i>Àreas de Formação</a></li>
                    <li><a href={{ url('/profissoes')}}><i class="fa fa-angle-double-right"></i>Profissões</a></li>
                    <li><a href={{ url('/grausparentesco')}}><i class="fa fa-angle-double-right"></i>Graus de Parentesco</a></li>
                    <li><a href={{ url('/disponibilidades')}}><i class="fa fa-angle-double-right"></i>Disponibilidades de Tempo</a></li>
                    <li><a href={{ url('/publicos')}}><i class="fa fa-angle-double-right"></i>Públicos Alvos</a></li>
                    <li><a href={{ url('/faixas')}}><i class="fa fa-angle-double-right"></i>Faixas Etárias</a></li>

                    <li class="text">&nbsp;</li>
                    <li><a href={{ url('/igrejas')}}><i class="fa fa-angle-double-right"></i>Igrejas</a></li>
                    <li><a href={{ url('/religioes')}}><i class="fa fa-angle-double-right"></i>Religiões</a></li>
                    <li><a href={{ url('/ministerios')}}><i class="fa fa-angle-double-right"></i>Ministérios</a></li>
                    <li><a href={{ url('/atividades')}}><i class="fa fa-angle-double-right"></i>Atividades</a></li>
                    <li><a href={{ url('/dons')}}><i class="fa fa-angle-double-right"></i>Dons Espirituais</a></li>
                    <li><a href={{ url('/habilidades')}}><i class="fa fa-angle-double-right"></i>Habilidades</a></li>

                    <li class="text">&nbsp;</li>
                    <li><a href={{ url('/status')}}><i class="fa fa-angle-double-right"></i>Status</a></li>
                    <li><a href={{ url('/situacoes')}}><i class="fa fa-angle-double-right"></i>Situações</a></li>
                    <li><a href={{ url('/tipospessoas')}}><i class="fa fa-angle-double-right"></i>Tipos de Pessoas</a></li>
                    <li><a href={{ url('/grupospessoas')}}><i class="fa fa-angle-double-right"></i>Grupos de Pessoas</a></li>
                    <li class="text">&nbsp;</li>
                    <li><a href={{ url('/tipospresenca')}}><i class="fa fa-angle-double-right"></i>Tipos de Presença</a></li>
                    <li><a href={{ url('/tiposmovimentacao')}}><i class="fa fa-angle-double-right"></i>Tipos de Mov. Membros</a></li>
                    <li><a href={{ url('/tiposrelacionamentos')}}><i class="fa fa-angle-double-right"></i>Tipos de Relacionamentos</a></li>
                    <li><a href={{ url('/questionarios')}}><i class="fa fa-angle-double-right"></i>Questionário Padrão Encontros</a></li>

                </ul>
            </li>


            <li class="treeview" id="pessoas">
                <a href="#">
                <i class="fa fa-user"></i><span>Pessoas</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                 <ul class="treeview-menu">
                        <li><a href={{ url('/pessoas')}}><i class="fa fa-file-text-o"></i> Listar / Cadastrar</a></li>
                        <li><a href={{ url('/relpessoas')}}><i class="fa fa-print"></i> Relatórios</a></li>
                 </ul>
             </li>


            <!-- Células -->
            <li class="treeview">
              <a href="#">
                <i class="fa fa-users"></i> <span>Gestão de Células</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>

                 <ul class="treeview-menu">
                    <a href={{ url('/configuracoes')}}><li><i class="fa fa-wrench"></i>Configurações</a></li>
                    <li>
                      <a href="#"><i class="fa fa-sitemap"></i> Estruturas <i class="fa fa-angle-left pull-right"></i></a>
                          <ul class="treeview-menu">
                            <li><a href={{ url('/estruturas1')}}> 1 - {{ Session::get('nivel1') }}</a></li>
                            <li><a href={{ url('/estruturas2')}}> 2 - {{ Session::get('nivel2') }}</a></li>
                            <li><a href={{ url('/estruturas3')}}> 3 - {{ Session::get('nivel3') }}</a></li>
                            <li><a href={{ url('/estruturas4')}}> 4 - {{ Session::get('nivel4') }}</a></li>
                            <li><a href={{ url('/estruturas5')}}> 5 - {{ Session::get('nivel5') }}</a></li>
                          </ul>
                    </li>
                </ul>

                  <ul class="treeview-menu">
                    <li>
                      <a href="#"><i class="fa fa-street-view"></i> Células <i class="fa fa-angle-left pull-right"></i></a>
                          <ul class="treeview-menu">
                            <li><a href={{ url('/celulas')}}> Listar / Cadastrar</a></li>
                            <li><a href={{ url('/celulaspessoas')}}> Células / Participantes</a></li>
                          </ul>
                    </li>
                  </ul>

                  <ul class="treeview-menu">
                    <li>
                        <a href={{ url('/relcelulas')}}><i class="fa fa-print"></i> Relatórios</a>

                    </li>
                  </ul>

                  <ul class="treeview-menu">
                    <li>
                      <a href="#"><i class="fa fa-circle-o"></i> Controle de Atividades <i class="fa fa-angle-left pull-right"></i></a>
                          <ul class="treeview-menu">
                            <li><a href="#"> Encontros</a></li>
                          </ul>
                    </li>
                  </ul>

            </li>


          <li class="treeview" id="financ">

                <a href="#" onclick="redirecionar();">
                    <i class="fa fa-usd"></i><span>Financeiro</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>

                 <ul class="treeview-menu">

                 <li><a href="{!! url('/financeiro') !!}"><i class="fa fa-bar-chart"></i>Visão Geral</a></li>
                  <li>
                    <a href="#"><i class="fa fa-file-text-o"></i>Cadastros Base <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                      <li><a href="{!! url('/bancos') !!}">Bancos</a></li>
                      <li><a href="{!! url('/grupos_titulos') !!}"> Grupos de Títulos</a></li>
                      <li><a href="{!! url('/planos_contas') !!}"> Planos de Contas</a></li>
                      <li><a href="{!! url('/centros_custos') !!}"> Centros de Custos</a></li>
                      <li><a href="{!! url('/contas') !!}"> Contas Correntes</a></li>
                    </ul>
                  </li>

                  <li>
                    <a href="#"><i class="fa fa-calendar-plus-o"></i>Contas a Pagar <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                      <li><a href="{!! url('/titulos/P') !!}">Lançamentos</a></li>
                    </ul>
                  </li>

                  <li>
                    <a href="#"><i class="fa fa-money"></i>Contas a Receber <i class="fa fa-angle-left pull-right"></i></a>
                    <ul class="treeview-menu">
                      <li><a href="{!! url('/titulos/R') !!}">Lançamentos</a></li>
                    </ul>
                  </li>

                  <li>
                    <a href="#"><i class="fa fa-angle-double-right"></i>Transferências</i></a>
                  </li>

                  <li>
                    <a href="{!! url('/relfinanceiro') !!}"><i class="fa fa-angle-double-right"></i>Relatórios</i></a>
                  </li>

              </ul>

         </li>

          <li class="header">Precisa de Ajuda ?</li>
          <li class="treeview">
                  <a href="#">
                    <i class="fa fa-book"></i> <span>Ajuda / Documentação</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>

                    <ul class="treeview-menu">
                        <li>
                          <a href="#"><i class="fa fa-angle-double-right"></i>Tour Rápido </i></a>
                          <ul class="treeview-menu">
                            <li><a href={{ url('/quicktour/reload/2')}}><i class="fa fa-flag-checkered"></i> Visão Geral do SIGMA3</a></li>
                            <li><a href={{ url('/quicktour/reload/1')}}><i class="fa fa-flag-checkered"></i> Cadastrar Novo Usuário</a></li>
                          </ul>
                        </li>

                        <li>
                          <a href="#"><i class="fa fa-angle-double-right"></i>Tutoriais</i></a>
                          <ul class="treeview-menu">
                            <li><a href={{ url('/tutoriais/1')}}>Cadastro de Usuários</a></li>
                            <li><a href={{ url('/tutoriais/2')}}>Novo Usuário Administrador</a></li>
                          </ul>
                        </li>
                    </ul>

                    <div id="tour5_visaogeral"></div>

               </li>

              <li class="treeview">
                  <a href={{ url('/suporte')}}>
                      <i class="fa fa-question-circle"></i> <span>Suporte</span>
                  </a>
              </li>

    </section>
    <!-- /.sidebar -->
</aside>
<script type="text/javascript">

function redirecionar()
{

  var_pagina = "{!! url('/financeiro') !!}";
  window.location=var_pagina;

}

function redirecionar_pessoas()
{

  var_pagina = "{!! url('/pessoas') !!}";
  window.location=var_pagina;

}
</script>