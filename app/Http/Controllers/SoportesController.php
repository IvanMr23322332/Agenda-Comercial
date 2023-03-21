<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Http\Controllers\Controller;
use App\Models\Soportes;

use Illuminate\Support\Facades\DB;

class SoportesController extends Controller
{
    public function insertSoporte($sop_nombre) {
        $obj_soportes = new Soportes;
        $obj_soportes -> sop_nombre = $sop_nombre;

        $consulta = NULL;

        try {
            $consulta = soportes::select ('sop_nombre')
               -> where ('sop_nombre','=',$sop_nombre)
               -> first();
            $consulta = $consulta -> sop_nombre;
        } catch (\Exception $e) {

        }

        if($consulta == NULL){
            try{
                $obj_soportes -> save();
            }
            catch(QueryException $e){
              $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){

                }
            }
        }
    }

    public function consultarSoportes() {
        $consulta = DB::table('soportes')
           -> select ('sop_nombre', 'sop_id')
           -> orderBy ('sop_id')
           -> paginate (1000);

           return view('form_presupuesto',[ 'consultas' => $consulta ]);
    }
}
