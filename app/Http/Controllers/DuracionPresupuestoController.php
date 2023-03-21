<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Http\Controllers\Controller;
use App\Models\Duracion_Presupuesto;

use Illuminate\Support\Facades\DB;

class DuracionPresupuestoController extends Controller
{
    public function consultarDuracionPresupuesto() {
        $dur_pre = duracion_presupuestos::select ('dur_pre_nombre', 'dur_pre_id', 'dur_pre_value')
           -> orderBy ('dur_pre_id')
           -> get();

           return view('form_presupuesto',[ 'dur_pre' => $dur_pre ]);
    }
}
