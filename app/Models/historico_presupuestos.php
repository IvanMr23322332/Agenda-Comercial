<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historico_presupuestos extends Model
{
    use HasFactory;

    protected $table = 'historico_presupuestos';
    protected $primaryKey = 'id';

    public function clientes(){
        return $this -> belongsTo (Clientes::class, 'hist_pres_cliente', 'cli_id');
    }

    public function presupuestos(){
        return $this -> belongsTo (Presupuestos::class, 'hist_pres_presupuesto', 'pre_id');
    }
}
