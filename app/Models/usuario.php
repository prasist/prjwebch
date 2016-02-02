<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usuario extends Model
{
    //
    protected $table = "usuarios";
    public $timestamps = false;

    public function usuarios_grupo() {

         return $this->hasMany('App\Models\usuarios_grupo');
    }

}
