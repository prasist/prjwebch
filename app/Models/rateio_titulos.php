<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rateio_titulos extends Model
{

    public $timestamps = false;
    protected $table = "rateio_titulo";
<<<<<<< HEAD
    protected $fillable = array('empresas_id', 'empresas_clientes_cloud_id', 'titulos_id', 'centros_custos_id', 'valor', 'percentual');
=======
    protected $fillable = array('empresas_id', 'empresas_clientes_cloud_id', 'titulos_id', 'planos_contas_id', 'centros_custos_id', 'valor', 'percentual');
>>>>>>> 120dea74f7aae4b7cf0346eef1fc6007bb8de774

}
