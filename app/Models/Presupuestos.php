<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuestos extends Model
{
    use HasFactory;

    protected $table = 'presupuestos';
    protected $primaryKey = 'pre_id';


    public function sociedades(){
      return $this->belongsTo(Sociedades::class,'pre_soc','id');
    }

    public function clientes(){
      return $this->belongsTo(Clientes::class,'pre_cliente','cli_id');
    }

    public function asesores(){
      return $this->belongsTo(Asesores::class,'pre_creador','ase_id');
    }
}
