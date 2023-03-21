<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Http\Controllers\Controller;
use App\Models\Anyo;

use Illuminate\Support\Facades\DB;

class AnyoController extends Controller
{

    public function insertAnyo($anyo_nombre) {
        $obj_anyo = new Anyo;
        $obj_anyo -> anyo_nombre = $anyo_nombre;


        $consulta = NULL;

        try {
            $consulta = anyo::select ('anyo_nombre')
               -> where ('anyo_nombre','=',$anyo_nombre)
               -> first();
            $consulta = $consulta -> anu_nombre;
        } catch (\Exception $e) {

        }

        if($consulta == NULL){
            try{

                $obj_anyo -> save();
            }
            catch(QueryException $e){
              $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){

                }
            }
        }
    }
}
