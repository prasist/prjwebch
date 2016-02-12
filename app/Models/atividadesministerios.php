<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class atividadesministerios extends Model
{

    public $timestamps = false;
    protected $table = "atividades_ministerio";

    public function ministerios()
    {

        return $this->belongsTo('App\Models\ministerios');

    }


}
