<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $primaryKey = 'cli_id';

    public function asesores(){
      return $this->belongsTo(Asesores::class,'cli_age');
    }

    public function metodos_pago(){
      return $this->belongsTo(metodos_pago::class,'cli_met_pago');
    }

    public function presupuestos(){
        return $this->hasMany(Presupuestos::class, 'pre_cliente');
    }

    public function historial_cambios(){
        return $this->hasMany(historial_cambios::class, 'hist_cliente');
    }

    public function eventos(){
        return $this->hasMany(eventos::class, 'eve_cliente');
    }
}
