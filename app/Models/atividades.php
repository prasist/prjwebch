<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class atividades extends Model
{

    public $timestamps = false;
    protected $table = "atividades";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }


}
