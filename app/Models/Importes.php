<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Importes extends Model
{
    use HasFactory;

    protected $table = 'importes';
    protected $primaryKey = 'imp_id';

    protected $appends = [
        'total_string'
    ];

    public function Anunciantes(){
        return $this->belongsTo(Anunciantes::class,'imp_anu');
    }

    public function Soportes(){
        return $this->belongsTo(Soportes::class,'imp_sop');
    }

    public function Asesores(){
        return $this->belongsTo(Asesores::class,'imp_ase');
    }

    public function Mes(){
        return $this->belongsTo(Mes::class,'imp_mes');
    }

    public function Anyo(){
        return $this->belongsTo(Anyo::class,'imp_anyo');
    }

    public function getTotalStringAttribute(){
        return number_format($this -> imp_importe, 2, ',', '.');
    }

    public $timestamps = false;
}
