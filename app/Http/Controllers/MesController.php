<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MesController extends Controller
{
    public function insertAnyo($mes_nombre) {
        $obj_mes = new Mes;
        $obj_mes -> mes_nombre = $mes_nombre;

        try{
            $obj_mes -> save();
        }
        catch(QueryException $e){
          $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){

            }
        }
    }
}
