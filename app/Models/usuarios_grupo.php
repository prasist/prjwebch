<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usuarios_grupo extends Model
{

    protected $table = "usuarios_grupo";
    public $timestamps = false;

    /*  Exemplo da query
    *   $dados = usuarios_grupo::find(1)->grupos;
    */
    public function grupos() {

        return $this->hasOne('App\Models\grupos', 'id');

    }

    public function permissoes_grupo () {

        return $this->hasMany('App\Models\permissoes_grupo', 'grupos_id');

    }

}