<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pessoas extends Model
{

    public $timestamps = false;
    protected $table = "pessoas";

    public function clientes_cloud()
    {
        return $this->belongsTo('App\Models\clientes_cloud');
    }

}