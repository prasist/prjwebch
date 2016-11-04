@extends('principal.master')

@section('content')

{{ \Session::put('titulo', 'Configurações Gerais') }}
{{ \Session::put('subtitulo', 'Atualização') }}
{{ \Session::put('route', 'config_gerais') }}
{{ \Session::put('id_pagina', '70') }}


<div class = 'row'>

    <div class="col-md-12">

    <div>
            <a href="{{ url('/' . \Session::get('route')) }}" class="btn btn-default"><i class="fa fa-arrow-circle-left"></i> Voltar</a>
    </div>

     <form method = 'POST' class="form-horizontal"  action = "{{ url('/' . \Session::get('route') . '/' . $dados[0]->id . '/update')}}">

       {!! csrf_field() !!}

        <div class="box box-primary">

                 <div class="box-body">

                            <div class="row">
                                    <div class="col-xs-10">
                                          <label for="padrao_textos" class="control-label">Padrão para gravação de conteúdo</label>

                                          <div ng-app="myApp">
                                            <div ng-controller="myCtrl">

                                                     <div >
                                                        <h3>List Employees</h3>
                                                        <table class="table table-striped table-bordered">
                                                          <thead>
                                                            <th>Employee Name</th>
                                                            <th>Edit</th>
                                                          </thead>
                                                          <tbody>
                                                            <tr ng-repeat="employee in employees">
                                                            <script type="text/ng-template" id="display">
                                                              <td>@{{employee.label_celulas}}</td>

                                                              <td>
                                                                <button type="button" class="btn btn-primary" ng-click="editEmployee(employee)">Edit</button>
                                                                <button type="button" class="btn btn-danger" ng-click="deleteEmployee(employee)">Delete</button>
                                                              </td>
                                                            </script>

                                                            <script type="text/ng-template" id="edit">
                                                              <td><input type="text" ng-model=employee.label_celulas class="form-control input-sm"/></td>
                                                              <td>
                                                                <button type="button" class="btn btn-primary" ng-click="updateEmployee(employee)">Save</button>
                                                                <button type="button" class="btn btn-danger" ng-click="reset()">Cancel</button>
                                                              </td>
                                                            </script>

                                                            </tr>
                                                          </tbody>
                                                        <table>

                                                      </div>

                                            </div>
                                          </div>

                                    </div>
                            </div>

            </div><!-- fim box-body"-->
        </div><!-- box box-primary -->

        <div class="box-footer">
            <button class = 'btn btn-primary' type ='submit' {{ ($preview=='true' ? 'disabled=disabled' : "" ) }}><i class="fa fa-save"></i> Salvar</button>
            <a href="{{ url('/' . \Session::get('route') )}}" class="btn btn-default">Cancelar</a>
        </div>

        </form>

    </div>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#menu_celulas").addClass("treeview active");
    });
</script>
@endsection