<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesores extends Model
{
    use HasFactory;

    protected $table = 'asesores';
    protected $primaryKey = 'ase_id';

    protected $appends = [
        'total_importe',
        'total_string'
    ];

    public $timestamps = false;

    public function Importes(){
        return $this->hasMany(Importes::class, 'imp_ase');
    }

    //Funcion que dado un mes y año devuelva sumatorio de importes por asesor
    public function getTotalImporteAttribute(){

        $resultado = 0.0;

        foreach ($this->importes as $importe) {
            $resultado += (double)$importe->imp_importe;
        }

        return $resultado;
    }

    public function getTotalStringAttribute(){
        return number_format($this->total_importe, 2, ',', '.');
    }
}
