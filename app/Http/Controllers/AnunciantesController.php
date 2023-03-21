<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Http\Controllers\Controller;
use App\Models\Anunciantes;

use Illuminate\Support\Facades\DB;

class AnunciantesController extends Controller
{
    public function insertAnunciante($anu_nombre) {
        $obj_anunciantes = new Anunciantes;
        $obj_anunciantes -> anu_nombre = $anu_nombre;
        $consulta = NULL;

        try {
            $consulta = anunciantes::select ('anu_nombre')
               -> where ('anu_nombre','=',$anu_nombre)
               -> first();
            $consulta = $consulta -> anu_nombre;
        } catch (\Exception $e) {

        }


        if($consulta == NULL){
            try{
                $obj_anunciantes -> save();
            }
            catch(QueryException $e){
              $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){

                }
            }
        }


    }
}
