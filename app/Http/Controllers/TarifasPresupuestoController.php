<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Http\Controllers\Controller;
use App\Models\Tarifas_Presupuesto;

use Illuminate\Support\Facades\DB;

class TarifasPresupuestoController extends Controller
{
    public function consultarTarifasPresupuesto() {
        $tar_pre = tarifas_presupuestos::select ('tar_pre_nombre', 'tar_pre_id', 'tar_pre_soporte')
           -> orderBy ('tar_pre_id')
           -> get ();

           return view('form_presupuesto',[ 'tar_pre' => $tar_pre ]);
    }
}
