?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tiposrelacionamentos extends Model
{

    public $timestamps = false;
    protected $table = "tipos_relacionamentos";

    public function clientes_cloud()
    {

        return $this->belongsTo('App\Models\clientes_cloud');

    }

}
