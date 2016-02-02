<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class permissoes_grupo extends Model
{
    //

    public $timestamps = false;

    public function usuarios_grupo() {

        return $this->hasMany('App\Models\usuarios_grupo');

    }

    public function paginas() {

            return $this->hasMany('App\Models\paginas');
   }


}
