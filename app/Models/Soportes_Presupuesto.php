<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soportes_Presupuesto extends Model
{
    use HasFactory;

    protected $table = 'soportes_presupuestos';
    protected $primaryKey = 'sop_pre_id';

    public $timestamps = false;

    public function duracion_presupuestos(){
      return $this->belongsTo(Duracion_Presupuesto::class,'sop_pre_duracion');
    }
}
