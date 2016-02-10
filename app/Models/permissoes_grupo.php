<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class permissoes_grupo extends Model
{
    //

    public $timestamps = false;
    protected $fillable = array('grupos_id', 'paginas_id', 'incluir', 'alterar', 'excluir', 'visualizar', 'exportar', 'imprimir', 'acessar');

  /*  public function usuarios_grupo() {

        return $this->hasMany('App\Models\usuarios_grupo');

    }

    public function paginas() {

            return $this->hasMany('App\Models\paginas','id');
   }*/


}
