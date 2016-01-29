@extends('principal.master')

@section('content')

 <div class = 'container'>

        <p>Dados Cadastrais</p>

        <div>{{{ $errors->first('erros') }}}</div>
        <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">

                <div class="box-body">

                    <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                        <th>Razão Social</th>
                        <th>Nome Fantasia</th>
                        <th>CNPJ</th>
                        <th>Insc. Est.</th>
                        <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clientes_cloud as $value)

                        <tr>
                            <td>{{$value->razaosocial}}</td>
                            <td>{{$value->nomefantasia}}</td>
                            <td>{{$value->cnpj}}</td>
                            <td>{{$value->inscricaoestadual}}</td>

                            <td>
                                <div class = 'row'>
                                    <!-- <a href = '#modal1' class = 'delete btn-floating modal-trigger red' data-link = "/empresa/{{$value->id}}/deleteMsg" ><i class = 'material-icons'>delete</i></a> -->
                                    <a href = "{{ URL::to('cliente/' . $value->id . '/edit') }}" class = 'btn btn-success btn-flat' data-link = '/cliente/{{$value->id}}/edit'>Editar</a>
                                    <a href = "{{ URL::to('cliente/' . $value->id . '/preview') }}" class = 'btn btn-primary' data-link = '/cliente/{{$value->id}}'>Visualizar</a>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                </div>
            </div>
          </div>
         </div>
        </div>

  </div>

    <div id="modal1" class="modal">
        <div class = "row AjaxisModal">
        </div>
    </div>

@endsection