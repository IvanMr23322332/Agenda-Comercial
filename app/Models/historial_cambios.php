<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historial_cambios extends Model
{
    use HasFactory;

    protected $table = 'historial_cambios';
    protected $primaryKey = 'imp_id';

    protected $appends = [
        'fecha'
    ];

    public function Clientes(){
        return $this->belongsTo(Clientes::class,'hist_cliente');
    }

    public function Asesores(){
        return $this->belongsTo(Asesores::class,'hist_asesor');
    }

    public function Presupuestos(){
        return $this->belongsTo(Presupuestos::class,'hist_presupuesto');
    }

    public function getfechaAttribute(){
        return date("Y-m-d",strtotime($this->created_at));
    }

}
