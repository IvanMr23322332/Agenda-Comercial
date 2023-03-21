<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historico_gestiones extends Model
{
    use HasFactory;

    protected $table = 'historico_gestiones';
    protected $primaryKey = 'id';

    public function clientes(){
        return $this -> belongsTo (Clientes::class, 'hist_gest_cliente', 'cli_id');
    }
}
