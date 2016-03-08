<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class financpessoas extends Model
{
    public $timestamps = false;
    protected $table = "financ_pessoas";
    protected $fillable = array('pessoas_id', 'endereco', 'numero', 'bairro', 'cep' , 'complemento', 'cidade', 'estado', 'bancos_id', 'empresas_clientes_cloud_id', 'empresas_id');
}