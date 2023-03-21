<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarifas_Presupuesto extends Model
{
    use HasFactory;

    protected $table = 'tarifas_presupuestos';
    protected $primaryKey = 'tar_pre_id';

    public $timestamps = false;

    public function soportes_presupuestos(){
      return $this->belongsTo(Soportes_Presupuesto::class,'tar_pre_soporte');
    }
}
