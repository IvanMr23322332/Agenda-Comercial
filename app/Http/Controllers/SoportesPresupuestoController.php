<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Http\Controllers\Controller;
use App\Models\Soportes_Presupuesto;

use Illuminate\Support\Facades\DB;

class SoportesPresupuestoController extends Controller
{
    public function consultarSoportesPresupuesto() {
        $sop_pre = soportes_presupuestos::select ('sop_pre_nombre', 'sop_pre_id')
           -> orderBy ('sop_pre_id')
           -> get();

           return view('form_presupuesto',[ 'sop_pre' => $sop_pre ]);
    }
}
