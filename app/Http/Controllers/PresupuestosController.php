<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Models\Importes;
use App\Http\Controllers\Controller;
use App\Models\Soportes_Presupuesto;
use App\Models\Tarifas_Presupuesto;
use App\Models\Duracion_Presupuesto;
use App\Models\Descuentos_presupuesto;
use App\Models\Precios_Presupuesto;
use App\Models\Presupuestos;
use App\Models\linea_presupuesto;
use App\Models\Optico_fila;
use App\Models\Clientes;
use App\Models\Sociedades;
use App\Models\Users;
use App\Models\historial_cambios;
use App\Models\metodos_pago;
use App\Models\historico_presupuestos;
use App\Models\eventos;

use Illuminate\Support\Facades\DB;

class PresupuestosController extends Controller
{

    public function guardar_presupuesto(Request $request){
        session_start();
        $contador_soporte = 1;
        $numero_filas;
        $nombre;
        $IDs;
        $estado;
        //Llenar este array con un valor representativo de todas las filas del optico, independientemente de tipo
        $filas = array();

        // TODO GUARDAR DATOS EN BD
        $fact_anu = $_POST["factAnual"];
        $antig    = $_POST["antig"];
        if(isset($_POST["prontoPago"])){
            $pronto_pago = true;
        } else {
            $pronto_pago = false;
        }

        if(isset($_POST["true_cont"])){
            $contador = $_POST["true_cont"];
        } else {
            $contador = 0;
        }

        $i = 0;
        $datemin = mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+100);
        $datemax = mktime(0, 0, 0, date("m"),   date("d"),   date("Y"));

        while ($contador) {
            if(isset($_POST["sop_id" . $i])) {
                if($_POST["fechaini" . $i] < $datemin) {
                    $datemin = $_POST["fechaini" . $i];
                }
                if($_POST["fechafin" . $i] > $datemax) {
                    $datemax = $_POST["fechafin" . $i];
                }
                $i++;
                $contador--;
                //echo nl2br("Encontrado, Contador -- i\n");
            } else {
                $i++;
                //echo nl2br("No encontrado, iterando i\n");
            }

        }

        $cliente = clientes::where('cli_anu', '=', $_POST['cliente_anunciante'])
            ->get();

            if($_POST['formPago'] == ""){
                $metpago = NULL;
            }
            else{
                $metpago = metodos_pago::where('met_pago_desc','=',$_POST['formPago'])->get()[0];

            }

        if($metpago == NULL){
            $cliente[0] -> cli_met_pago = NULL;
        }
        else{
            $cliente[0] -> cli_met_pago = $metpago -> met_pago_id;
        }

        if($_POST['iban'] == NULL){
            $cliente[0] -> cli_iban = NULL;
        }
        else{
            $cliente[0] -> cli_iban = $_POST['iban'];
        }


        $cliente[0] -> save();

        $obj_pre = new presupuestos;
        $obj_pre -> pre_fact_anu   = $fact_anu;
        $obj_pre -> pre_antig      = $antig;
        $obj_pre -> pre_pront_pago = $pronto_pago;
        if(isset($_POST["mod_id"])){
            $obj_pre -> pre_estado     = "PRESENTADO";
            $estado = "PRESENTADO";
        }
        else {
            $obj_pre -> pre_estado     = "PENDIENTE";
            $estado = "PENDIENTE";
        }
        if(isset($_POST['accion_comercial_id'])){
            $obj_pre -> pre_acc_com = $_POST['accion_comercial_id'];
        }

        $obj_pre -> pre_tot_brut   = floatval(substr($_POST["totalbrut"], 0, -2));
        $obj_pre -> pre_tot_desc   = floatval(substr($_POST["totaldesc"], 0, -2));
        $obj_pre -> pre_tot_neto   = floatval(substr($_POST["totalneto"], 0, -2));
        $obj_pre -> pre_cliente    = $cliente[0]->cli_id;
        $obj_pre -> pre_dateini    = $datemin;
        $obj_pre -> pre_datefin    = $datemax;
        $obj_pre -> pre_soc        = $_POST['razon_social'];
        $obj_pre -> pre_emisora    = $_POST['emisora'];
        $obj_pre -> pre_creador    = $_SESSION['id_ase'];
        $obj_pre -> pre_valido     = true;
        $obj_pre -> pre_pago_valido = $_POST['pago_valido'];

        if(isset($_POST['observ'])){
            $obj_pre -> pre_observ = $_POST['observ'];
        }

        if (isset($_POST['id_accion'])) {
            $obj_pre -> pre_acc_com = $_POST['id_accion'];
        }

        //vaciar el campo presupuesto de las filas del historial_cambios

        if(isset($_POST["mod_id"])){

            $target = $_POST["mod_id"];

            $IDs = historial_cambios::select('id')
                ->where('hist_presupuesto','=',$target)
                ->get();

            foreach ($IDs as $id) {
                historial_cambios::where('id','=',$id->id)
                    ->update(['hist_presupuesto' => null]);
            }

            optico_fila::where('opt_fil_pre', '=', $target) -> delete();
            linea_presupuesto::where('lin_pre_pre', '=', $target) -> delete();
            $fecha_presentacion = presupuestos::find($target)->pre_dateprox;
            historico_presupuestos::where('hist_pres_presupuesto', '=', $target) -> delete();
            $aux_eve = eventos::where('eve_presupuesto', '=', $target) -> get()[0];
            eventos::where('eve_presupuesto', '=', $target) -> delete();
            presupuestos::where('pre_id', '=', $target) -> delete();
            $obj_pre -> pre_id = $target;
            $obj_pre -> pre_dateprox = $fecha_presentacion;
        }


        $obj_pre -> save();

        if(isset($_POST["mod_id"])){
            foreach ($IDs as $id) {
                historial_cambios::where('id','=',$id->id)
                    ->update(['hist_presupuesto' => $obj_pre -> pre_id]);
            }

            // //Añadir registro a la tabla de historico de Presupuestos
            $obj_hist_pres = new historico_presupuestos;
            $obj_hist_pres -> hist_pres_cliente = $obj_pre -> pre_cliente;
            $obj_hist_pres -> hist_pres_estado_cliente = $cliente[0]->cli_est_cli;
            $obj_hist_pres -> hist_pres_presupuesto = $obj_pre -> pre_id;
            $obj_hist_pres -> hist_pres_estado_presupuesto = $estado;
            $obj_hist_pres -> hist_pres_asesor = $_SESSION['id_ase'];
            $obj_hist_pres -> save();

            $obj_eve = new eventos;
            $obj_eve -> eve_fecha       = $aux_eve -> eve_fecha;
            $obj_eve -> eve_tipo        = $aux_eve -> eve_tipo;
            $obj_eve -> eve_presupuesto = $obj_pre -> pre_id;
            $obj_eve -> eve_cliente     = $aux_eve -> eve_cliente;
            $obj_eve -> eve_asesor      = $aux_eve -> eve_asesor;
            $obj_eve -> save();
        }


        try {

        } catch(QueryException $e){
            //TODO controlar error
        }


        // TODO AÑADIR CAMBIO AL HISTORIAL DE CAMBIOS
        $obj_historico = new historial_cambios;
        $obj_historico -> hist_cliente     = $cliente[0]->cli_id;
        $obj_historico -> hist_asesor  = $_SESSION['id_ase'];
        if(isset($_POST["mod_id"])){
            $obj_historico -> hist_comentario  = "Modificación del Presupuesto #" . $obj_pre -> pre_id;
        }
        else{
            $obj_historico -> hist_comentario  = "Creación del Presupuesto #" . $obj_pre -> pre_id;
        }

        $obj_historico -> hist_presupuesto = $obj_pre -> pre_id;
        $obj_historico -> save();
        try {

        } catch(QueryException $e){
            //TODO controlar error
        }

        if(isset($_POST["true_cont"])){
            $contador = $_POST["true_cont"];
        } else {
            $contador = 0;
        }

        $i = 0;
        $empty_flag = true;

        $maximo_optico = Optico_fila::max('opt_fil_id');

        $filas_optico = array();

        while ($contador) {
            if(isset($_POST["sop_id" . $i])){
                //echo nl2br('Insertando datos de la linea ' . $i . '\n');
                $linea_presupuesto = new linea_presupuesto;
                $linea_presupuesto -> lin_pre_sop = $_POST["sop_id" . $i];
                $linea_presupuesto -> lin_pre_tar = $_POST["tar_id" . $i];
                $linea_presupuesto -> lin_pre_ncu = $_POST["ncunya" . $i];
                $linea_presupuesto -> lin_pre_dur = $_POST["dur_id" . $i];
                $linea_presupuesto -> lin_pre_dateini = $_POST["fechaini" . $i];
                $linea_presupuesto -> lin_pre_datefin = $_POST["fechafin" . $i];
                $linea_presupuesto -> lin_pre_desc = $_POST["desc" . $i];
                $linea_presupuesto -> lin_pre_prec = $_POST["neto" . $i];
                $linea_presupuesto -> lin_pre_pre = $obj_pre -> pre_id;
                $linea_presupuesto -> lin_pre_lin = $i;
                $linea_presupuesto -> lin_pre_valido = $_POST["opt_empty" . $i];
                if($_POST['opt_empty' . $i] == 1 && $empty_flag == true){
                    $empty_flag = false;
                }
                    $linea_presupuesto -> save();
                try {

                } catch(QueryException $e){
                    //TODO Controlar error
                }

                $id_soporte = $linea_presupuesto -> lin_pre_sop;
                $numero_filas = $_POST["opt_cont" . $id_soporte];
                $info_dias = 0;
                $datos_dias = 0;
                $year = date('Y');
                $mes = 0;

                //Se buscarán filas hasta que se hayan encontrado todas las que indica el numero de filas
                for ($j=1; $j <$numero_filas+1 ; ) {
                    if(isset($_POST["mes_name".$mes."_".$year."_".$id_soporte])){
                        $nombre = "mes_name".$mes."_".$year."_".$id_soporte;
                        if(!in_array($nombre,$filas)){
                            array_push($filas,$nombre);
                            //bucle para almacenar lineas de info del mes
                            $dia = 1;
                            $info_dias = array();
                            while ($dia <= 31) {
                                if(isset($_POST["dia".$dia."_".$mes."_".$year."_".$id_soporte])) {
                                    if($_POST["dia".$dia."_".$mes."_".$year."_".$id_soporte] == NULL) {
                                        array_push($info_dias, 0);
                                    } else {
                                        array_push($info_dias, $_POST["dia".$dia."_".$mes."_".$year."_".$id_soporte]);
                                    }
                                } else {
                                    array_push($info_dias, 0);
                                }
                                $dia++;
                            }

                            //se almacena en BD la linea del mes
                            $fila_opt_info = new optico_fila;
                            $fila_opt_info -> opt_fil_id = $maximo_optico + $j;
                            //echo nl2br("insertando fila: " . $maximo_optico + $j . "\n");
                            $fila_opt_info -> opt_fil_isdata = 0;
                            $fila_opt_info -> opt_fil_mes    = $mes+1;
                            $fila_opt_info -> opt_fil_anyo   = $year;
                            $fila_opt_info -> opt_fil_pre    = $obj_pre -> pre_id;
                            $fila_opt_info -> opt_fil_sop    = $id_soporte;
                            $fila_opt_info -> opt_fil_data1  = $info_dias[0];
                            $fila_opt_info -> opt_fil_data2  = $info_dias[1];
                            $fila_opt_info -> opt_fil_data3  = $info_dias[2];
                            $fila_opt_info -> opt_fil_data4  = $info_dias[3];
                            $fila_opt_info -> opt_fil_data5  = $info_dias[4];
                            $fila_opt_info -> opt_fil_data6  = $info_dias[5];
                            $fila_opt_info -> opt_fil_data7  = $info_dias[6];
                            $fila_opt_info -> opt_fil_data8  = $info_dias[7];
                            $fila_opt_info -> opt_fil_data9  = $info_dias[8];
                            $fila_opt_info -> opt_fil_data10 = $info_dias[9];
                            $fila_opt_info -> opt_fil_data11 = $info_dias[10];
                            $fila_opt_info -> opt_fil_data12 = $info_dias[11];
                            $fila_opt_info -> opt_fil_data13 = $info_dias[12];
                            $fila_opt_info -> opt_fil_data14 = $info_dias[13];
                            $fila_opt_info -> opt_fil_data15 = $info_dias[14];
                            $fila_opt_info -> opt_fil_data16 = $info_dias[15];
                            $fila_opt_info -> opt_fil_data17 = $info_dias[16];
                            $fila_opt_info -> opt_fil_data18 = $info_dias[17];
                            $fila_opt_info -> opt_fil_data19 = $info_dias[18];
                            $fila_opt_info -> opt_fil_data20 = $info_dias[19];
                            $fila_opt_info -> opt_fil_data21 = $info_dias[20];
                            $fila_opt_info -> opt_fil_data22 = $info_dias[21];
                            $fila_opt_info -> opt_fil_data23 = $info_dias[22];
                            $fila_opt_info -> opt_fil_data24 = $info_dias[23];
                            $fila_opt_info -> opt_fil_data25 = $info_dias[24];
                            $fila_opt_info -> opt_fil_data26 = $info_dias[25];
                            $fila_opt_info -> opt_fil_data27 = $info_dias[26];
                            $fila_opt_info -> opt_fil_data28 = $info_dias[27];
                            $fila_opt_info -> opt_fil_data29 = $info_dias[28];
                            $fila_opt_info -> opt_fil_data30 = $info_dias[29];
                            $fila_opt_info -> opt_fil_data31 = $info_dias[30];

                            $fila_opt_info -> opt_fil_id = Optico_fila::max('opt_fil_id')+1;
                            $fila_opt_info -> save();


                            try {

                            } catch(QueryException $e){
                                //TODO Controlar error
                                echo('Ha habido un error');
                            }
                            $filas_optico [$j] = $fila_opt_info -> opt_fil_id;
                            //guardar en BBDD
                            $j++;
                        } else {
                            $j++;
                        }
                    }

                    for ($k=0; $k < 50; $k++) {

                        if(isset($_POST["dur_opt_id".$mes."_".$year."_".$id_soporte."_".$k])){
                            if($k == $linea_presupuesto->lin_pre_lin){
                                $nombre = "dur_opt_id".$mes."_".$year."_".$id_soporte."_".$k;
                                if(!in_array($nombre,$filas)){
                                    array_push($filas,$nombre);
                                    $dia = 1;
                                    $datos_dias = array();
                                    while ($dia <= 31) {
                                        if(isset($_POST["val".$dia."_".$mes."_".$year."_".$id_soporte."_".$k])) {
                                            if($_POST["val".$dia."_".$mes."_".$year."_".$id_soporte."_".$k] == NULL) {
                                                array_push($datos_dias, 0);
                                            } else {
                                                array_push($datos_dias, (int)$_POST["val".$dia."_".$mes."_".$year."_".$id_soporte."_".$k]);

                                            }
                                        } else {
                                            array_push($datos_dias, -1);
                                        }

                                        $dia++;

                                    }
                                    $fila_opt_datos = new optico_fila;
                                    $fila_opt_datos -> opt_fil_id = $maximo_optico + $j;
                                    //echo nl2br("insertando fila: " . $maximo_optico + $j . "\n");
                                    $fila_opt_datos -> opt_fil_isdata = 1;
                                    $fila_opt_datos -> opt_fil_mes    = $mes+1;
                                    $fila_opt_datos -> opt_fil_anyo   = $year;
                                    $fila_opt_datos -> opt_fil_lin    = $linea_presupuesto -> lin_pre_id;


                                    $fila_opt_datos -> opt_fil_pre    = $obj_pre -> pre_id;
                                    $fila_opt_datos -> opt_fil_sop    = $id_soporte;
                                    $fila_opt_datos -> opt_fil_tar    = $_POST["tar_opt_id".$mes."_".$year."_".$k];
                                    $fila_opt_datos -> opt_fil_dur    = $_POST["dur_opt_id".$mes."_".$year."_".$id_soporte."_".$k];
                                    if($_POST["matricula".$mes."_".$year."_".$k] != NULL) {
                                        $fila_opt_datos -> opt_fil_mat = $_POST["matricula".$mes."_".$year."_".$k];
                                    }
                                    if($_POST["hora".$mes."_".$year."_".$k] != NULL) {
                                        $fila_opt_datos -> opt_fil_hora = $_POST["hora".$mes."_".$year."_".$k];
                                    }
                                    $fila_opt_datos -> opt_fil_data1  = $datos_dias[0];
                                    $fila_opt_datos -> opt_fil_data2  = $datos_dias[1];
                                    $fila_opt_datos -> opt_fil_data3  = $datos_dias[2];
                                    $fila_opt_datos -> opt_fil_data4  = $datos_dias[3];
                                    $fila_opt_datos -> opt_fil_data5  = $datos_dias[4];
                                    $fila_opt_datos -> opt_fil_data6  = $datos_dias[5];
                                    $fila_opt_datos -> opt_fil_data7  = $datos_dias[6];
                                    $fila_opt_datos -> opt_fil_data8  = $datos_dias[7];
                                    $fila_opt_datos -> opt_fil_data9  = $datos_dias[8];
                                    $fila_opt_datos -> opt_fil_data10 = $datos_dias[9];
                                    $fila_opt_datos -> opt_fil_data11 = $datos_dias[10];
                                    $fila_opt_datos -> opt_fil_data12 = $datos_dias[11];
                                    $fila_opt_datos -> opt_fil_data13 = $datos_dias[12];
                                    $fila_opt_datos -> opt_fil_data14 = $datos_dias[13];
                                    $fila_opt_datos -> opt_fil_data15 = $datos_dias[14];
                                    $fila_opt_datos -> opt_fil_data16 = $datos_dias[15];
                                    $fila_opt_datos -> opt_fil_data17 = $datos_dias[16];
                                    $fila_opt_datos -> opt_fil_data18 = $datos_dias[17];
                                    $fila_opt_datos -> opt_fil_data19 = $datos_dias[18];
                                    $fila_opt_datos -> opt_fil_data20 = $datos_dias[19];
                                    $fila_opt_datos -> opt_fil_data21 = $datos_dias[20];
                                    $fila_opt_datos -> opt_fil_data22 = $datos_dias[21];
                                    $fila_opt_datos -> opt_fil_data23 = $datos_dias[22];
                                    $fila_opt_datos -> opt_fil_data24 = $datos_dias[23];
                                    $fila_opt_datos -> opt_fil_data25 = $datos_dias[24];
                                    $fila_opt_datos -> opt_fil_data26 = $datos_dias[25];
                                    $fila_opt_datos -> opt_fil_data27 = $datos_dias[26];
                                    $fila_opt_datos -> opt_fil_data28 = $datos_dias[27];
                                    $fila_opt_datos -> opt_fil_data29 = $datos_dias[28];
                                    $fila_opt_datos -> opt_fil_data30 = $datos_dias[29];
                                    $fila_opt_datos -> opt_fil_data31 = $datos_dias[30];
                                    $fila_opt_datos -> opt_fil_datauds = $_POST["total".$mes."_".$year."_".$id_soporte."_".$k];

                                    $fila_opt_datos -> opt_fil_id = Optico_fila::max('opt_fil_id')+1;
                                    $fila_opt_datos -> save();

                                    try {


                                    } catch(QueryException $e){
                                        echo('Ha habido un error');
                                        //TODO Controlar error
                                    }

                                    $filas_optico [$j] = $fila_opt_datos -> opt_fil_id;

                                    $j++;
                                }
                            } else {
                                $j++;
                            }
                        }
                    }


                    if ($mes + 1 == 12) { $mes = 0; $year++; }
                    else { $mes++; }
                }

                $i++;
                $contador--;
            } else {
                $i++;
            }
        }

        ksort($filas_optico);

        $maxima_id = -1;

        foreach ($filas_optico as $key => $value) {
            if($value > $maxima_id)
                $maxima_id = $value;
        }

        foreach ($filas_optico as $key => $value) {
            $fila = Optico_fila::find($value);

            $fila -> opt_fil_id = $maxima_id + $key;

            $fila -> save();
        }

        if(!$empty_flag) {
            $aux = presupuestos::find($obj_pre -> pre_id);
            $aux -> pre_valido = false;
            $aux -> save();
        }

        if(isset($_POST['nueva_copia'])){
            $target = $_POST["nueva_copia"];
            $copia = presupuestos::find($target);
            $copia -> pre_estado = 'OBSOLETO';
            $copia -> save();
        }

        $cli = clientes::find($cliente[0]->cli_id);

        if($_POST['formPago'] != ""){
            $met_pago = metodos_pago::where('met_pago_desc', '=', $_POST['formPago'])
                ->get();
            $cli -> cli_met_pago = $met_pago[0]->met_pago_id;
        }

        $cli -> cli_iban     = $_POST['iban'];
        $cli -> cli_obs_pago = $_POST['observaciones_pago'];

        header( "Location: buzon_presupuesto", true, 303 );
        exit();

    }

    public function guardar_presupuesto2(Request $request){
        session_start();
        $contador_soporte = 1;
        $numero_filas;
        $nombre;
        $IDs;
        $estado;
        //Llenar este array con un valor representativo de todas las filas del optico, independientemente de tipo
        $filas = array();

        // TODO GUARDAR DATOS EN BD
        $fact_anu = $_POST["factAnual"];
        $antig    = $_POST["antig"];
        if(isset($_POST["prontoPago"])){
            $pronto_pago = true;
        } else {
            $pronto_pago = false;
        }

        if(isset($_POST["true_cont"])){
            $contador = $_POST["true_cont"];
        } else {
            $contador = 0;
        }

        $i = 0;
        $datemin = mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+100);
        $datemax = mktime(0, 0, 0, date("m"),   date("d"),   date("Y"));

        while ($contador) {
            if(isset($_POST["sop_id" . $i])) {
                if($_POST["fechaini" . $i] < $datemin) {
                    $datemin = $_POST["fechaini" . $i];
                }
                if($_POST["fechafin" . $i] > $datemax) {
                    $datemax = $_POST["fechafin" . $i];
                }
                $i++;
                $contador--;
            } else {
                $i++;
            }
        }

        $cliente = clientes::where('cli_anu', '=', $_POST['cliente_anunciante'])
            ->get();

        $metpago = metodos_pago::where('met_pago_desc','=',$_POST['formPago'])->get()[0];

        $cliente[0] -> cli_iban = $_POST['iban'];
        $cliente[0] -> cli_met_pago = $metpago -> met_pago_id;

        $cliente[0] -> save();

        $obj_pre = new presupuestos;
        $obj_pre -> pre_fact_anu   = $fact_anu;
        $obj_pre -> pre_antig      = $antig;
        $obj_pre -> pre_pront_pago = $pronto_pago;
        if(isset($_POST["mod_id"])){
            $obj_pre -> pre_estado     = "PRESENTADO";
            $estado = "PRESENTADO";
        }
        else {
            $obj_pre -> pre_estado     = "PENDIENTE";
            $estado = "PENDIENTE";
        }
        if(isset($_POST['accion_comercial_id'])){
            $obj_pre -> pre_acc_com = $_POST['accion_comercial_id'];
        }

        $obj_pre -> pre_tot_brut   = floatval(substr($_POST["totalbrut"], 0, -2));
        $obj_pre -> pre_tot_desc   = floatval(substr($_POST["totaldesc"], 0, -2));
        $obj_pre -> pre_tot_neto   = floatval(substr($_POST["totalneto"], 0, -2));
        $obj_pre -> pre_cliente    = $cliente[0]->cli_id;
        $obj_pre -> pre_dateini    = $datemin;
        $obj_pre -> pre_datefin    = $datemax;
        $obj_pre -> pre_soc        = $_POST['razon_social'];
        $obj_pre -> pre_emisora    = $_POST['emisora'];
        $obj_pre -> pre_creador    = $_SESSION['id_ase'];
        $obj_pre -> pre_valido     = true;
        $obj_pre -> pre_pago_valido = $_POST['pago_valido'];

        if (isset($_POST['id_accion'])) {
            $obj_pre -> pre_acc_com = $_POST['id_accion'];
        }

        //vaciar el campo presupuesto de las filas del historial_cambios

        if(isset($_POST["mod_id"])){

            $target = $_POST["mod_id"];

            $IDs = historial_cambios::select('id')
                ->where('hist_presupuesto','=',$target)
                ->get();

            foreach ($IDs as $id) {
                historial_cambios::where('id','=',$id->id)
                    ->update(['hist_presupuesto' => null]);
            }

            optico_fila::where('opt_fil_pre', '=', $target) -> delete();
            linea_presupuesto::where('lin_pre_pre', '=', $target) -> delete();
            $fecha_presentacion = presupuestos::find($target)->pre_dateprox;
            historico_presupuestos::where('hist_pres_presupuesto', '=', $target) -> delete();
            presupuestos::where('pre_id', '=', $target) -> delete();
            $obj_pre -> pre_id = $target;
            $obj_pre -> pre_dateprox = $fecha_presentacion;
        }


        $obj_pre -> save();

        if(isset($_POST["mod_id"])){
            foreach ($IDs as $id) {
                historial_cambios::where('id','=',$id->id)
                    ->update(['hist_presupuesto' => $obj_pre -> pre_id]);
            }

            // //Añadir registro a la tabla de historico de Presupuestos
            $obj_hist_pres = new historico_presupuestos;
            $obj_hist_pres -> hist_pres_cliente = $obj_pre -> pre_cliente;
            $obj_hist_pres -> hist_pres_estado_cliente = $cliente[0]->cli_est_cli;
            $obj_hist_pres -> hist_pres_presupuesto = $obj_pre -> pre_id;
            $obj_hist_pres -> hist_pres_estado_presupuesto = $estado;
            $obj_hist_pres -> hist_pres_asesor = $_SESSION['id_ase'];
            $obj_hist_pres -> save();
        }


        try {

        } catch(QueryException $e){
            //TODO controlar error
        }


        // TODO AÑADIR CAMBIO AL HISTORIAL DE CAMBIOS
        $obj_historico = new historial_cambios;
        $obj_historico -> hist_cliente     = $cliente[0]->cli_id;
        $obj_historico -> hist_asesor  = $_SESSION['id_ase'];
        if(isset($_POST["mod_id"])){
            $obj_historico -> hist_comentario  = "Modificación del Presupuesto #" . $obj_pre -> pre_id;
        }
        else{
            $obj_historico -> hist_comentario  = "Creación del Presupuesto #" . $obj_pre -> pre_id;
        }

        $obj_historico -> hist_presupuesto = $obj_pre -> pre_id;
        $obj_historico -> save();
        try {

        } catch(QueryException $e){
            //TODO controlar error
        }

        if(isset($_POST["true_cont"])){
            $contador = $_POST["true_cont"];
        } else {
            $contador = 0;
        }

        $i = 0;
        $empty_flag = true;
        while ($contador) {
            if(isset($_POST["sop_id" . $i])){
                $linea_presupuesto = new linea_presupuesto;
                $linea_presupuesto -> lin_pre_sop = $_POST["sop_id" . $i];
                $linea_presupuesto -> lin_pre_tar = $_POST["tar_id" . $i];
                $linea_presupuesto -> lin_pre_ncu = $_POST["ncunya" . $i];
                $linea_presupuesto -> lin_pre_dur = $_POST["dur_id" . $i];
                $linea_presupuesto -> lin_pre_dateini = $_POST["fechaini" . $i];
                $linea_presupuesto -> lin_pre_datefin = $_POST["fechafin" . $i];
                $linea_presupuesto -> lin_pre_desc = $_POST["desc" . $i];
                $linea_presupuesto -> lin_pre_prec = $_POST["neto" . $i];
                $linea_presupuesto -> lin_pre_pre = $obj_pre -> pre_id;
                $linea_presupuesto -> lin_pre_lin = $i;
                $linea_presupuesto -> lin_pre_valido = $_POST["opt_empty" . $i];
                if($_POST['opt_empty' . $i] == 1 && $empty_flag == true){
                    $empty_flag = false;
                }
                try {
                    $linea_presupuesto -> save();
                    if($i == 1) {
                        $checkpoint = $linea_presupuesto -> lin_pre_id;
                    }
                } catch(QueryException $e){
                    echo('Ha habido un error');
                }

                $i++;
                $contador--;
            } else {
                $i++;
            }
        }

        //Bucle mayor itera por contador de lineas (true cont)
        $cont_fil_encontradas = 0;
        for ($i=1; $i <6 ; $i++) {
            if($_POST["opt_cont".$i] != 0){
                //El soporte que se encuentra en la poscición $i tiene datos, se extrae la cantidad de filas a buscar
                $id_soporte = $i;
                $numero_filas = $_POST["opt_cont" . $id_soporte];
                $info_dias = 0;
                $datos_dias = 0;
                $year = date('Y');
                $mes = 0;

                //Se buscarán filas hasta que se hayan encontrado todas las que indica el numero de filas
                for ($j=1; $j <$numero_filas+1 ; ) {
                    for ($k=0; $k < 20; $k++) {
                        if(isset($_POST["mes_name".$mes."_".$year."_".$id_soporte])){
                            $nombre = "mes_name".$mes."_".$year."_".$id_soporte;
                            if(!in_array($nombre,$filas)){
                                array_push($filas,$nombre);
                                //bucle para almacenar lineas de info del mes
                                $dia = 1;
                                $info_dias = array();
                                while ($dia <= 31) {
                                    if(isset($_POST["dia".$dia."_".$mes."_".$year."_".$id_soporte])) {
                                        if($_POST["dia".$dia."_".$mes."_".$year."_".$id_soporte] == NULL) {
                                            array_push($info_dias, 0);
                                        } else {
                                            array_push($info_dias, $_POST["dia".$dia."_".$mes."_".$year."_".$id_soporte]);
                                        }
                                    } else {
                                        array_push($info_dias, 0);
                                    }
                                    $dia++;
                                }

                                //se almacena en BD la linea del mes
                                $fila_opt_info = new optico_fila;
                                $fila_opt_info -> opt_fil_isdata = 0;
                                $fila_opt_info -> opt_fil_mes    = $mes+1;
                                $fila_opt_info -> opt_fil_anyo   = $year;
                                $fila_opt_info -> opt_fil_pre    = $obj_pre -> pre_id;
                                $fila_opt_info -> opt_fil_sop    = $id_soporte;
                                $fila_opt_info -> opt_fil_data1  = $info_dias[0];
                                $fila_opt_info -> opt_fil_data2  = $info_dias[1];
                                $fila_opt_info -> opt_fil_data3  = $info_dias[2];
                                $fila_opt_info -> opt_fil_data4  = $info_dias[3];
                                $fila_opt_info -> opt_fil_data5  = $info_dias[4];
                                $fila_opt_info -> opt_fil_data6  = $info_dias[5];
                                $fila_opt_info -> opt_fil_data7  = $info_dias[6];
                                $fila_opt_info -> opt_fil_data8  = $info_dias[7];
                                $fila_opt_info -> opt_fil_data9  = $info_dias[8];
                                $fila_opt_info -> opt_fil_data10 = $info_dias[9];
                                $fila_opt_info -> opt_fil_data11 = $info_dias[10];
                                $fila_opt_info -> opt_fil_data12 = $info_dias[11];
                                $fila_opt_info -> opt_fil_data13 = $info_dias[12];
                                $fila_opt_info -> opt_fil_data14 = $info_dias[13];
                                $fila_opt_info -> opt_fil_data15 = $info_dias[14];
                                $fila_opt_info -> opt_fil_data16 = $info_dias[15];
                                $fila_opt_info -> opt_fil_data17 = $info_dias[16];
                                $fila_opt_info -> opt_fil_data18 = $info_dias[17];
                                $fila_opt_info -> opt_fil_data19 = $info_dias[18];
                                $fila_opt_info -> opt_fil_data20 = $info_dias[19];
                                $fila_opt_info -> opt_fil_data21 = $info_dias[20];
                                $fila_opt_info -> opt_fil_data22 = $info_dias[21];
                                $fila_opt_info -> opt_fil_data23 = $info_dias[22];
                                $fila_opt_info -> opt_fil_data24 = $info_dias[23];
                                $fila_opt_info -> opt_fil_data25 = $info_dias[24];
                                $fila_opt_info -> opt_fil_data26 = $info_dias[25];
                                $fila_opt_info -> opt_fil_data27 = $info_dias[26];
                                $fila_opt_info -> opt_fil_data28 = $info_dias[27];
                                $fila_opt_info -> opt_fil_data29 = $info_dias[28];
                                $fila_opt_info -> opt_fil_data30 = $info_dias[29];
                                $fila_opt_info -> opt_fil_data31 = $info_dias[30];
                                // for($x = 0; $x < 31; $x++) {
                                //     $fila_opt_info -> opt_fil_data . ($x + 1) = $info_dias[$x];
                                // }

                                try {
                                    $fila_opt_info -> save();
                                } catch(QueryException $e){
                                    //TODO Controlar error
                                    echo('Ha habido un error');
                                }
                                //guardar en BBDD
                                $j++;
                            }
                        }
                    }

                    if(isset($_POST["mod_id"])){
                        $id_minima = linea_presupuesto::where('lin_pre_pre', '=', $_POST["mod_id"])
                                    ->min('lin_pre_id');
                    }
                    else{
                        $id_minima = linea_presupuesto::where('lin_pre_pre', '=', $obj_pre->pre_id )
                                    ->min('lin_pre_id');
                    }
                    //TODO SE INICIALIZA EN CADA ITERACION, HAY QUE PONERLO EN EL SITIO EN EL QUE NO SE INICIALICE




                    for ($k=0; $k < 50; $k++) {
                        if(isset($_POST["dur_opt_id".$mes."_".$year."_".$id_soporte."_".$k])){
                            //TODO TIENE QUE COLOCARSE DONDE SE INCREMENTE CORRECTAMENTE


                            $nombre = "dur_opt_id".$mes."_".$year."_".$id_soporte."_".$k;
                            if(!in_array($nombre,$filas)){
                                array_push($filas,$nombre);
                                $dia = 1;
                                $datos_dias = array();
                                while ($dia <= 31) {
                                    if(isset($_POST["val".$dia."_".$mes."_".$year."_".$id_soporte."_".$k])) {
                                        if($_POST["val".$dia."_".$mes."_".$year."_".$id_soporte."_".$k] == NULL) {
                                            array_push($datos_dias, 0);
                                        } else {
                                            array_push($datos_dias, (int)$_POST["val".$dia."_".$mes."_".$year."_".$id_soporte."_".$k]);

                                        }
                                    } else {
                                        array_push($datos_dias, -1);
                                    }
                                    $dia++;

                                }

                                //TODO se almacena en BD la linea del mes
                                $fila_opt_datos = new optico_fila;
                                $fila_opt_datos -> opt_fil_isdata = 1;
                                $fila_opt_datos -> opt_fil_mes    = $mes+1;
                                $fila_opt_datos -> opt_fil_anyo   = $year;
                                if(isset($_POST["mod_id"])){
                                    $cont_fil_encontradas++;
                                    $fila_opt_datos -> opt_fil_lin    = $cont_fil_encontradas + $id_minima - 1;
                                }
                                else {
                                    $fila_opt_datos -> opt_fil_lin    = $_POST["id_lin".$mes."_".$year."_".$id_soporte."_".$k] + $id_minima - 1;
                                }
                                $fila_opt_datos -> opt_fil_pre    = $obj_pre -> pre_id;
                                $fila_opt_datos -> opt_fil_sop    = $id_soporte;
                                $fila_opt_datos -> opt_fil_tar    = $_POST["tar_opt_id".$mes."_".$year."_".$k];
                                $fila_opt_datos -> opt_fil_dur    = $_POST["dur_opt_id".$mes."_".$year."_".$id_soporte."_".$k];
                                if($_POST["matricula".$mes."_".$year."_".$k] != NULL) {
                                    $fila_opt_datos -> opt_fil_mat = $_POST["matricula".$mes."_".$year."_".$k];
                                }
                                if($_POST["hora".$mes."_".$year."_".$k] != NULL) {
                                    $fila_opt_datos -> opt_fil_hora = $_POST["hora".$mes."_".$year."_".$k];
                                }
                                $fila_opt_datos -> opt_fil_data1  = $datos_dias[0];
                                $fila_opt_datos -> opt_fil_data2  = $datos_dias[1];
                                $fila_opt_datos -> opt_fil_data3  = $datos_dias[2];
                                $fila_opt_datos -> opt_fil_data4  = $datos_dias[3];
                                $fila_opt_datos -> opt_fil_data5  = $datos_dias[4];
                                $fila_opt_datos -> opt_fil_data6  = $datos_dias[5];
                                $fila_opt_datos -> opt_fil_data7  = $datos_dias[6];
                                $fila_opt_datos -> opt_fil_data8  = $datos_dias[7];
                                $fila_opt_datos -> opt_fil_data9  = $datos_dias[8];
                                $fila_opt_datos -> opt_fil_data10 = $datos_dias[9];
                                $fila_opt_datos -> opt_fil_data11 = $datos_dias[10];
                                $fila_opt_datos -> opt_fil_data12 = $datos_dias[11];
                                $fila_opt_datos -> opt_fil_data13 = $datos_dias[12];
                                $fila_opt_datos -> opt_fil_data14 = $datos_dias[13];
                                $fila_opt_datos -> opt_fil_data15 = $datos_dias[14];
                                $fila_opt_datos -> opt_fil_data16 = $datos_dias[15];
                                $fila_opt_datos -> opt_fil_data17 = $datos_dias[16];
                                $fila_opt_datos -> opt_fil_data18 = $datos_dias[17];
                                $fila_opt_datos -> opt_fil_data19 = $datos_dias[18];
                                $fila_opt_datos -> opt_fil_data20 = $datos_dias[19];
                                $fila_opt_datos -> opt_fil_data21 = $datos_dias[20];
                                $fila_opt_datos -> opt_fil_data22 = $datos_dias[21];
                                $fila_opt_datos -> opt_fil_data23 = $datos_dias[22];
                                $fila_opt_datos -> opt_fil_data24 = $datos_dias[23];
                                $fila_opt_datos -> opt_fil_data25 = $datos_dias[24];
                                $fila_opt_datos -> opt_fil_data26 = $datos_dias[25];
                                $fila_opt_datos -> opt_fil_data27 = $datos_dias[26];
                                $fila_opt_datos -> opt_fil_data28 = $datos_dias[27];
                                $fila_opt_datos -> opt_fil_data29 = $datos_dias[28];
                                $fila_opt_datos -> opt_fil_data30 = $datos_dias[29];
                                $fila_opt_datos -> opt_fil_data31 = $datos_dias[30];
                                $fila_opt_datos -> opt_fil_datauds = $_POST["total".$mes."_".$year."_".$id_soporte."_".$k];
                                // for($x = 0; $x < 31; $x++) {
                                //     $fila_opt_info -> opt_fil_data . ($x + 1) = $info_dias[$x];
                                // }
                                $fila_opt_datos -> save();
                                try {

                                    //$fila_opt_datos -> save();
                                } catch(QueryException $e){
                                    echo('Ha habido un error');
                                    //TODO Controlar error
                                }
                                //guardar en BBDD
                                $j++;
                            }
                        }
                    }

                    if ($mes + 1 == 12) { $mes = 0; $year++; }
                    else { $mes++; }

                }
                $contador_soporte++;

            }
        }
        if(!$empty_flag) {
            $aux = presupuestos::find($obj_pre -> pre_id);
            $aux -> pre_valido = false;
            $aux -> save();
        }

        if(isset($_POST['nueva_copia'])){
            $target = $_POST["nueva_copia"];
            $copia = presupuestos::find($target);
            $copia -> pre_estado = 'OBSOLETO';
            $copia -> save();
        }

        $cli = clientes::find($cliente[0]->cli_id);

        if($_POST['formPago'] != ""){
            $met_pago = metodos_pago::where('met_pago_desc', '=', $_POST['formPago'])
                ->get();
            $cli -> cli_met_pago = $met_pago[0]->met_pago_id;
        }

        $cli -> cli_iban     = $_POST['iban'];
        $cli -> cli_obs_pago = $_POST['observaciones_pago'];

        header( "Location: buzon_presupuesto", true, 303 );
        exit();

    }

    public function showBuzon(Request $request){

        if (!isset($_SESSION)) {
            session_start();
        }

        if(isset($_GET["mes"]))
          $mes_elegido = $_GET["mes"];
        else
          $mes_elegido = "Enero";

        if(isset($_GET["id"]))
          $soporte_elegido = $_GET["id"];
        else{
          $soporte_elegido = NULL;
        }

        // // TODO AQUI FALTA EL IF(ADMIN)
        // if ($_SESSION['status'] == 'admin') {
        //     return $this->showImporte_admin($mes_elegido, $soporte_elegido);
        // }

        $data = array();



        $anyos = DB::table('anyo')
        ->select('anyo_nombre')
        ->orderby('anyo_nombre')
        ->paginate(4);



        $pendientes = presupuestos::with('clientes')
                  ->with('asesores')
                  ->where('pre_estado','=','PENDIENTE')
                  ->orderBy('pre_id')
                  ->get();

        foreach ($pendientes as $key => $value) {
            $cliente_agenda = null;
            $cliente_agenda = eventos::where('eve_cliente',$value->pre_cliente)->get();
            if(!isset($cliente_agenda[0])){
                $pendientes[$key]['existe_evento'] = 0;
            }
            else{
                $pendientes[$key]['existe_evento'] = 1;
            }

        }

        $presentados = presupuestos::with('asesores')
                  ->where('pre_estado','=','PRESENTADO')
                  ->orderBy('pre_id')
                  ->get();

        if($_SESSION['status'] != 'admin'){
            $pendientes     = $pendientes->where('pre_creador', '=', $_SESSION['id_ase']);
            $presentados    = $presentados->where('pre_creador', '=', $_SESSION['id_ase']);
        }

        $linea_presupuesto = linea_presupuesto::with('soportes_presupuestos')
                  ->with('tarifas_presupuestos')
                  ->with('duracion_presupuestos')
                  ->orderBy('lin_pre_id')
                  ->get();

        $acc_com = presupuestos::where('pre_estado','=','PREDEFINIDO')
                  ->orderBy('pre_id')
                  ->get();

        foreach ($pendientes as $pend) {
            $date = date_create($pend->pre_dateini);
            $pend->pre_dateini = date_format($date,"d/m/Y");
        }

        foreach ($presentados as $prest) {
            $date1=date_create($prest->pre_dateini);
            $date2=date_create($prest->pre_dateprox);

            $prest->pre_dateini = date_format($date1, "d/m/Y");
            $prest->pre_dateprox = date_format($date2, "d/m/Y");
        }

        foreach ($acc_com as $pre) {
            $date1=date_create($pre->pre_dateini);
            $date2=date_create($pre->pre_dateprox);

            $pre->pre_dateini = date_format($date1, "d/m/Y");
            $pre->pre_dateprox = date_format($date2, "d/m/Y");
        }

        return view('buzon_presupuesto', ['anyos' => $anyos, 'soporte_elegido' => $soporte_elegido,'mes_elegido' => $mes_elegido, 'pendientes' => $pendientes, 'presupuestos' => $presentados, 'acc_com' => $acc_com, 'linea_presupuesto' => $linea_presupuesto]);
    }

    public function aceptar_presupuesto(Request $request){

        if(!isset($_SESSION)){
            session_start();
        }

        $contador = linea_presupuesto::select('lin_pre_id')
                      ->where('lin_pre_pre', $_POST['pre_id'])
                      ->count();

        $j = 0;
        for ($i=0; $i < $contador; $j++) {
            if(isset($_POST['matricula'.$j])){
                optico_fila::where('opt_fil_pre', $_POST['pre_id'])
                      ->where('opt_fil_lin', $j)
                      ->update(['opt_fil_mat' => $_POST['matricula'.$j]]);

                $i++;
            }
        }

        $presupuesto = presupuestos::find($_POST['pre_id']);
        $presupuesto -> pre_estado = 'ACEPTADO';
        $presupuesto -> save();

        // $cliente = clientes::find($presupuesto -> pre_cliente);
        // $cliente -> cli_dateprox = $_POST['fecha_rechazo'];
        // $cliente -> cli_tipo_reunion = $_POST['visita_rechazo'];
        // $cliente -> save();

        $evento = eventos::where('eve_cliente', $presupuesto -> pre_cliente)
            ->get()[0];

        $evento -> eve_fecha = $_POST['fecha_rechazo'];
        $evento -> eve_tipo = $_POST['visita_rechazo'];
        $evento -> eve_presupuesto = null;
        $evento -> eve_cliente = $presupuesto -> pre_cliente;
        $evento -> eve_asesor = $_SESSION['id_ase'];
        $evento -> save();

        $presupuesto = presupuestos::with('clientes')
            ->find($_POST['pre_id']);

        // TODO AÑADIR CAMBIO AL HISTORIAL DE CAMBIOS
        $obj_historico = new historial_cambios;
        $obj_historico -> hist_cliente     = $presupuesto->clientes->cli_id;
        $obj_historico -> hist_asesor  = $_SESSION['id_ase'];
        $obj_historico -> hist_comentario  = "Aceptado el Presupuesto #" . $_POST['pre_id'];
        $obj_historico -> hist_presupuesto = $_POST['pre_id'];
        $obj_historico -> save();
        try {

        } catch(QueryException $e){
            //TODO controlar error
        }

        // $obj_hist_pres = new historico_presupuestos;
        // $obj_hist_pres -> hist_pres_cliente = $cliente -> cli_id;
        // $obj_hist_pres -> hist_pres_cambio = 0;
        // $obj_hist_pres -> hist_pres_estado_cliente = $estado;
        // $obj_hist_pres -> hist_pres_presupuesto = $_POST['pre_id'];
        // $obj_hist_pres -> save();

        $obj_hist_pres = new historico_presupuestos;
        $obj_hist_pres -> hist_pres_cliente = $presupuesto->clientes->cli_id;
        $obj_hist_pres -> hist_pres_estado_cliente = $presupuesto->clientes->cli_est_cli;
        $obj_hist_pres -> hist_pres_presupuesto = $presupuesto -> pre_id;
        $obj_hist_pres -> hist_pres_estado_presupuesto = 'ACEPTADO';
        $obj_hist_pres -> hist_pres_asesor = $_SESSION['id_ase'];
        $obj_hist_pres -> save();

        $id_cli = presupuestos::with('clientes')
            ->find($_POST['pre_id'])->clientes->cli_id;

        $cliente = clientes::find($id_cli);

        $cliente -> cli_est_cli = "ACEPTADO";

        $cliente-> save();

        header( "Location: historico_presupuesto", true, 303 );
        exit();
    }

    public function rechazar_presupuesto(Request $request){

        if(!isset($_SESSION)){
            session_start();
        }

        $presupuesto = presupuestos::with('clientes')
            ->find($_POST['pre_id']);

        $presupuesto -> pre_estado = 'RECHAZADO';
        $presupuesto -> pre_motivo_rechazo = $_POST['motivo_rechazo'];
        $presupuesto -> save();

        $evento = eventos::where('eve_cliente', $presupuesto -> pre_cliente)
            ->get()[0];

        $evento -> eve_fecha = $_POST['fecha_rechazo'];
        $evento -> eve_tipo = $_POST['visita_rechazo'];
        $evento -> eve_presupuesto = null;
        $evento -> eve_cliente = $presupuesto -> pre_cliente;
        $evento -> eve_asesor = $_SESSION['id_ase'];
        $evento -> save();




        // TODO AÑADIR CAMBIO AL HISTORIAL DE CAMBIOS
        $obj_historico = new historial_cambios;
        $obj_historico -> hist_cliente     = $presupuesto->clientes->cli_id;
        $obj_historico -> hist_asesor  = $_SESSION['id_ase'];
        $obj_historico -> hist_comentario  = "Rechazado el Presupuesto #" . $_POST['pre_id'] . " - MOTIVO: " . $_POST['motivo_rechazo'];
        $obj_historico -> hist_presupuesto = $_POST['pre_id'];
        $obj_historico -> save();
        try {

        } catch(QueryException $e){
            //TODO controlar error
        }

        $obj_hist_pres = new historico_presupuestos;
        $obj_hist_pres -> hist_pres_cliente = $presupuesto->clientes->cli_id;
        $obj_hist_pres -> hist_pres_estado_cliente = $presupuesto->clientes->cli_est_cli;
        $obj_hist_pres -> hist_pres_presupuesto = $presupuesto -> pre_id;
        $obj_hist_pres -> hist_pres_estado_presupuesto = 'RECHAZADO';
        $obj_hist_pres -> hist_pres_asesor = $_SESSION['id_ase'];
        $obj_hist_pres -> save();

        header( "Location: historico_presupuesto", true, 303 );
        exit();
    }

    public function obtenerPresupuestos_ventas(){
        if(!isset($_SESSION)){
            session_start();
        }

        $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        $query = presupuestos::where('pre_estado', '=', 'ACEPTADO')
            ->with('clientes')
            ->get();

        if($_SESSION['status'] != 'admin'){
            $query = $query->where('pre_creador', '=', $_SESSION['id_ase']);
        }

        $array = array();
        for($i = 0; $i < count($query); $i++){
            if($query[$i]->updated_at->format('Y') == date('Y')){
                if($query[$i]->updated_at->format('m') == date('m')){
                    array_push($array, $query[$i]);
                }
            }
        }

        $anyo = 9999;
        for($i = 0; $i < count($query); $i++){
            if($query[$i]->updated_at->format('Y') < $anyo){
                $anyo = $query[$i]->updated_at->format('Y');
            }
        }

        return view('ventas_presupuesto', ['aceptados' => $query, 'anyo' => $anyo, 'meses' => $meses]);
    }

    public function obtenerPresupuestos_historico(){
        if(!isset($_SESSION)){
            session_start();
        }

        $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        $query = presupuestos::with('clientes')
            ->where('pre_estado', '=', 'ACEPTADO')
            ->orwhere('pre_estado', '=', 'RECHAZADO')
            ->orderBy('updated_at', 'DESC')
            ->get();

        if($_SESSION['status'] != 'admin'){
            $query = $query->where('pre_creador', '=', $_SESSION['id_ase']);
        }


        $array = array();
        foreach($query as $row){
            if($row->updated_at->format('Y') == date('Y')){
                if($row->updated_at->format('m') == date('m')){
                    array_push($array, $row);
                }
            }
        }


        $anyo = 9999;
        foreach ($query as $row) {
            if($row->updated_at->format('Y') < $anyo){
                $anyo = $row->updated_at->format('Y');
            }
        }

        return view('historico_presupuesto', ['presupuestos' => $query, 'anyo' => $anyo, 'meses' => $meses]);
    }

    public function consultarPresupuesto() {
        if(!isset($_SESSION)){
            session_start();
        }

        $sop_pre = Soportes_presupuesto::select ('sop_pre_nombre', 'sop_pre_id')
            -> orderBy ('sop_pre_id')
            -> get();

        $tar_pre = Tarifas_presupuesto::select ('tar_pre_nombre', 'tar_pre_id', 'tar_pre_soporte')
            -> orderBy ('tar_pre_id')
            -> get();

        $dur_pre = Duracion_presupuesto::select ('dur_pre_nombre', 'dur_pre_id', 'dur_pre_value')
            -> orderBy ('dur_pre_id')
            -> get();

        $pre_pre = Precios_presupuesto::select ('pre_pre_tarifa', 'pre_pre_id', 'pre_pre_value', 'pre_pre_duracion')
            -> orderBy ('pre_pre_id')
            -> get();

        $des_pre = Descuentos_presupuesto::select ('des_pre_id', 'des_pre_soporte', 'des_pre_value', 'des_pre_duracion')
            -> orderBy ('des_pre_id')
            -> get();

        $lin_pre = Linea_presupuesto::select('lin_pre_id')
            ->orderByDesc('lin_pre_id')
            ->limit(1)
            ->get();

        $sociedades = sociedades::get();

        if($_SESSION['status'] == 'admin'){
            $clientes = clientes::where('cli_est_cli', '=', 'ACEPTADO')
                ->orwhere('cli_est_cli', 'like', '%POTENCIAL%')
                ->get();
        } else {
            $clientes = clientes::where('cli_age', '=', $_SESSION['id_ase'])
                ->where('cli_est_cli', '=', 'ACEPTADO')
                ->orwhere('cli_est_cli', 'like', '%POTENCIAL%')
                ->get();
        }

        $met_pago = metodos_pago::get();


        if(!isset($lin_pre[0]->lin_pre_id)){
        return view('form_presupuesto',[ 'sop_pre' => $sop_pre,
                                         'tar_pre' => $tar_pre,
                                         'dur_pre' => $dur_pre,
                                         'pre_pre' => $pre_pre,
                                         'des_pre' => $des_pre,
                                         'lin_pre' => 0,
                                         'sociedades' => $sociedades,
                                         'clientes' => $clientes,
                                         'metodos_pago' => $met_pago
                                       ]);
        }
        else{
        return view('form_presupuesto',[ 'sop_pre' => $sop_pre,
                                         'tar_pre' => $tar_pre,
                                         'dur_pre' => $dur_pre,
                                         'pre_pre' => $pre_pre,
                                         'des_pre' => $des_pre,
                                         'lin_pre' => $lin_pre[0]->lin_pre_id,
                                         'sociedades' => $sociedades,
                                         'clientes' => $clientes,
                                         'metodos_pago' => $met_pago
                                       ]);
        }


    }

    public function consultarPresupuestoAdmin() {
        $sop_pre = Soportes_Presupuesto::select ('sop_pre_nombre', 'sop_pre_id')
           -> orderBy ('sop_pre_id')
           -> get();

        $tar_pre = Tarifas_Presupuesto::select ('tar_pre_nombre', 'tar_pre_id', 'tar_pre_soporte')
           -> orderBy ('tar_pre_id')
           -> get();

        $dur_pre = Duracion_presupuesto::select ('dur_pre_nombre', 'dur_pre_id', 'dur_pre_value')
           -> orderBy ('dur_pre_id')
           -> get();

        $pre_pre = Precios_presupuesto::select ('pre_pre_tarifa', 'pre_pre_id', 'pre_pre_value', 'pre_pre_duracion')
           -> orderBy ('pre_pre_id')
           -> get();

        $sop_dur = DB::table('duracion_presupuestos')
           -> select ('dur_pre_nombre', 'dur_pre_id', 'sop_pre_nombre', 'sop_pre_id')
           -> join ('precios_presupuestos', 'pre_pre_duracion', '=', 'dur_pre_id')
           -> join ('tarifas_presupuestos', 'tar_pre_id', '=', 'pre_pre_tarifa')
           -> join ('soportes_presupuestos', 'sop_pre_id', '=', 'tar_pre_soporte')
           -> distinct()
           -> orderBy ('sop_pre_id')
           -> orderBy ('dur_pre_id')
           -> get();



        $des_pre = Descuentos_presupuesto::select ('des_pre_id', 'des_pre_soporte', 'des_pre_value', 'des_pre_duracion')
           -> orderBy ('des_pre_id')
           -> get();

           // dd($pre_pre);

        return view('admin_tarifas',[ 'sop_pre' => $sop_pre,
                                         'tar_pre' => $tar_pre,
                                         'dur_pre' => $dur_pre,
                                         'pre_pre' => $pre_pre,
                                         'sop_dur' => $sop_dur,
                                         'des_pre' => $des_pre
                                       ]);
    }

    public function consultarPresupuestoAccionCom(){
        $sop_pre = soportes_presupuesto::select ('sop_pre_nombre', 'sop_pre_id')
           -> orderBy ('sop_pre_id')
           -> get();

        $tar_pre = tarifas_presupuesto::select ('tar_pre_nombre', 'tar_pre_id', 'tar_pre_soporte')
           -> orderBy ('tar_pre_id')
           -> get();

        $dur_pre = duracion_presupuesto::select ('dur_pre_nombre', 'dur_pre_id', 'dur_pre_value')
           -> orderBy ('dur_pre_id')
           -> get();

        $pre_pre = precios_presupuesto::select ('pre_pre_tarifa', 'pre_pre_id', 'pre_pre_value', 'pre_pre_duracion')
           -> orderBy ('pre_pre_id')
           -> get();

        $des_pre = descuentos_presupuesto::select ('des_pre_id', 'des_pre_soporte', 'des_pre_value', 'des_pre_duracion')
           -> orderBy ('des_pre_id')
           -> get();

        $lin_pre = linea_presupuesto::select('lin_pre_id')
           ->orderByDesc('lin_pre_id')
           ->limit(1)
           ->get();

        if(!isset($lin_pre[0]->lin_pre_id)){
            return view('crear_accion_comercial',[ 'sop_pre' => $sop_pre,
                                                   'tar_pre' => $tar_pre,
                                                   'dur_pre' => $dur_pre,
                                                   'pre_pre' => $pre_pre,
                                                   'des_pre' => $des_pre,
                                                   'lin_pre' => 0
                                           ]);
        }
        else{
            return view('crear_accion_comercial',[ 'sop_pre' => $sop_pre,
                                                   'tar_pre' => $tar_pre,
                                                   'dur_pre' => $dur_pre,
                                                   'pre_pre' => $pre_pre,
                                                   'des_pre' => $des_pre,
                                                   'lin_pre' => $lin_pre[0]->lin_pre_id
                                           ]);
        }
    }

    public function editarTarifas(Request $request){
        $sop_id = $_POST["sop_id"];

        $tarifas = Tarifas_Presupuesto::where('tar_pre_soporte', '=', $sop_id)
            ->get();

        $descuentos = Descuentos_presupuesto::get();

        $duraciones = Duracion_Presupuesto::get();

        foreach ($tarifas as $tarifa) {
            foreach ($duraciones as $duracion) {
                if(isset($_POST["prec".$tarifa->tar_pre_id."_".$duracion->dur_pre_id."_".$sop_id])){
                    Precios_Presupuesto::where('pre_pre_tarifa', '=', $tarifa->tar_pre_id)
                        ->where     ('pre_pre_duracion', '=', $duracion->dur_pre_id)
                        ->update    (['pre_pre_value' => $_POST["prec".$tarifa->tar_pre_id."_".$duracion->dur_pre_id."_".$sop_id]]);
                }
            }
        }

        foreach ($duraciones as $duracion) {
            if(isset($_POST["desc".$sop_id."_".$duracion->dur_pre_id])){
                Descuentos_presupuesto::where('des_pre_soporte', '=', $sop_id)
                    ->where('des_pre_duracion', '=', $duracion->dur_pre_id)
                    ->update(['des_pre_value' => $_POST["desc".$sop_id."_".$duracion->dur_pre_id]]);
            }
        }

        return $this->consultarPresupuestoAdmin();

    }

    public function consultarPresupuestoID($pre_id) {

        session_start();

        $sop_pre = soportes_presupuesto::select ('sop_pre_nombre', 'sop_pre_id')
           -> orderBy ('sop_pre_id')
           -> get();

        $tar_pre = tarifas_presupuesto::select ('tar_pre_nombre', 'tar_pre_id', 'tar_pre_soporte')
           -> orderBy ('tar_pre_id')
           -> get();

        $dur_pre = duracion_presupuesto::select ('dur_pre_nombre', 'dur_pre_id', 'dur_pre_value')
           -> orderBy ('dur_pre_id')
           -> get();

        $pre_pre = precios_presupuesto::select ('pre_pre_tarifa', 'pre_pre_id', 'pre_pre_value', 'pre_pre_duracion')
           -> orderBy ('pre_pre_id')
           -> get();

        $des_pre = descuentos_presupuesto::select ('des_pre_id', 'des_pre_soporte', 'des_pre_value', 'des_pre_duracion')
           -> orderBy ('des_pre_id')
           -> get();

        $lin_pre = linea_presupuesto::select('lin_pre_id')
           ->orderByDesc('lin_pre_id')
           ->limit(1)
           ->get();

       $mod_pre = presupuestos::where('pre_id', '=', $pre_id)
           ->get();

       $accion_vigente = NULL;

       if($mod_pre[0]->pre_acc_com != NULL){
           $accion_vigente = presupuestos::find($mod_pre[0]->pre_acc_com);
       }

       $mod_lin_pre = linea_presupuesto::where('lin_pre_pre', '=', $pre_id)
           ->with('soportes_presupuestos')
           ->with('tarifas_presupuestos')
           ->with('duracion_presupuestos')
           ->get();

       $mod_opt_fil_pre = optico_fila::where('opt_fil_pre', '=', $pre_id)
           ->with('mes')
           ->with('linea_presupuestos')
           ->with('tarifas_presupuestos')
           ->with('duracion_presupuestos')
           ->get();


       $contador = linea_presupuesto::where('lin_pre_pre', '=', $pre_id)
            ->count();

      $contadores_opt = array();
      for ($i=1; $i <6 ; $i++) {

          $sop_pre[$i-1]->cantidad = optico_fila::where('opt_fil_pre', '=', $pre_id)
               ->where('opt_fil_sop', '=', $i)
               ->count();
      }

      foreach ($mod_opt_fil_pre as $clave => $mod_optico) {
          if(!is_null($mod_optico->opt_fil_lin)){
              $mes_ini = (int) date("n", strtotime($mod_optico->linea_presupuestos->lin_pre_dateini));
              $any_ini = (int) date("Y", strtotime($mod_optico->linea_presupuestos->lin_pre_dateini));
              $d_month = (int) cal_days_in_month(CAL_GREGORIAN, $mes_ini, $any_ini);
              $mod_opt_fil_pre[$clave] -> mes_ini = $mes_ini;
              $mod_opt_fil_pre[$clave] -> any_ini = $any_ini;
              $mod_opt_fil_pre[$clave] -> d_month = $d_month;
          }
      }

    $clientes = clientes::get();
    $sociedades = sociedades::get();
    $emisora = presupuestos::select('pre_emisora')
        ->where('pre_id','=',$pre_id)
        ->get();
    $emisora = $emisora[0]->pre_emisora;

    $razon_social = presupuestos::with('sociedades')
        ->find($pre_id);
    $cliente_objetivo = presupuestos::with('clientes')
        ->find($pre_id);
    $met_pago = metodos_pago::get();



       if(!isset($lin_pre[0]->lin_pre_id)){
           return view('form_presupuesto',[ 'sop_pre' => $sop_pre,
                                            'tar_pre' => $tar_pre,
                                            'dur_pre' => $dur_pre,
                                            'pre_pre' => $pre_pre,
                                            'des_pre' => $des_pre,
                                            'lin_pre' => 0,
                                            'mod_pre' => $mod_pre,
                                            'mod_lin' => $mod_lin_pre,
                                            'mod_opt' => $mod_opt_fil_pre,
                                            'cont'    => $contador,
                                            'clientes'=> $clientes,
                                            'sociedades'=> $sociedades,
                                            'razon_social' => $razon_social,
                                            'cliente_objetivo' => $cliente_objetivo,
                                            'emisora' => $emisora,
                                            'metodos_pago' => $met_pago,
                                            'accion_vigente' => $accion_vigente,
                                          ]);
       }
       else{
           return view('form_presupuesto',[ 'sop_pre' => $sop_pre,
                                            'tar_pre' => $tar_pre,
                                            'dur_pre' => $dur_pre,
                                            'pre_pre' => $pre_pre,
                                            'des_pre' => $des_pre,
                                            'lin_pre' => $lin_pre[0]->lin_pre_id,
                                            'mod_pre' => $mod_pre,
                                            'mod_lin' => $mod_lin_pre,
                                            'mod_opt' => $mod_opt_fil_pre,
                                            'cont'    => $contador,
                                            'clientes'=> $clientes,
                                            'sociedades'=>$sociedades,
                                            'razon_social' => $razon_social,
                                            'cliente_objetivo' => $cliente_objetivo,
                                            'emisora' => $emisora,
                                            'metodos_pago' => $met_pago,
                                            'accion_vigente' => $accion_vigente,
                                          ]);
       }


    }

    public function copiarPresupuestoID($pre_id) {
        $sop_pre = soportes_presupuesto::select ('sop_pre_nombre', 'sop_pre_id')
           -> orderBy ('sop_pre_id')
           -> get();

        $tar_pre = tarifas_presupuesto::select ('tar_pre_nombre', 'tar_pre_id', 'tar_pre_soporte')
           -> orderBy ('tar_pre_id')
           -> get();

        $dur_pre = duracion_presupuesto::select ('dur_pre_nombre', 'dur_pre_id', 'dur_pre_value')
           -> orderBy ('dur_pre_id')
           -> get();

        $pre_pre = precios_presupuesto::select ('pre_pre_tarifa', 'pre_pre_id', 'pre_pre_value', 'pre_pre_duracion')
           -> orderBy ('pre_pre_id')
           -> get();

        $des_pre = descuentos_presupuesto::select ('des_pre_id', 'des_pre_soporte', 'des_pre_value', 'des_pre_duracion')
           -> orderBy ('des_pre_id')
           -> get();

        $lin_pre = linea_presupuesto::select('lin_pre_id')
           ->orderByDesc('lin_pre_id')
           ->limit(1)
           ->get();

       $mod_pre = presupuestos::where('pre_id', '=', $pre_id)
           ->get();

       $mod_lin_pre = linea_presupuesto::where('lin_pre_pre', '=', $pre_id)
           ->with('soportes_presupuestos')
           ->with('tarifas_presupuestos')
           ->with('duracion_presupuestos')
           ->get();

       $mod_opt_fil_pre = optico_fila::where('opt_fil_pre', '=', $pre_id)
           ->with('mes')
           ->with('linea_presupuestos')
           ->with('tarifas_presupuestos')
           ->with('duracion_presupuestos')
           ->get();

       $contador = linea_presupuesto::where('lin_pre_pre', '=', $pre_id)
            ->orderBy('lin_pre_lin', 'desc')
            ->get();

      $contadores_opt = array();
      for ($i=1; $i <6 ; $i++) {

          $sop_pre[$i-1]->cantidad = optico_fila::where('opt_fil_pre', '=', $pre_id)
               ->where('opt_fil_sop', '=', $i)
               ->count();
      }

      foreach ($mod_opt_fil_pre as $clave => $mod_optico) {
          if(!is_null($mod_optico->opt_fil_lin)){
              $mes_ini = (int) date("n", strtotime($mod_optico->linea_presupuestos->lin_pre_dateini));
              $any_ini = (int) date("Y", strtotime($mod_optico->linea_presupuestos->lin_pre_dateini));
              $d_month = (int) cal_days_in_month(CAL_GREGORIAN, $mes_ini, $any_ini);
              $mod_opt_fil_pre[$clave] -> mes_ini = $mes_ini;
              $mod_opt_fil_pre[$clave] -> any_ini = $any_ini;
              $mod_opt_fil_pre[$clave] -> d_month = $d_month;
          }
      }

    $clientes = clientes::get();
    $sociedades = sociedades::get();
    $emisora = presupuestos::select('pre_emisora')
        ->where('pre_id','=',$pre_id)
        ->get();
    $emisora = $emisora[0]->pre_emisora;

    $razon_social = presupuestos::with('sociedades')
        ->find($pre_id);
    $cliente_objetivo = presupuestos::with('clientes')
        ->find($pre_id);

    $met_pago = metodos_pago::get();



       if(!isset($lin_pre[0]->lin_pre_id)){
           return view('form_presupuesto',[ 'sop_pre' => $sop_pre,
                                            'tar_pre' => $tar_pre,
                                            'dur_pre' => $dur_pre,
                                            'pre_pre' => $pre_pre,
                                            'des_pre' => $des_pre,
                                            'lin_pre' => 0,
                                            'mod_pre' => $mod_pre,
                                            'mod_lin' => $mod_lin_pre,
                                            'mod_opt' => $mod_opt_fil_pre,
                                            'cont'    => $contador[0]->lin_pre_lin,
                                            'clientes'=> $clientes,
                                            'sociedades'=> $sociedades,
                                            'razon_social' => $razon_social,
                                            'cliente_objetivo' => $cliente_objetivo,
                                            'emisora' => $emisora,
                                            'nueva_copia' => $pre_id,
                                            'metodos_pago' => $met_pago,
                                          ]);
       }
       else{
           return view('form_presupuesto',[ 'sop_pre' => $sop_pre,
                                            'tar_pre' => $tar_pre,
                                            'dur_pre' => $dur_pre,
                                            'pre_pre' => $pre_pre,
                                            'des_pre' => $des_pre,
                                            'lin_pre' => $lin_pre[0]->lin_pre_id,
                                            'mod_pre' => $mod_pre,
                                            'mod_lin' => $mod_lin_pre,
                                            'mod_opt' => $mod_opt_fil_pre,
                                            'cont'    => $contador[0]->lin_pre_lin,
                                            'clientes'=> $clientes,
                                            'sociedades'=>$sociedades,
                                            'razon_social' => $razon_social,
                                            'cliente_objetivo' => $cliente_objetivo,
                                            'emisora' => $emisora,
                                            'nueva_copia' => $pre_id,
                                            'metodos_pago' => $met_pago,
                                          ]);
       }


    }

    public function consultarAccionComercial(){
        $acc_com = presupuestos::where('pre_estado', '=', 'PREDEFINIDO')
            ->get();

        return view('accion_comercial',['acc_com' => $acc_com]);
    }

    public function eliminar_accion_comercial(Request $request){
        //dd($request);

        $target = $_POST["acc_com_id"];
        optico_fila::where('opt_fil_pre', '=', $target) -> delete();
        linea_presupuesto::where('lin_pre_pre', '=', $target) -> delete();
        presupuestos::where('pre_id', '=', $target) -> delete();

        return $this->consultarAccionComercial();
    }

    public function guardar_accion_comercial(Request $request){
        $contador_soporte = 1;
        $numero_filas;
        $nombre;

        //Llenar este array con un valor representativo de todas las filas del optico, independientemente de tipo
        $filas = array();

        if(isset($_POST["true_cont"])){
            $contador = $_POST["true_cont"];
        } else {
            $contador = 0;
        }

        $i = 0;
        $datemin = mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+100);
        $datemax = mktime(0, 0, 0, date("m"),   date("d"),   date("Y"));

        while ($contador) {
            if(isset($_POST["sop_id" . $i])) {
                if($_POST["fechaini" . $i] < $datemin) {
                    $datemin = $_POST["fechaini" . $i];
                }
                if($_POST["fechafin" . $i] > $datemax) {
                    $datemax = $_POST["fechafin" . $i];
                }
                $i++;
                $contador--;
            } else {
                $i++;
            }
        }

        $obj_pre = new presupuestos;
        $obj_pre -> pre_estado      = "PREDEFINIDO";
        $obj_pre -> pre_tot_brut    = floatval(substr($_POST["totalbrut"], 0, -2));
        $obj_pre -> pre_tot_desc    = floatval(substr($_POST["totaldesc"], 0, -2));
        $obj_pre -> pre_tot_neto    = floatval(substr($_POST["totalneto"], 0, -2));
        $obj_pre -> pre_dateini     = $datemin;
        $obj_pre -> pre_datefin     = $datemax;
        $obj_pre -> acc_com_name    = $_POST['acc_name'];
        $obj_pre -> acc_com_tipo    = $_POST['acc_tipo'];

        if(isset($_POST["acc_com_id"])){
            $target = $_POST["acc_com_id"];
            optico_fila::where('opt_fil_pre', '=', $target) -> delete();
            linea_presupuesto::where('lin_pre_pre', '=', $target) -> delete();
            presupuestos::where('pre_id', '=', $target) -> delete();
            $obj_pre -> pre_id = $target;
        }

        $obj_pre -> save();

        try {

        } catch(QueryException $e){
            //TODO controlar error
        }


        if(isset($_POST["true_cont"])){
            $contador = $_POST["true_cont"];
        } else {
            $contador = 0;
        }

        $i = 0;
        $maximo_optico = Optico_fila::max('opt_fil_id');

        $filas_optico = array();
        while ($contador) {
            if(isset($_POST["sop_id" . $i])){
                $linea_presupuesto = new linea_presupuesto;
                $linea_presupuesto -> lin_pre_sop = $_POST["sop_id" . $i];
                $linea_presupuesto -> lin_pre_tar = $_POST["tar_id" . $i];
                $linea_presupuesto -> lin_pre_ncu = $_POST["ncunya" . $i];
                $linea_presupuesto -> lin_pre_dur = $_POST["dur_id" . $i];
                $linea_presupuesto -> lin_pre_dateini = $_POST["fechaini" . $i];
                $linea_presupuesto -> lin_pre_datefin = $_POST["fechafin" . $i];
                $linea_presupuesto  -> lin_pre_valido = 0;
                $linea_presupuesto -> lin_pre_desc = $_POST["desc" . $i];
                $linea_presupuesto -> lin_pre_prec = $_POST["neto" . $i];
                $linea_presupuesto -> lin_pre_pre = $obj_pre -> pre_id;
                $linea_presupuesto -> lin_pre_lin = $i;

                    $linea_presupuesto -> save();
                try {

                } catch(QueryException $e){
                    //TODO Controlar error
                }

                $id_soporte = $linea_presupuesto -> lin_pre_sop;
                $numero_filas = $_POST["opt_cont" . $id_soporte];
                $info_dias = 0;
                $datos_dias = 0;
                $year = date('Y');
                $mes = 0;

                //Se buscarán filas hasta que se hayan encontrado todas las que indica el numero de filas
                for ($j=1; $j <$numero_filas+1 ; ) {
                    if(isset($_POST["mes_name".$mes."_".$year."_".$id_soporte])){
                        $nombre = "mes_name".$mes."_".$year."_".$id_soporte;
                        if(!in_array($nombre,$filas)){
                            array_push($filas,$nombre);
                            //bucle para almacenar lineas de info del mes
                            $dia = 1;
                            $info_dias = array();
                            while ($dia <= 31) {
                                if(isset($_POST["dia".$dia."_".$mes."_".$year."_".$id_soporte])) {
                                    if($_POST["dia".$dia."_".$mes."_".$year."_".$id_soporte] == NULL) {
                                        array_push($info_dias, 0);
                                    } else {
                                        array_push($info_dias, $_POST["dia".$dia."_".$mes."_".$year."_".$id_soporte]);
                                    }
                                } else {
                                    array_push($info_dias, 0);
                                }
                                $dia++;
                            }

                            //se almacena en BD la linea del mes
                            $fila_opt_info = new optico_fila;
                            $fila_opt_info -> opt_fil_id = $maximo_optico + $j;
                            //echo nl2br("insertando fila: " . $maximo_optico + $j . "\n");
                            $fila_opt_info -> opt_fil_isdata = 0;
                            $fila_opt_info -> opt_fil_mes    = $mes+1;
                            $fila_opt_info -> opt_fil_anyo   = $year;
                            $fila_opt_info -> opt_fil_pre    = $obj_pre -> pre_id;
                            $fila_opt_info -> opt_fil_sop    = $id_soporte;
                            $fila_opt_info -> opt_fil_data1  = $info_dias[0];
                            $fila_opt_info -> opt_fil_data2  = $info_dias[1];
                            $fila_opt_info -> opt_fil_data3  = $info_dias[2];
                            $fila_opt_info -> opt_fil_data4  = $info_dias[3];
                            $fila_opt_info -> opt_fil_data5  = $info_dias[4];
                            $fila_opt_info -> opt_fil_data6  = $info_dias[5];
                            $fila_opt_info -> opt_fil_data7  = $info_dias[6];
                            $fila_opt_info -> opt_fil_data8  = $info_dias[7];
                            $fila_opt_info -> opt_fil_data9  = $info_dias[8];
                            $fila_opt_info -> opt_fil_data10 = $info_dias[9];
                            $fila_opt_info -> opt_fil_data11 = $info_dias[10];
                            $fila_opt_info -> opt_fil_data12 = $info_dias[11];
                            $fila_opt_info -> opt_fil_data13 = $info_dias[12];
                            $fila_opt_info -> opt_fil_data14 = $info_dias[13];
                            $fila_opt_info -> opt_fil_data15 = $info_dias[14];
                            $fila_opt_info -> opt_fil_data16 = $info_dias[15];
                            $fila_opt_info -> opt_fil_data17 = $info_dias[16];
                            $fila_opt_info -> opt_fil_data18 = $info_dias[17];
                            $fila_opt_info -> opt_fil_data19 = $info_dias[18];
                            $fila_opt_info -> opt_fil_data20 = $info_dias[19];
                            $fila_opt_info -> opt_fil_data21 = $info_dias[20];
                            $fila_opt_info -> opt_fil_data22 = $info_dias[21];
                            $fila_opt_info -> opt_fil_data23 = $info_dias[22];
                            $fila_opt_info -> opt_fil_data24 = $info_dias[23];
                            $fila_opt_info -> opt_fil_data25 = $info_dias[24];
                            $fila_opt_info -> opt_fil_data26 = $info_dias[25];
                            $fila_opt_info -> opt_fil_data27 = $info_dias[26];
                            $fila_opt_info -> opt_fil_data28 = $info_dias[27];
                            $fila_opt_info -> opt_fil_data29 = $info_dias[28];
                            $fila_opt_info -> opt_fil_data30 = $info_dias[29];
                            $fila_opt_info -> opt_fil_data31 = $info_dias[30];

                            $fila_opt_info -> opt_fil_id = Optico_fila::max('opt_fil_id')+1;
                            $fila_opt_info -> save();
                            try {

                            } catch(QueryException $e){
                                //TODO Controlar error
                                echo('Ha habido un error');
                            }
                            $filas_optico [$j] = $fila_opt_info -> opt_fil_id;
                            //guardar en BBDD
                            $j++;
                        } else {
                            $j++;
                        }
                    }

                    for ($k=0; $k < 50; $k++) {
                        if(isset($_POST["dur_opt_id".$mes."_".$year."_".$id_soporte."_".$k])){
                            if($k == $linea_presupuesto->lin_pre_lin){
                                $nombre = "dur_opt_id".$mes."_".$year."_".$id_soporte."_".$k;
                                if(!in_array($nombre,$filas)){
                                    array_push($filas,$nombre);
                                    $dia = 1;
                                    $datos_dias = array();
                                    while ($dia <= 31) {
                                        if(isset($_POST["val".$dia."_".$mes."_".$year."_".$id_soporte."_".$k])) {
                                            if($_POST["val".$dia."_".$mes."_".$year."_".$id_soporte."_".$k] == NULL) {
                                                array_push($datos_dias, 0);
                                            } else {
                                                array_push($datos_dias, (int)$_POST["val".$dia."_".$mes."_".$year."_".$id_soporte."_".$k]);

                                            }
                                        } else {
                                            array_push($datos_dias, -1);
                                        }

                                        $dia++;

                                    }
                                    $fila_opt_datos = new optico_fila;
                                    $fila_opt_datos -> opt_fil_id = $maximo_optico + $j;
                                    //echo nl2br("insertando fila: " . $maximo_optico + $j . "\n");
                                    $fila_opt_datos -> opt_fil_isdata = 1;
                                    $fila_opt_datos -> opt_fil_mes    = $mes+1;
                                    $fila_opt_datos -> opt_fil_anyo   = $year;
                                    $fila_opt_datos -> opt_fil_lin    = $linea_presupuesto -> lin_pre_id;


                                    $fila_opt_datos -> opt_fil_pre    = $obj_pre -> pre_id;
                                    $fila_opt_datos -> opt_fil_sop    = $id_soporte;
                                    $fila_opt_datos -> opt_fil_tar    = $_POST["tar_opt_id".$mes."_".$year."_".$k];
                                    $fila_opt_datos -> opt_fil_dur    = $_POST["dur_opt_id".$mes."_".$year."_".$id_soporte."_".$k];
                                    if($_POST["matricula".$mes."_".$year."_".$k] != NULL) {
                                        $fila_opt_datos -> opt_fil_mat = $_POST["matricula".$mes."_".$year."_".$k];
                                    }
                                    if($_POST["hora".$mes."_".$year."_".$k] != NULL) {
                                        $fila_opt_datos -> opt_fil_hora = $_POST["hora".$mes."_".$year."_".$k];
                                    }
                                    $fila_opt_datos -> opt_fil_data1  = $datos_dias[0];
                                    $fila_opt_datos -> opt_fil_data2  = $datos_dias[1];
                                    $fila_opt_datos -> opt_fil_data3  = $datos_dias[2];
                                    $fila_opt_datos -> opt_fil_data4  = $datos_dias[3];
                                    $fila_opt_datos -> opt_fil_data5  = $datos_dias[4];
                                    $fila_opt_datos -> opt_fil_data6  = $datos_dias[5];
                                    $fila_opt_datos -> opt_fil_data7  = $datos_dias[6];
                                    $fila_opt_datos -> opt_fil_data8  = $datos_dias[7];
                                    $fila_opt_datos -> opt_fil_data9  = $datos_dias[8];
                                    $fila_opt_datos -> opt_fil_data10 = $datos_dias[9];
                                    $fila_opt_datos -> opt_fil_data11 = $datos_dias[10];
                                    $fila_opt_datos -> opt_fil_data12 = $datos_dias[11];
                                    $fila_opt_datos -> opt_fil_data13 = $datos_dias[12];
                                    $fila_opt_datos -> opt_fil_data14 = $datos_dias[13];
                                    $fila_opt_datos -> opt_fil_data15 = $datos_dias[14];
                                    $fila_opt_datos -> opt_fil_data16 = $datos_dias[15];
                                    $fila_opt_datos -> opt_fil_data17 = $datos_dias[16];
                                    $fila_opt_datos -> opt_fil_data18 = $datos_dias[17];
                                    $fila_opt_datos -> opt_fil_data19 = $datos_dias[18];
                                    $fila_opt_datos -> opt_fil_data20 = $datos_dias[19];
                                    $fila_opt_datos -> opt_fil_data21 = $datos_dias[20];
                                    $fila_opt_datos -> opt_fil_data22 = $datos_dias[21];
                                    $fila_opt_datos -> opt_fil_data23 = $datos_dias[22];
                                    $fila_opt_datos -> opt_fil_data24 = $datos_dias[23];
                                    $fila_opt_datos -> opt_fil_data25 = $datos_dias[24];
                                    $fila_opt_datos -> opt_fil_data26 = $datos_dias[25];
                                    $fila_opt_datos -> opt_fil_data27 = $datos_dias[26];
                                    $fila_opt_datos -> opt_fil_data28 = $datos_dias[27];
                                    $fila_opt_datos -> opt_fil_data29 = $datos_dias[28];
                                    $fila_opt_datos -> opt_fil_data30 = $datos_dias[29];
                                    $fila_opt_datos -> opt_fil_data31 = $datos_dias[30];
                                    $fila_opt_datos -> opt_fil_datauds = $_POST["total".$mes."_".$year."_".$id_soporte."_".$k];

                                    $fila_opt_datos -> opt_fil_id = Optico_fila::max('opt_fil_id')+1;

                                    try {

                                        $fila_opt_datos -> save();
                                    } catch(QueryException $e){
                                        echo('Ha habido un error');
                                        //TODO Controlar error
                                    }

                                    $filas_optico [$j] = $fila_opt_datos -> opt_fil_id;

                                    $j++;
                                }
                            } else {
                                $j++;
                            }
                        }
                    }


                    if ($mes + 1 == 12) { $mes = 0; $year++; }
                    else { $mes++; }
                }

                $i++;
                $contador--;
            } else {
                $i++;
            }
        }
        ksort($filas_optico);

        $maxima_id = -1;

        foreach ($filas_optico as $key => $value) {
            if($value > $maxima_id)
                $maxima_id = $value;
        }

        foreach ($filas_optico as $key => $value) {
            $fila = Optico_fila::find($value);

            $fila -> opt_fil_id = $maxima_id + $key;

            $fila -> save();
        }

        header( "Location: admin_accion_comercial", true, 303 );
        exit();
    }

    public function consultarAccionComercialID($pre_id){
        $acc_com = presupuestos::where('pre_id', '=', $pre_id)
            ->get();

        $mod_opt_fil_pre = optico_fila::where('opt_fil_pre', '=', $pre_id)
            ->with('mes')
            ->with('linea_presupuestos')
            ->with('tarifas_presupuestos')
            ->with('duracion_presupuestos')
            ->get();

        $mod_lin_pre = linea_presupuesto::where('lin_pre_pre', '=', $pre_id)
            ->with('soportes_presupuestos')
            ->with('tarifas_presupuestos')
            ->with('duracion_presupuestos')
            ->get();

        $lin_pre = linea_presupuesto::select('lin_pre_id')
           ->orderByDesc('lin_pre_id')
           ->limit(1)
           ->get();

        $lineas_acc_com = linea_presupuesto::where('lin_pre_pre', '=', $pre_id)
            ->with('soportes_presupuestos')
            ->with('tarifas_presupuestos')
            ->with('duracion_presupuestos')
            ->get();

        $sop_pre = soportes_presupuesto::select ('sop_pre_nombre', 'sop_pre_id')
           -> orderBy ('sop_pre_id')
           -> get();

        $tar_pre = tarifas_presupuesto::select ('tar_pre_nombre', 'tar_pre_id', 'tar_pre_soporte')
           -> orderBy ('tar_pre_id')
           -> get();

        $dur_pre = duracion_presupuesto::select ('dur_pre_nombre', 'dur_pre_id', 'dur_pre_value')
           -> orderBy ('dur_pre_id')
           -> get();

        $pre_pre = Precios_presupuesto::select ('pre_pre_tarifa', 'pre_pre_id', 'pre_pre_value', 'pre_pre_duracion')
           -> orderBy ('pre_pre_id')
           -> get();

        $des_pre = Descuentos_presupuesto::select ('des_pre_id', 'des_pre_soporte', 'des_pre_value', 'des_pre_duracion')
           -> orderBy ('des_pre_id')
           -> get();

       $contador = linea_presupuesto::where('lin_pre_pre', '=', $pre_id)
            ->count();
        for ($i=1; $i <6 ; $i++) {

            $sop_pre[$i-1]->cantidad = optico_fila::where('opt_fil_pre', '=', $pre_id)
                 ->where('opt_fil_sop', '=', $i)
                 ->count();
        }

         if(!isset($lin_pre[0]->lin_pre_id)){
             return view('crear_accion_comercial',['acc_com'         => $acc_com,
                                                   'lineas_acc_com'  => $lineas_acc_com,
                                                   'acc_com_id'      => $pre_id,
                                                   'pre_pre'         => $pre_pre,
                                                   'des_pre'         => $des_pre,
                                                   'sop_pre'         => $sop_pre,
                                                   'tar_pre'         => $tar_pre,
                                                   'dur_pre'         => $dur_pre,
                                                   'cont'            => $contador,
                                                   'mod_opt'         => $mod_opt_fil_pre,
                                                   'mod_lin'         => $mod_lin_pre,
                                                   'lin_pre'         => 0,
                                               ]);
         }else{
             return view('crear_accion_comercial',['acc_com'         => $acc_com,
                                                   'lineas_acc_com'  => $lineas_acc_com,
                                                   'acc_com_id'      => $pre_id,
                                                   'pre_pre'         => $pre_pre,
                                                   'des_pre'         => $des_pre,
                                                   'sop_pre'         => $sop_pre,
                                                   'tar_pre'         => $tar_pre,
                                                   'dur_pre'         => $dur_pre,
                                                   'cont'            => $contador,
                                                   'mod_opt'         => $mod_opt_fil_pre,
                                                   'mod_lin'         => $mod_lin_pre,
                                                   'lin_pre'         => $lin_pre[0]->lin_pre_id,
                                               ]);
         }



    }

    public function CrearPresupuesto_DesdeCero($id_cliente) {
        if(!isset($_SESSION)){
            session_start();
        }

        $sop_pre = Soportes_presupuesto::select ('sop_pre_nombre', 'sop_pre_id')
           -> orderBy ('sop_pre_id')
           -> get();

        $tar_pre = Tarifas_presupuesto::select ('tar_pre_nombre', 'tar_pre_id', 'tar_pre_soporte')
           -> orderBy ('tar_pre_id')
           -> get();

        $dur_pre = Duracion_presupuesto::select ('dur_pre_nombre', 'dur_pre_id', 'dur_pre_value')
           -> orderBy ('dur_pre_id')
           -> get();

        $pre_pre = Precios_presupuesto::select ('pre_pre_tarifa', 'pre_pre_id', 'pre_pre_value', 'pre_pre_duracion')
           -> orderBy ('pre_pre_id')
           -> get();

        $des_pre = Descuentos_presupuesto::select ('des_pre_id', 'des_pre_soporte', 'des_pre_value', 'des_pre_duracion')
           -> orderBy ('des_pre_id')
           -> get();


        $cliente = Clientes::with('metodos_pago')
            ->find($id_cliente);

        // dd($cliente);
        if($_SESSION['status'] == 'admin'){
            $clientes = clientes::where('cli_est_cli', '=', 'ACEPTADO')
                ->orwhere('cli_est_cli', 'like', '%POTENCIAL%')
                ->get();
        } else {
            $clientes = clientes::where('cli_age', '=', $_SESSION['id_ase'])
                ->where('cli_est_cli', '=', 'ACEPTADO')
                ->orwhere('cli_est_cli', 'like', '%POTENCIAL%')
                ->get();
        }

        $sociedades = sociedades::get();

        $met_pago = metodos_pago::get();

        return view('form_presupuesto_cliente',   [ 'sop_pre' => $sop_pre,
                                                    'tar_pre' => $tar_pre,
                                                    'dur_pre' => $dur_pre,
                                                    'pre_pre' => $pre_pre,
                                                    'des_pre' => $des_pre,
                                                    'lin_pre' => 0,
                                                    'cli'     => $cliente,
                                                    'sociedades' => $sociedades,
                                                    'clientes'=>$clientes,
                                                    'metodos_pago' => $met_pago,
                                                  ]);


    }

    public function Elegir_Acc($id_cliente){
        $acc_com = presupuestos::where('pre_estado', '=', 'PREDEFINIDO')
            ->get();
        return view('selector_accion_comercial', ['cli'=>$id_cliente, 'acc_com' => $acc_com]);
    }

    public function crearDesdeAcc($id_cli, $pre_id){
        if(!isset($_SESSION)){
            session_start();
        }

        $cliente = Clientes::find($id_cli);

        $sop_pre = soportes_presupuesto::select ('sop_pre_nombre', 'sop_pre_id')
           -> orderBy ('sop_pre_id')
           -> get();

        $tar_pre = tarifas_presupuesto::select ('tar_pre_nombre', 'tar_pre_id', 'tar_pre_soporte')
           -> orderBy ('tar_pre_id')
           -> get();

        $dur_pre = duracion_presupuesto::select ('dur_pre_nombre', 'dur_pre_id', 'dur_pre_value')
           -> orderBy ('dur_pre_id')
           -> get();

        $pre_pre = precios_presupuesto::select ('pre_pre_tarifa', 'pre_pre_id', 'pre_pre_value', 'pre_pre_duracion')
           -> orderBy ('pre_pre_id')
           -> get();

        $des_pre = descuentos_presupuesto::select ('des_pre_id', 'des_pre_soporte', 'des_pre_value', 'des_pre_duracion')
           -> orderBy ('des_pre_id')
           -> get();

        $lin_pre = linea_presupuesto::select('lin_pre_id')
           ->orderByDesc('lin_pre_id')
           ->limit(1)
           ->get();

       $mod_pre = presupuestos::where('pre_id', '=', $pre_id)
       ->get();

       $cont_pre = linea_presupuesto::select('lin_pre_sop')
            ->where('lin_pre_pre', '=', $pre_id)
            ->distinct()
            ->count();

        //dd($mod_pre[0]->acc_com_name);

       $mod_lin_pre = linea_presupuesto::where('lin_pre_pre', '=', $pre_id)
           ->with('soportes_presupuestos')
           ->with('tarifas_presupuestos')
           ->with('duracion_presupuestos')
           ->get();

       $mod_opt_fil_pre = optico_fila::where('opt_fil_pre', '=', $pre_id)
           ->with('mes')
           ->with('linea_presupuestos')
           ->with('tarifas_presupuestos')
           ->with('duracion_presupuestos')
           ->get();

      $contador = linea_presupuesto::where('lin_pre_pre', '=', $pre_id)
           ->orderBy('lin_pre_lin', 'desc')
           ->get();

      if($_SESSION['status'] == 'admin'){
          $clientes = clientes::where('cli_est_cli', '=', 'ACEPTADO')
              ->orwhere('cli_est_cli', 'like', '%POTENCIAL%')
              ->get();
      } else {
          $clientes = clientes::where('cli_age', '=', $_SESSION['id_ase'])
              ->where('cli_est_cli', '=', 'ACEPTADO')
              ->orwhere('cli_est_cli', 'like', '%POTENCIAL%')
              ->get();
      }

      $sociedades = sociedades::get();

      $contadores_opt = array();
      for ($i=1; $i <6 ; $i++) {

          $sop_pre[$i-1]->cantidad = optico_fila::where('opt_fil_pre', '=', $pre_id)
               ->where('opt_fil_sop', '=', $i)
               ->count();
      }

      foreach ($mod_opt_fil_pre as $clave => $mod_optico) {
          if(!is_null($mod_optico->opt_fil_lin)){
              $mes_ini = (int) date("n", strtotime($mod_optico->linea_presupuestos->lin_pre_dateini));
              $any_ini = (int) date("Y", strtotime($mod_optico->linea_presupuestos->lin_pre_dateini));
              $d_month = (int) cal_days_in_month(CAL_GREGORIAN, $mes_ini, $any_ini);
              $mod_opt_fil_pre[$clave] -> mes_ini = $mes_ini;
              $mod_opt_fil_pre[$clave] -> any_ini = $any_ini;
              $mod_opt_fil_pre[$clave] -> d_month = $d_month;
          }
      }

      $met_pago = metodos_pago::get();

       return view('form_presupuesto_cliente',[ 'sop_pre' => $sop_pre,
                                        'tar_pre' => $tar_pre,
                                        'dur_pre' => $dur_pre,
                                        'pre_pre' => $pre_pre,
                                        'des_pre' => $des_pre,
                                        'lin_pre' => 0,
                                        'mod_pre' => $mod_pre,
                                        'mod_lin' => $mod_lin_pre,
                                        'mod_opt' => $mod_opt_fil_pre,
                                        'cont_pre'=> $cont_pre,
                                        'cont'    => $contador[0]->lin_pre_lin,
                                        'cli'     => $cliente,
                                        'clientes'=> $clientes,
                                        'sociedades' => $sociedades,
                                        'metodos_pago' => $met_pago,
                                      ]);
    }

    public function filtrar_historico(Request $request){
        //dd($request);

        session_start();

        $query = presupuestos::whereIn('pre_estado', ['ACEPTADO', 'RECHAZADO'])
            ->where('pre_creador', $_SESSION['id_ase'])
            ->orderBy('updated_at', 'DESC')
            ->with('asesores')
            ->get();

        $array = array();
        $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        if($request['mes_filtro'] == 0){
            if($request['anyo_filtro'] == 0){
                //AMBOS NULOS
                for($i = 0; $i < count($query); $i++){
                    array_push($array, $query[$i]);
                }
            } else {
                //MES NULO
                for($i = 0; $i < count($query); $i++){
                    if($query[$i]->updated_at->format('Y') == $request['anyo_filtro']){
                        array_push($array, $query[$i]);
                    }
                }
            }
        } else {
            if($request['anyo_filtro'] == 0){
                //AÑO NULO
                for($i = 0; $i < count($query); $i++){
                    if($query[$i]->updated_at->format('m') == $request['mes_filtro']){
                        array_push($array, $query[$i]);
                    }
                }
            } else {
                //NINGUNO NULO
                for($i = 0; $i < count($query); $i++){
                    if($query[$i]->updated_at->format('Y') == $request['anyo_filtro']){
                        if($query[$i]->updated_at->format('m') == $request['mes_filtro']){
                            array_push($array, $query[$i]);
                        }
                    }
                }
            }
        }
        return view('historico_presupuesto', ['presupuestos' => $array, 'anyo' => $request['primer_anyo'], 'anyo_elegido' => $request['anyo_filtro'], 'mes_elegido' => $request['mes_filtro'], 'orden_elegido' => $request['orden_filtro'], 'meses' => $meses]);
    }

    public function filtrar_ventas(Request $request){
        //dd($request);

        $query = presupuestos::where('pre_estado', '=', 'ACEPTADO')
            ->with('clientes')
            ->with('asesores')
            ->get();

        $array = array();
        $meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        if($request['mes_filtro'] == 0){
            if($request['anyo_filtro'] == 0){
                //AMBOS NULOS
                for($i = 0; $i < count($query); $i++){
                    array_push($array, $query[$i]);
                }
            } else {
                //MES NULO
                for($i = 0; $i < count($query); $i++){
                    if($query[$i]->updated_at->format('Y') == $request['anyo_filtro']){
                        array_push($array, $query[$i]);
                    }
                }
            }
        } else {
            if($request['anyo_filtro'] == 0){
                //AÑO NULO
                for($i = 0; $i < count($query); $i++){
                    if($query[$i]->updated_at->format('m') == $request['mes_filtro']){
                        array_push($array, $query[$i]);
                    }
                }
            } else {
                //NINGUNO NULO
                for($i = 0; $i < count($query); $i++){
                    if($query[$i]->updated_at->format('Y') == $request['anyo_filtro']){
                        if($query[$i]->updated_at->format('m') == $request['mes_filtro']){
                            array_push($array, $query[$i]);
                        }
                    }
                }
            }
        }
        return view('ventas_presupuesto', ['aceptados' => $array, 'anyo' => $request['primer_anyo'], 'anyo_elegido' => $request['anyo_filtro'], 'mes_elegido' => $request['mes_filtro'], 'meses' => $meses]);
    }

    public function datos_anunciante(Request $request){

        $datos = clientes::where('cli_anu','=',$request['nombre_anunciante'])
            ->get();

        header("Content-Type: application/json");
        echo json_encode($datos);
    }

    public function fichaPresupuesto($pre_id){
        $sop_pre = soportes_presupuesto::select ('sop_pre_nombre', 'sop_pre_id')
           -> orderBy ('sop_pre_id')
           -> get();

        $tar_pre = tarifas_presupuesto::select ('tar_pre_nombre', 'tar_pre_id', 'tar_pre_soporte')
           -> orderBy ('tar_pre_id')
           -> get();

        $dur_pre = duracion_presupuesto::select ('dur_pre_nombre', 'dur_pre_id', 'dur_pre_value')
           -> orderBy ('dur_pre_id')
           -> get();

        $pre_pre = precios_presupuesto::select ('pre_pre_tarifa', 'pre_pre_id', 'pre_pre_value', 'pre_pre_duracion')
           -> orderBy ('pre_pre_id')
           -> get();

        $des_pre = descuentos_presupuesto::select ('des_pre_id', 'des_pre_soporte', 'des_pre_value', 'des_pre_duracion')
           -> orderBy ('des_pre_id')
           -> get();

        $lin_pre = linea_presupuesto::select('lin_pre_id')
           ->orderByDesc('lin_pre_id')
           ->limit(1)
           ->get();

       $mod_pre = presupuestos::where('pre_id', '=', $pre_id)
           ->get();

       $mod_lin_pre = linea_presupuesto::where('lin_pre_pre', '=', $pre_id)
           ->with('soportes_presupuestos')
           ->with('tarifas_presupuestos')
           ->with('duracion_presupuestos')
           ->get();

       $mod_opt_fil_pre = optico_fila::where('opt_fil_pre', '=', $pre_id)
           ->with('mes')
           ->with('linea_presupuestos')
           ->with('tarifas_presupuestos')
           ->with('duracion_presupuestos')
           ->get();

       $contador = linea_presupuesto::where('lin_pre_pre', '=', $pre_id)
            ->orderBy('lin_pre_lin', 'desc')
            ->get();

      $contadores_opt = array();
      for ($i=1; $i <6 ; $i++) {

          $sop_pre[$i-1]->cantidad = optico_fila::where('opt_fil_pre', '=', $pre_id)
               ->where('opt_fil_sop', '=', $i)
               ->count();
      }

      foreach ($mod_opt_fil_pre as $clave => $mod_optico) {
          if(!is_null($mod_optico->opt_fil_lin)){
              $mes_ini = (int) date("n", strtotime($mod_optico->linea_presupuestos->lin_pre_dateini));
              $any_ini = (int) date("Y", strtotime($mod_optico->linea_presupuestos->lin_pre_dateini));
              $d_month = (int) cal_days_in_month(CAL_GREGORIAN, $mes_ini, $any_ini);
              $mod_opt_fil_pre[$clave] -> mes_ini = $mes_ini;
              $mod_opt_fil_pre[$clave] -> any_ini = $any_ini;
              $mod_opt_fil_pre[$clave] -> d_month = $d_month;
          }
      }

    $clientes = clientes::get();
    $sociedades = sociedades::get();
    $emisora = presupuestos::select('pre_emisora')
        ->where('pre_id','=',$pre_id)
        ->get();
    $emisora = $emisora[0]->pre_emisora;

    $razon_social = presupuestos::with('sociedades')
        ->find($pre_id);

    $acc_com = NULL;
    if($mod_pre[0]->pre_acc_com != NULL){
        $acc_com = presupuestos::where('pre_id','=',$mod_pre[0]->pre_acc_com)
            ->get()[0];
    }


        // dd($mod_opt_fil_pre);

       if(!isset($lin_pre[0]->lin_pre_id)){
           return view('presupuestos_ficha',[ 'sop_pre' => $sop_pre,
                                            'tar_pre' => $tar_pre,
                                            'dur_pre' => $dur_pre,
                                            'pre_pre' => $pre_pre,
                                            'des_pre' => $des_pre,
                                            'lin_pre' => 0,
                                            'acc_com' => $acc_com,
                                            'mod_pre' => $mod_pre,
                                            'mod_lin' => $mod_lin_pre,
                                            'mod_opt' => $mod_opt_fil_pre,
                                            'cont'    => $contador[0]->lin_pre_lin,
                                            'clientes'=> $clientes,
                                            'sociedades'=> $sociedades,
                                            'razon_social' => $razon_social,
                                            'emisora' => $emisora
                                          ]);
       }
       else{
           return view('presupuestos_ficha',[ 'sop_pre' => $sop_pre,
                                            'tar_pre' => $tar_pre,
                                            'dur_pre' => $dur_pre,
                                            'pre_pre' => $pre_pre,
                                            'des_pre' => $des_pre,
                                            'lin_pre' => $lin_pre[0]->lin_pre_id,
                                            'acc_com' => $acc_com,
                                            'mod_pre' => $mod_pre,
                                            'mod_lin' => $mod_lin_pre,
                                            'mod_opt' => $mod_opt_fil_pre,
                                            'cont'    => $contador[0]->lin_pre_lin,
                                            'clientes'=> $clientes,
                                            'sociedades'=>$sociedades,
                                            'razon_social' => $razon_social,
                                            'emisora' => $emisora
                                          ]);
       }
   }

    public function showAgenda(){
        //12/05/2022 -> https://fullcalendar.io
        if(!isset($_SESSION)){
            session_start();
        }

        if ($_SESSION['status'] == 'admin') {
            $cont = users::where('user_name', '<>', 'ADMINISTRADOR')
                ->get();

            $array_final = array();
            foreach ($cont as $usuario) {
                $consulta = presupuestos::with('clientes')
                    ->where('pre_creador','=',$usuario->user_ase)
                    ->whereIn('pre_estado', ['ACEPTADO','RECHAZADO'])
                    ->get();

                $eventos = array();
                $contador = 0;
                foreach ($consulta as $evento) {
                    $eventos[$contador] = array();

                    if($evento->pre_tipo_reunion === NULL){
                        $eventos[$contador]['title'] = $evento->clientes->cli_anu;
                    }
                    else {
                        $eventos[$contador]['title'] = $evento->clientes->cli_anu;
                    }
                    $eventos[$contador]['start'] = $evento->pre_dateprox;
                    $eventos[$contador]['end']   = $evento->pre_dateprox;
                    $eventos[$contador]['url']   = url('clientes_ficha/' . $evento->pre_cliente);
                    $eventos[$contador]['id']= $evento->pre_id;

                    switch ($evento->pre_tipo_reunion) {
                        case "Llamada":
                            $eventos[$contador]['backgroundColor'] = '#107a39';
                            break;
                        case "Reunion":
                            $eventos[$contador]['backgroundColor'] = '#103e7a';
                            break;
                        case "Email":
                            $eventos[$contador]['backgroundColor'] = '#7a1055';
                            break;

                        default:
                            $eventos[$contador]['backgroundColor'] = '#f56342';
                            break;
                    }

                    $contador ++;
                }

                array_push($array_final, $eventos);
            }

            return view('agenda', ['contador'=>$cont, 'array_eventos'=>$array_final]);
        } else {
            $consulta = presupuestos::with('clientes')
                ->where('pre_creador','=',$_SESSION['id_ase'])
                ->whereIn('pre_estado', ['ACEPTADO','RECHAZADO'])
                ->get();

            $eventos = array();
            $contador = 0;
            foreach ($consulta as $evento) {
                $eventos[$contador] = array();

                if($evento->pre_tipo_reunion === NULL){
                    $eventos[$contador]['title'] = $evento->clientes->cli_anu;
                }
                else {
                    $eventos[$contador]['title'] = $evento->clientes->cli_anu;
                }
                $eventos[$contador]['start'] = $evento->pre_dateprox;
                $eventos[$contador]['end']   = $evento->pre_dateprox;
                $eventos[$contador]['url']   = url('clientes_ficha/' . $evento->pre_cliente);
                $eventos[$contador]['id']= $evento->pre_id;

                switch ($evento->pre_tipo_reunion) {
                    case "Llamada":
                        $eventos[$contador]['backgroundColor'] = '#107a39';
                        break;
                    case "Reunion":
                        $eventos[$contador]['backgroundColor'] = '#103e7a';
                        break;
                    case "Email":
                        $eventos[$contador]['backgroundColor'] = '#7a1055';
                        break;

                    default:
                        $eventos[$contador]['backgroundColor'] = '#f56342';
                        break;
                }

                $contador ++;
            }

            $interes = presupuestos::where('pre_creador','=',$_SESSION['id_ase'])
                ->where('pre_estado','=','ACEPTADO')
                ->with('clientes')
                ->orderBy('pre_datefin','asc')
                ->take(10)
                ->get();

            return view('agenda', ['contador'=>null,'array_eventos'=>$eventos, 'intereses'=>$interes]);
        }


    }

    public function cambioEvento(){
        session_start();
        header("Content-Type: application/json");

        $presupuesto = presupuestos::find($_POST['id_cambio']);
        $presupuesto -> pre_dateprox = $_POST['fecha_cambio'];
        $presupuesto -> pre_motivo_rechazo = $_POST['motivo_cambio'];
        $presupuesto -> pre_tipo_reunion = $_POST['tipo_cambio'];

        try {
            $presupuesto -> save();
        } catch (\Exception $e) {
            echo json_encode("Error");
        }

        //AÑADIR CAMBIO AL HISTORIAL DE CAMBIOS
        $obj_historico = new historial_cambios;
        $obj_historico -> hist_cliente     = $presupuesto->pre_cliente;
        $obj_historico -> hist_asesor  = $_SESSION['id_ase'];
        $obj_historico -> hist_comentario  = "Cambio de cita a: " . $_POST['tipo_cambio'] . " || Motivo: " . $_POST['motivo_cambio'] . " ||Día de la visita: " . date('d-m-y', strtotime($_POST['fecha_cambio']));


        $obj_historico -> hist_presupuesto = $_POST['id_cambio'];
        $obj_historico -> save();
        try {

        } catch(QueryException $e){
            //TODO controlar error
        }

        echo json_encode("Success");
    }

    public function mail(){
        $to      = 'ivanmr2332@gmail.com';
    $subject = 'the subject';
    $message = 'hello';
    $headers = 'From: webmaster@example.com';

    mail($to, $subject, $message, $headers);
    }

}
