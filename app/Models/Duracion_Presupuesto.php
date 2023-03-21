<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duracion_Presupuesto extends Model
{
    use HasFactory;

    protected $table = 'duracion_presupuestos';
    protected $primaryKey = 'dur_pre_id';

    public $timestamps = false;
}
