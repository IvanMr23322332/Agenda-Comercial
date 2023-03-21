<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soportes extends Model
{
    use HasFactory;

    protected $table = 'soportes';
    protected $primaryKey = 'sop_id';

    protected $appends = [
        'nombre_reducido'
    ];

    public $timestamps = false;

    public function Importes(){
        return $this->hasMany(Importes::class, 'imp_sop');
    }

    public function getNombreReducidoAttribute(){
        switch($this->sop_nombre){
            case "CADENA SER O.M.":
                return "CADENA SER";
                break;
            case "40 PRINCIPALES":
                return "40 PRINCIP.";
                break;
            case "RADIO ELCHE FM":
                return "RADIO ELCHE";
                break;
            case "INICIATIVAS DE PUBLICIDAD GENERAL,":
                return "INICIATIVAS";
                break;
            case "VALLAS PUBLICITARIAS":
                return "VALLAS PUBL.";
                break;
            case "ELCHE TV":
                return "ELCHE 7 TV";
                break;
            case "WEB":
                return "PAGINAS WEB";
                break;
            case "SER EMPRESARIOS":
                return "SER EMPRES.";
                break;
            case "INICIATIVAS DE PUBLICIDAD GENERAL J":
                return "INICIATIVAS J";
                break;
            case "TELEVISION DE ELCHE":
                return "TV DE ELCHE";
                break;
            case "SER PYMES":
                return "SER PYMES";
                break;
            case "ROTULACION Y COLOCACION VINILO":
                return "VINILOS";
                break;
        }
    }


}
