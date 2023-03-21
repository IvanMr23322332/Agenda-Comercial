<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Optico_fila extends Model
{
    use HasFactory;

    protected $table = 'optico_filas';
    protected $primaryKey = 'opt_fil_id';

    public $timestamps = false;

    public function Mes(){
      return $this->belongsTo(Mes::class,'opt_fil_mes');
    }
    public function soportes_presupuestos(){
      return $this->belongsTo(Soportes_Presupuesto::class,'opt_fil_sop');
    }
    public function tarifas_presupuestos(){
      return $this->belongsTo(Tarifas_Presupuesto::class,'opt_fil_tar');
    }
    public function duracion_presupuestos(){
      return $this->belongsTo(Duracion_Presupuesto::class,'opt_fil_dur');
    }
    public function presupuestos(){
      return $this->belongsTo(presupuestos::class,'opt_fil_pre');
    }
    public function linea_presupuestos(){
      return $this->belongsTo(linea_presupuesto::class,'opt_fil_lin');
    }
}
