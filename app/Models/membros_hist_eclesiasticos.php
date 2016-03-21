<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class membros_hist_eclesiasticos extends Model
{

    public $timestamps = false;
    protected $table = "membros_historicos_eclesiasticos";
    protected $fillable = array('pessoas_id', 'empresas_id', 'empresas_clientes_cloud_id', 'nome_igreja_anterior', 'telefone', 'religioes_id', 'cep', 'endereco', 'bairro', 'numero', 'cidade', 'estado', 'complemento', 'data_batismo', 'nome_igreja_batismo', 'celebrador', 'data_entrada', 'data_saida' , 'motivos_entrada_id', 'motivos_saida_id', 'registro_ata_entrada', 'registro_ata_saida', 'observacao');

}
