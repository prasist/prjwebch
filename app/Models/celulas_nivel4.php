<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class celulas_nivel4 extends Model
{

    public $timestamps = false;
    protected $table = "celulas_nivel4";
    protected $fillable = array('empresas_id', 'empresas_clientes_cloud_id', 'celulas_nivel1_id', 'celulas_nivel2_id', 'celulas_nivel3_id', 'nome text', 'pessoas_id');

}