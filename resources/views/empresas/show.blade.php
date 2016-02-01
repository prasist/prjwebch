@extends('principal.master')

@section('content')

  <div class = 'container'>

        <p>Dados Cadastrais</p>

        <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">

                <div class="box-body">

                        <table class="table table-bordered table-hover">
                            <thead>
                                <th></th>
                                <th></th>
                            </thead>
                            <tbody>


                                <tr>
                                    <td>
                                        <b><i>Razão Social : </i></b>
                                    </td>
                                    <td>{{$empresas->razaosocial}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Nome Fantasia : </i></b>
                                    </td>
                                    <td>{{$empresas->nomefantasia}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>cnpj : </i></b>
                                    </td>
                                    <td>{{$empresas->cnpj}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Inscr. Estadual : </i></b>
                                    </td>
                                    <td>{{$empresas->inscricaoestadual}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Endereço : </i></b>
                                    </td>
                                    <td>{{$empresas->endereco}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Número</i></b>
                                    </td>
                                    <td>{{$empresas->numero}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Bairro : </i></b>
                                    </td>
                                    <td>{{$empresas->bairro}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>CEP : </i></b>
                                    </td>
                                    <td>{{$empresas->cep}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Complemento : </i></b>
                                    </td>
                                    <td>{{$empresas->complemento}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Cidade : </i></b>
                                    </td>
                                    <td>{{$empresas->cidade}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Estado : </i></b>
                                    </td>
                                    <td>{{$empresas->estado}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Fone principal : </i></b>
                                    </td>
                                    <td>{{$empresas->foneprincipal}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Fone II : </i></b>
                                    </td>
                                    <td>{{$empresas->fonesecundario}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Email : </i></b>
                                    </td>
                                    <td>{{$empresas->emailprincipal}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Email alternativo : </i></b>
                                    </td>
                                    <td>{{$empresas->emailsecundario}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Contato : </i></b>
                                    </td>
                                    <td>{{$empresas->nomecontato}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Celular : </i></b>
                                    </td>
                                    <td>{{$empresas->celular}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Status : </i></b>
                                    </td>
                                    <td>{{$empresas->ativo}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Website : </i></b>
                                    </td>
                                    <td>{{$empresas->website}}</td>
                                </tr>

                                <tr>
                                    <td>
                                        <b><i>Logo : </i></b>
                                    </td>
                                    <td>{{$empresas->caminhologo}}</td>
                                </tr>



                            </tbody>
                        </table>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>

@endsection