<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    //

    public $timestamps = false;

    public function usuarios() {

         return $this->hasOne('App\Models\usuarios');

    }

}
