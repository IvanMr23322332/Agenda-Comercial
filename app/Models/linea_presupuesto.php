<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linea_presupuesto extends Model
{
    use HasFactory;

    protected $table = 'linea_presupuestos';
    protected $primaryKey = 'lin_pre_id';

    public $timestamps = false;

    public function soportes_presupuestos(){
      return $this->belongsTo(Soportes_Presupuesto::class,'lin_pre_sop');
    }

    public function tarifas_presupuestos(){
      return $this->belongsTo(Tarifas_Presupuesto::class,'lin_pre_tar');
    }

    public function duracion_presupuestos(){
      return $this->belongsTo(Duracion_Presupuesto::class,'lin_pre_dur');
    }

    public function presupuestos(){
      return $this->belongsTo(Presupuestos::class,'lin_pre_pre');
    }
}
