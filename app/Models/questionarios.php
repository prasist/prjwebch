<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class questionarios extends Model
{

    public $timestamps = false;
    protected $table = "questionario_encontro";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }

}
