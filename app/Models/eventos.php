<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eventos extends Model
{
    use HasFactory;

    protected $table = 'eventos';
    protected $primaryKey = 'eve_id';

    public function Clientes(){
        return $this->belongsTo(Clientes::class,'eve_cliente');
    }

    public function Asesores(){
        return $this->belongsTo(Asesores::class,'eve_asesor');
    }

    public function Presupuestos(){
        return $this->belongsTo(Presupuestos::class,'eve_presupuesto');
    }
}
