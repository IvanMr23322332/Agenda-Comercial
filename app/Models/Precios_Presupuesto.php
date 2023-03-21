<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precios_Presupuesto extends Model
{
    use HasFactory;

    protected $table = 'precios_presupuestos';
    protected $primaryKey = 'pre_pre_id';

    public $timestamps = false;

    public function tarifas_presupuestos(){
      return $this->belongsTo(Tarifas_Presupuesto::class,'pre_pre_tarifa');
    }

    public function duracion_presupuestos(){
      return $this->belongsTo(Duracion_Presupuesto::class,'pre_pre_duracion');
    }
}
