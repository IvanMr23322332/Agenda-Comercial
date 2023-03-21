<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descuentos_presupuesto extends Model
{
    use HasFactory;

    protected $table = 'descuentos_presupuestos';
    protected $primaryKey = 'des_pre_id';

    public $timestamps = false;

    public function soportes_presupuestos(){
      return $this->belongsTo(Soportes_Presupuesto::class,'des_pre_soporte');
    }

    public function duracion_presupuestos(){
      return $this->belongsTo(Duracion_Presupuesto::class,'des_pre_duracion');
    }
}
