@extends('principal.master')
@section('content')


    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-4">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              @if (rtrim($membro[0]->caminhofoto)!="")
                     <img class="profile-user-img img-responsive img-circle" src="{{ url('/images/persons/' . $membro[0]->caminhofoto) }}" alt="Foto">
              @endif

              <h3 class="profile-username text-center">
                @if (Auth::user())
                      Olá <b>{!!Auth::user()->name!!}</b>, Seja Bem-Vindo(a).
                @endif
              </h3>

              @if ($membro[0]->nome!="")
                      <br/>
                      Sua Célula é <b>{{$membro[0]->nome}}</b> toda <b>{{$membro[0]->descricao_dia_encontro}}</b> às <b>{{$membro[0]->horario}}</b>.
                      <br/>
              @else
                     Você não participa de nenhuma célula ainda...
              @endif

            <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">

                     @if ($membro[0]->fone_principal)
                        <i class="fa fa-home"></i> {{$membro[0]->fone_principal}}
                    @endif

                    @if ($membro[0]->fone_secundario)
                        &nbsp;&nbsp;<i class="fa fa-phone"></i> {{$membro[0]->fone_secundario}}
                    @endif

                    @if ($membro[0]->fone_celular)
                        <br/><i class="fa fa-mobile-phone"></i> {{$membro[0]->fone_celular}}
                    @endif

                    @if ($membro[0]->emailprincipal)
                           <br/><i class="fa fa-envelope-o"></i> {{$membro[0]->emailprincipal}}
                    @endif
                </li>
              </ul>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
        <div class="col-md-8">


              <div class="row">
                <!-- The timeline -->
                <ul class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-blue">
                          Pŕoximo Encontro {{$materiais[0]->data_encontro_formatada}}
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-commenting-o bg-yellow"></i>

                    <div class="timeline-item">

                      <h3 class="timeline-header"><a href="#">Informações</a></h3>

                      <div class="timeline-body">
                      @if ($materiais)
                        @if ($materiais[0]->texto!="")
                              {{$materiais[0]->texto}}
                        @endif
                     @endif
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->

                  <!-- END timeline item -->
                  <!-- timeline item -->

                  <!-- END timeline item -->
                  <!-- timeline time label -->

                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-file-text-o bg-blue"></i>

                    <div class="timeline-item">

                      <h3 class="timeline-header"><a href="#">Materiais do Encontro</a></h3>

                      <div class="timeline-body">
                      @if ($materiais)
                      @foreach($materiais as $item)
                       @if ($item->arquivo!="")
                          <tr id="{{$item->id}}">
                              <a href="{{ url('/images/persons/' . $item->arquivo) }}" target="_blank">{{$item->arquivo}}
                                <img src="{{ url('/images/files-download-file-icon.png') }}" alt="..." width="100" height="100" class="margin">
                                </a>
                          </tr>
                       @endif
                      @endforeach
                      @endif

                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->

                </ul>
              </div>

      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->



@endsection