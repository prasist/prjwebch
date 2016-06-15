@extends('principal.master')
@section('content')
<!-- Small boxes (Stat box) -->

<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>0,00</h3>
                <p>À Receber hoje</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-arrow-down"></i>
            </div>
            <a href="#" class="small-box-footer">Até o final do Mês : <i class="fa fa-arrow-circle-right"></i> <h4>0,00</h4></a>
        </div>
    </div><!-- ./col -->

    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>0,00</h3>
                <p>À Pagar Hoje</p>
            </div>
            <div class="icon">
                <i class="ion ion-android-arrow-up"></i>
            </div>
             <a href="#" class="small-box-footer">Até o final do Mês : <i class="fa fa-arrow-circle-right"></i> <h4>0,00</h4></a>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>0,00</h3>
                <p>Saldo Caixinha</p>
            </div>
            <div class="icon">
                <i class="ion ion-cash"></i>
            </div>
            <a href="#" class="small-box-footer">Saldo Todas Contas Ativas : <i class="fa fa-arrow-circle-right"></i> <h4>0,00</h4></a>
        </div>
    </div><!-- ./col -->

</div><!-- /.row -->

<script type="text/javascript">

    $(document).ready(function(){

       $("#financ").addClass("treeview active");

    });

</script>

@endsection

