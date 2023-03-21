<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Http\Controllers\Controller;
use App\Models\Asesores;

use Illuminate\Support\Facades\DB;

class AsesoresController extends Controller
{
  public function insertAsesor($ase_nombre) {
        $obj_asesores = new Asesores;
        $obj_asesores -> ase_nombre = $ase_nombre;

        $consulta = NULL;


        try {
            $consulta = asesores::select ('ase_nombre')
               -> where ('ase_nombre','=',$ase_nombre)
               -> first();
            $consulta = $consulta -> ase_nombre;
        } catch (\Exception $e) {

        }

        if($consulta == NULL){
            try{
                $obj_asesores -> save();
            }
            catch(QueryException $e){
              $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){

                }
            }
        }
    }
}
