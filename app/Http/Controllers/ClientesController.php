<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\Asesores;
use App\Models\Presupuestos;
use App\Models\historial_cambios;
use App\Models\metodos_pago;
use App\Models\Users;
use App\Models\historico_gestiones;
use App\Models\eventos;
use Carbon\Carbon;

class ClientesController extends Controller
{
    public function insertCliente($cliente){
        $obj_clientes = new Clientes;

        $agentes = Asesores::get();
        $aux = 0;
        for($i = 0; $i < count($agentes); $i++){
            if(str_contains(strtoupper($agentes[$i]->ase_nombre), strtoupper($cliente[3]))){
                $aux = $agentes[$i]->ase_id;
            }
        }

        //$obj_clientes -> cli_id         = $cliente[0];
        $obj_clientes -> cli_nom        = str_replace(array('´', '`'),array("'", "'"),$cliente[1]);
        $obj_clientes -> cli_cif        = $cliente[2];
        $obj_clientes -> cli_age        = $aux;
        $obj_clientes -> cli_anu        = str_replace(array('´', '`'),array("'", "'"),$cliente[4]);
        $obj_clientes -> cli_dir        = $cliente[5];
        $obj_clientes -> cli_loc        = $cliente[6];
        $obj_clientes -> cli_cp         = $cliente[7];
        $obj_clientes -> cli_pro        = $cliente[8];
        $obj_clientes -> cli_tel1       = $cliente[9];
        $obj_clientes -> cli_fax        = $cliente[10];
        $obj_clientes -> cli_mail1      = $cliente[11];
        $obj_clientes -> cli_iban       = $cliente[13];
        $obj_clientes -> cli_cont_nom   = str_replace(array('´', '`'),array("'", "'"),$cliente[14]);
        $obj_clientes -> cli_cont_tel   = $cliente[15];
        $obj_clientes -> cli_cont_mail  = $cliente[16];
        $obj_clientes -> cli_pot_publi  = $cliente[17];
        $obj_clientes -> cli_pot_radio  = $cliente[18];
        $obj_clientes -> cli_est_dat    = $cliente[19];
        $obj_clientes -> cli_est_cli    = "ACEPTADO";

        $metodopago = metodos_pago::where('met_pago_orig', '=', $cliente[12])
            ->get();
        if(isset($metodopago[0])){
            $obj_clientes -> cli_met_pago   = $metodopago[0]->met_pago_id;
        }


        try{
            $obj_clientes -> save();
        }
        catch(QueryException $e){
          $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){

            }
        }

    }

    public function listaClientes(){
        session_start();

        if ($_SESSION['status'] == 'admin') {
            $clientes = Clientes::where('cli_est_cli', '=', 'ACEPTADO')
                ->with('asesores')
                ->get();

            $numclientes = Clientes::where('cli_est_cli', '=', 'ACEPTADO')
                ->with('asesores')
                ->get()
                ->count();
        } else {
            $clientes = Clientes::where('cli_est_cli', '=', 'ACEPTADO')
                ->where('cli_age', '=', $_SESSION['id_ase'])
                ->with('asesores')
                ->get();
            $numclientes = Clientes::where('cli_est_cli', '=', 'ACEPTADO')
                ->where('cli_age', '=', $_SESSION['id_ase'])
                ->with('asesores')
                ->get()
                ->count();
        }

        $acciones = Presupuestos::where('pre_estado','=','PREDEFINIDO')
            ->get();

        $localidades = Clientes::select('cli_loc')
            ->where('cli_loc', '<>', '')
            ->distinct()
            ->orderBy('cli_loc')
            ->get();



        return view('clientes_tabla', ['clientes' => $clientes, 'acciones' => $acciones, 'localidades' => $localidades, 'numclientes' => $numclientes]);
    }

    public function listaPotenciales(){
        if(!isset($_SESSION)){
            session_start();
        }

        if ($_SESSION['status'] == 'admin') {
            $clientes = Clientes::whereIn('cli_est_cli', ['POTENCIAL VALIDO', 'POTENCIAL INVALIDO'])
                ->with('asesores')
                ->get();

            $numclientes = Clientes::whereIn('cli_est_cli', ['POTENCIAL VALIDO', 'POTENCIAL INVALIDO'])
                ->with('asesores')
                ->get()
                ->count();


        } else {
            $clientes = Clientes::whereIn('cli_est_cli', ['POTENCIAL VALIDO', 'POTENCIAL INVALIDO'])
                ->where('cli_age', '=', $_SESSION['id_ase'])
                ->with('asesores')
                ->get();

            $numclientes = Clientes::whereIn('cli_est_cli', ['POTENCIAL VALIDO', 'POTENCIAL INVALIDO'])
                ->where('cli_age', '=', $_SESSION['id_ase'])
                ->with('asesores')
                ->get()
                ->count();

        }
        return view('potenciales_tabla', ['clientes' => $clientes, 'numclientes' => $numclientes]);
    }

    public function consultarCliente($cli_id){
        if(!isset($_SESSION)){
            session_start();
        }

        $cliente = Clientes::with('metodos_pago')
            ->with('asesores')
            ->find($cli_id);
        $acciones = Presupuestos::where('pre_estado','=','PREDEFINIDO')
            ->count();
        $historial = historial_cambios::where('hist_cliente','=',$cli_id)
            ->where('hist_asesor','=',$_SESSION['id_ase'])
            ->orderBy('created_at', 'desc')
            ->get();

        $presupuesto_vigente = Presupuestos::where('pre_estado','PRESENTADO')
            ->where('pre_cliente', $cli_id)
            ->get();

        $ver_links = true;

        if(isset($presupuesto_vigente[0])){
            $ver_links = false;
        }

        $met_pago = metodos_pago::get();

        return view('clientes_ficha', ['cliente' => $cliente, 'acciones' => $acciones, 'historial' => $historial, 'metodos_pago' => $met_pago, 'links' => $ver_links]);
    }

    public function buzonClientes(){
        if(!isset($_SESSION)){
            session_start();
        }

        $clientes = Clientes::where('cli_est_cli', '=', 'PENDIENTE')
            ->orwhere('cli_est_cli', '=', 'POTENCIAL INVALIDO')
            ->with('asesores')
            ->get();

        $clientes2 = Clientes::where('cli_est_cli', '=', 'VALIDADO')
            ->with('asesores')
            ->get();

        if($_SESSION['status'] != 'admin'){
            $clientes   =$clientes->where('cli_age', '=', $_SESSION['id_ase']);
            $clientes2  =$clientes2->where('cli_age', '=', $_SESSION['id_ase']);
        }

        return view('clientes_buzon', ['validacion' => $clientes, 'agendar' => $clientes2]);
    }

    public function modificarCliente(Request $request){
        $cliente = Clientes::find($request['idCliente']);

        $cliente -> cli_nom        = $request['cli_nom'];
        $cliente -> cli_cif        = $request['cli_cif'];
        $cliente -> cli_anu        = $request['cli_anu'];
        $cliente -> cli_dir        = $request['cli_dir'];
        $cliente -> cli_loc        = $request['cli_loc'];
        $cliente -> cli_cp         = $request['cli_cp'];
        $cliente -> cli_pro        = $request['cli_pro'];
        $cliente -> cli_tel1       = $request['cli_tel1'];
        $cliente -> cli_fax        = $request['cli_fax'];
        $cliente -> cli_mail1      = $request['cli_mail1'];
        $cliente -> cli_tel2       = $request['cli_tel2'];
        $cliente -> cli_mail2      = $request['cli_mail2'];

        $met_pago = metodos_pago::where('met_pago_desc', '=', $request['cli_pago'])
            ->get();

        $cliente -> cli_met_pago   = $met_pago[0]->met_pago_id;
        $cliente -> cli_iban       = $request['cli_iban'];
        $cliente -> cli_cont_nom   = $request['cli_cont_nom'];
        $cliente -> cli_cont_tel   = $request['cli_cont_tel'];
        $cliente -> cli_cont_mail  = $request['cli_cont_mail'];
        $cliente -> save();
        try {

        } catch (\Exception $e) {
            dd("Se ha producido un error");
        }

        return $this->consultarCliente($request['idCliente']);

    }

    public function crearCliente(Request $request){
        if(!isset($_SESSION)){
            session_start();
        }

        $cliente = new Clientes;

        $cliente -> cli_age        = $_SESSION['id_ase'];
        $cliente -> cli_anu        = $request['cli_anu'];
        $cliente -> cli_dir        = $request['cli_dir'];
        $cliente -> cli_loc        = $request['cli_loc'];
        $cliente -> cli_tel1       = str_replace(' ', '', $request['cli_tel1']);
        $cliente -> cli_mail1      = $request['cli_mail1'];
        $cliente -> cli_cont_nom   = $request['cli_cont_nom'];
        $cliente -> cli_est_cli    = "PENDIENTE";
        $cliente -> save();
        try {

        } catch (\Exception $e) {
            dd("Se ha producido un error");
        }

        $obj_historico = new historial_cambios;
        $obj_historico -> hist_cliente     = $cliente->cli_id;
        $obj_historico -> hist_asesor  = $_SESSION['id_ase'];
        $obj_historico -> hist_comentario  = "Creación del cliente " . $request['cli_anu'];
        $obj_historico -> save();
        try {

        } catch(QueryException $e){
            //TODO controlar error
        }

        header( "Location: clientes_buzon", true, 303 );
        exit();

    }

    public function validacionComercial(Request $request){
        if(!isset($_SESSION)){
            session_start();
        }

        Clientes::where('cli_id', '=', $_POST['cli_id'])
            ->update(['cli_est_cli' => 'VALIDADO']);

        $cli = Clientes::find($_POST['cli_id']);
        $anu = $cli->cli_anu;
        $obj_historico = new historial_cambios;
        $obj_historico -> hist_cliente     = $_POST['cli_id'];
        $obj_historico -> hist_asesor  = $_SESSION['id_ase'];
        $obj_historico -> hist_comentario  = "Validación Comercial del cliente " . $anu . " - Pendiente de Validación Administrativa";
        $obj_historico -> save();
        try {

        } catch(QueryException $e){
            //TODO controlar error
        }

        header( "Location: clientes_buzon", true, 303 );
        exit();
    }

    public function validacionAdmin(Request $request){
        if(!isset($_SESSION)){
            session_start();
        }

        $cli = Clientes::find($_POST['cli_id']);

        if($cli->cli_met_pago != NULL && $cli->cli_iban != NULL) {
            Clientes::where('cli_id', '=', $_POST['cli_id'])
                ->update(['cli_est_cli' => 'POTENCIAL VALIDO']);

            $anu = $cli->cli_anu;
            $obj_historico = new historial_cambios;
            $obj_historico -> hist_cliente     = $_POST['cli_id'];
            $obj_historico -> hist_asesor  = $_SESSION['id_ase'];
            $obj_historico -> hist_comentario  = "Validación Administrativa del cliente " . $anu . " - Se pueden aceptar presupuestos.";
            $obj_historico -> save();
            try {

            } catch(QueryException $e){
                //TODO controlar error
            }

            header( "Location: clientes_buzon", true, 303 );
            exit();
        } else {
            $cliente = Clientes::with('metodos_pago')
                ->find($_POST['cli_id']);
            $acciones = Presupuestos::where('pre_estado','=','PREDEFINIDO')
                ->count();
            $historial = historial_cambios::where('hist_cliente','=',$_POST['cli_id'])
                ->where('hist_asesor','=',$_SESSION['id_ase'])
                ->orderBy('created_at', 'desc')
                ->get();
            $val_admin = false;
            $met_pago = metodos_pago::get();

            return view('clientes_ficha', ['cliente' => $cliente, 'acciones' => $acciones, 'historial' => $historial, 'val_admin' => $val_admin, 'metodos_pago' => $met_pago]);
        }

        header( "Location: clientes_buzon", true, 303 );
        exit();
    }

    public function agendarCliente(Request $request){
        if(!isset($_SESSION)){
            session_start();
        }
        //dd($_POST);
        if (isset($_POST['cartera'])) {
            Clientes::where('cli_id', '=', $_POST['cli_id'])
                ->update(['cli_est_cli' => 'ACEPTADO', 'cli_age' => $_SESSION['id_ase'], 'cli_dateprox' => $_POST['fecha_agenda'], 'cli_tipo_reunion' => $_POST['tipo_visita']]);
        } else {
            Clientes::where('cli_id', '=', $_POST['cli_id'])
                ->update(['cli_est_cli' => 'POTENCIAL INVALIDO', 'cli_age' => $_SESSION['id_ase'], 'cli_dateprox' => $_POST['fecha_agenda'], 'cli_tipo_reunion' => $_POST['tipo_visita']]);
        }


        $cli = Clientes::find($_POST['cli_id']);

        $evento = new eventos;
        $evento -> eve_fecha = $_POST['fecha_agenda'];
        $evento -> eve_tipo = $_POST['tipo_visita'];
        $evento -> eve_cliente = $_POST['cli_id'];
        $evento -> eve_asesor = $_SESSION['id_ase'];
        $evento -> save();

        $obj_historico = new historial_cambios;
        $obj_historico -> hist_cliente     = $_POST['cli_id'];
        $obj_historico -> hist_asesor  = $_SESSION['id_ase'];
        $obj_historico -> hist_comentario  = "Se ha Agendado el cliente " . $cli->cli_anu . " - Asesor: " . $_SESSION['id_name'];
        $obj_historico -> save();
        try {

        } catch(QueryException $e){
            //TODO controlar error
        }
        if (isset($_POST['cartera'])) {
            header( "Location: clientes_tabla", true, 303 );
        } else {
            header( "Location: potenciales_tabla", true, 303 );
        }

        exit();
    }

    public function rechazarCliente(Request $request){
        if(!isset($_SESSION)){
            session_start();
        }

        Clientes::where('cli_id', '=', $_POST['cli_id'])
            ->update(['cli_est_cli' => 'RECHAZADO']);

        $cli = Clientes::find($_POST['cli_id']);

        $obj_historico = new historial_cambios;
        $obj_historico -> hist_cliente     = $_POST['cli_id'];
        $obj_historico -> hist_asesor  = $_SESSION['id_ase'];
        $obj_historico -> hist_comentario  = "Se ha Rechazado el cliente " . $cli->cli_anu . " - Asesor: " . $_SESSION['id_name'];
        $obj_historico -> save();
        try {

        } catch(QueryException $e){
            //TODO controlar error
        }

        header( "Location: clientes_buzon", true, 303 );
        exit();
    }

    public function bajasClientes(){
        if(!isset($_SESSION)){
            session_start();
        }

        $casos = ["ACEPTADO","POTENCIAL VALIDO", "POTENCIAL INVALIDO"];

        if ($_SESSION['status'] == 'user') {
            $clientes = Clientes::whereIn('cli_est_cli', $casos)
                ->with('asesores')
                ->get();

            $clientes = $clientes->where('cli_age', '=', $_SESSION['id_ase']);
        } else {
            $clientes = Clientes::where('cli_est_cli', '=', 'BAJA PENDIENTE')
                ->with('asesores')
                ->get();
        }

        return view('clientes_bajas', ['clientes' => $clientes, 'tabla' => $clientes]);
    }

    public function darBajaCliente($cli_id){
        Clientes::where('cli_id', '=', $cli_id)
            ->update(['cli_est_cli' => 'BAJA']);

        return $this->bajasClientes();
    }

    public function solBajaCliente($cli_id){
        Clientes::where('cli_id', '=', $cli_id)
            ->update(['cli_est_cli' => 'BAJA PENDIENTE']);

        return $this->bajasClientes();
    }

    public function recBajaCliente($cli_id){
        Clientes::where('cli_id', '=', $cli_id)
            ->update(['cli_est_cli' => 'ACEPTADO']);

        return $this->bajasClientes();
    }
    public function filtrarBajas(){
        session_start();


        $casos = ["ACEPTADO","POTENCIAL VALIDO", "POTENCIAL INVALIDO"];
        $tabla = Clientes::whereIn('cli_est_cli', $casos)
            ->with('asesores')
            ->get();
        $tabla = $tabla->where('cli_age', '=', $_SESSION['id_ase']);


        $cliente = Clientes::where('cli_anu', '=', $_POST['cliente_buscador'])
            ->get();



        return view('clientes_bajas', ['clientes' => $cliente, 'tabla' => $tabla]);
    }

    public function crearPresupuesto($cli_id){

        $objpresupuesto = new PresupuestosController;

        return $objpresupuesto->CrearPresupuesto_DesdeCero($cli_id);
    }

    public function CrearPresupuestoAcc($cli_id){

        $objpresupuesto = new PresupuestosController;

        return $objpresupuesto->Elegir_Acc($cli_id);
    }

    public function carteraClientes(){
        session_start();

        if ($_SESSION['status'] == 'admin') {
            $clientes = Clientes::where('cli_est_cli', '=', 'ACEPTADO')
                ->orwhere('cli_est_cli', '=', 'CARTERIZADO')
                ->with('asesores')
                ->get();
        } else {
            $clientes = Clientes::where('cli_est_cli', '=', 'CARTERIZADO')
                ->where('cli_age', '=', $_SESSION['id_ase'])
                ->with('asesores')
                ->get();
        }

        $agentes = Asesores::get();

        return view('clientes_cartera', ['clientes' => $clientes, 'agentes' => $agentes]);
    }

    public function carterizarCliente(Request $request){
        Clientes::where('cli_id', '=', $_POST['cli_id'])
            ->update(['cli_age' => $_POST['cartera'], 'cli_est_cli' => 'CARTERIZADO']);

            header( "Location: clientes_cartera", true, 303 );
            exit();

    }

    public function verCliente($nombre){
        $cliente = clientes::where('cli_nom', '=', $nombre)
            ->get();

        return $this->consultarCliente($cliente[0]->cli_id);
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
                $consulta = eventos::with('clientes')
                    ->where('eve_asesor','=',$usuario->user_ase)
                    ->where('eve_fecha', '>=', date('Y-m-d'))
                    ->get();

                $eventos = array();
                $contador = 0;
                foreach ($consulta as $evento) {
                    if($evento->clientes->cli_est_cli != "BAJA PENDIENTE"){
                        $eventos[$contador] = array();

                        $eventos[$contador]['start'] = $evento->eve_fecha;
                        $eventos[$contador]['end']   = $evento->eve_fecha;
                        $eventos[$contador]['id']= $evento->eve_id;

                        switch ($evento->eve_tipo) {
                            case "Llamada":
                                $eventos[$contador]['title'] = "☏ - " . $evento->clientes->cli_anu;
                                break;
                            case "Reunion":
                                $eventos[$contador]['title'] = "🏠 - " . $evento->clientes->cli_anu;
                                break;
                            case "Email":
                                $eventos[$contador]['title'] = "✉ - " . $evento->clientes->cli_anu;
                                break;
                        }

                        switch ($evento->eve_presupuesto) {
                            case NULL:
                                $eventos[$contador]['url']   = url('clientes_ficha/' . $evento->clientes->cli_id);
                                $eventos[$contador]['backgroundColor'] = '#107a39';
                                break;

                            default:
                                $eventos[$contador]['url']   = url('buzon_presupuesto');
                                $eventos[$contador]['backgroundColor'] = '#103e7a';
                                break;
                        }

                        $contador ++;
                    }

                }

                array_push($array_final, $eventos);
            }

            $interes = presupuestos::where('pre_estado','=','ACEPTADO')
                ->with('clientes')
                ->orderBy('pre_datefin','asc')
                ->take(10)
                ->get();

            foreach ($interes as $inte) {
                $date=date_create($inte -> pre_datefin);
                $inte -> pre_datefin = date_format($date,"d/m/Y");
            }

            return view('agenda', ['contador'=>$cont, 'array_eventos'=>$array_final, 'intereses' => $interes]);
        } else {
            $consulta = eventos::with('clientes')
                ->where('eve_asesor','=',$_SESSION['id_ase'])
                ->get();

            $eventos = array();
            $contador = 0;

            foreach ($consulta as $evento) {
                if($evento->clientes->cli_est_cli != "BAJA PENDIENTE"){
                    $eventos[$contador] = array();

                    $eventos[$contador]['start'] = $evento->eve_fecha;
                    $eventos[$contador]['end']   = $evento->eve_fecha;
                    $eventos[$contador]['id']    = $evento->eve_id;

                    switch ($evento->eve_tipo) {
                        case "Llamada":
                            $eventos[$contador]['title'] = "☏ - " . $evento->clientes->cli_anu;
                            break;
                        case "Reunion":
                            $eventos[$contador]['title'] = "🏠 - " . $evento->clientes->cli_anu;
                            break;
                        case "Email":
                            $eventos[$contador]['title'] = "✉ - " . $evento->clientes->cli_anu;
                            break;
                    }

                    switch ($evento->eve_presupuesto) {
                        case NULL:
                            $eventos[$contador]['url']   = url('clientes_ficha/' . $evento->clientes->cli_id);
                            $eventos[$contador]['backgroundColor'] = '#107a39';
                            break;

                        default:
                            $eventos[$contador]['url']   = url('buzon_presupuesto');
                            $eventos[$contador]['backgroundColor'] = '#103e7a';
                            break;
                    }

                    $contador ++;
                }
            }

            $interes = presupuestos::where('pre_creador','=',$_SESSION['id_ase'])
                ->where('pre_estado','=','ACEPTADO')
                ->with('clientes')
                ->orderBy('pre_datefin','asc')
                ->take(10)
                ->get();

            $pasados = $consulta = eventos::where('eve_asesor','=',$_SESSION['id_ase'])
                ->where('eve_fecha', "<=", Carbon::now()->subDays(7)->toDateTimeString())
                ->get()
                ->count();

                foreach ($interes as $inte) {
                    $date=date_create($inte -> pre_datefin);
                    $inte -> pre_datefin = date_format($date,"d/m/Y");
                }


            return view('agenda', ['contador'=>null,'array_eventos'=>$eventos, 'intereses'=>$interes, 'pasados' => $pasados]);
        }


    }

    public function cambioEvento(){
        session_start();
        header("Content-Type: application/json");

        $evento = eventos::find($_POST['id_cambio']);


        $registro = new historico_gestiones;
        $registro -> hist_gest_cliente = $evento -> eve_cliente;
        $registro -> hist_gest_asesor  = $_SESSION['id_ase'];
        $registro -> hist_gest_tipo    = $evento -> eve_tipo;
        $registro -> save();


        $evento -> eve_fecha = $_POST['fecha_cambio'];
        $evento -> eve_tipo = $_POST['tipo_cambio'];

        try {
            $evento->save();
        } catch (\Exception $e) {
            echo json_encode("Error");
        }

        //AÑADIR CAMBIO AL HISTORIAL DE CAMBIOS
        $obj_historico = new historial_cambios;
        $obj_historico -> hist_cliente     = $evento->eve_cliente;
        $obj_historico -> hist_asesor  = $_SESSION['id_ase'];
        $obj_historico -> hist_comentario  = "Cambio de cita a: " . $_POST['tipo_cambio'] . " || Motivo: " . $_POST['motivo_cambio'] . " ||Día de la cita: " . date('d-m-y', strtotime($_POST['fecha_cambio'])) ;

        $obj_historico -> save();
        try {

        } catch(QueryException $e){
            //TODO controlar error
        }

        echo json_encode("Success");
    }


    public function addRegistro(Request $request){
        if(!isset($_SESSION)){
            session_start();
        }

        $registro = new historico_gestiones;
        $registro -> hist_gest_cliente = $_POST['cli_id'];
        $registro -> hist_gest_asesor  = $_SESSION['id_ase'];
        $registro -> hist_gest_tipo    = "Reporte";
        $registro -> save();


        $obj_historico = new historial_cambios;
        $obj_historico -> hist_cliente     = $_POST['cli_id'];
        $obj_historico -> hist_asesor  = $_SESSION['id_ase'];
        $obj_historico -> hist_comentario  = $_POST['text_registro'];
        $obj_historico -> hist_auto = false;
        $obj_historico -> save();
        try {

        } catch(QueryException $e){
            //TODO controlar error
        }



        header( "Location: clientes_ficha/" . $_POST['cli_id'], true, 303 );
        exit();
    }

    public function filtrarClientes(Request $request){
        session_start();

        if($_POST['cliente_buscador'] == NULL || $_POST['cliente_buscador'] == '') {

            if ($_SESSION['status'] == 'admin') {
                $clientes = Clientes::where('cli_est_cli', '=', 'ACEPTADO')
                    ->with('asesores')
                    ->with('presupuestos');
            } else {
                $clientes = Clientes::where('cli_est_cli', '=', 'ACEPTADO')
                    ->where('cli_age', '=', $_SESSION['id_ase'])
                    ->with('asesores')
                    ->with('presupuestos');
            }

        } else {

            if ($_SESSION['status'] == 'admin') {
                $clientes = Clientes::where('cli_est_cli', '=', 'ACEPTADO')
                    ->where('cli_anu', 'like', '%' . $_POST['cliente_buscador'] . '%')
                    ->with('asesores')
                    ->with('presupuestos');
            } else {
                $clientes = Clientes::where('cli_est_cli', '=', 'ACEPTADO')
                    ->where('cli_age', '=', $_SESSION['id_ase'])
                    ->where('cli_anu', 'like', '%' . $_POST['cliente_buscador'] . '%')
                    ->with('asesores')
                    ->with('presupuestos');
            }

        }

        if($_POST['iniFecha'] != ''){
                $clientes = $clientes->whereHas('presupuestos', function ($query) {
                    $query->where('created_at', '>', $_POST['iniFecha']);
                });
        }
        if($_POST['finFecha'] != ''){
                $clientes = $clientes->whereHas('presupuestos', function ($query) {
                    $query->where('created_at', '<', $_POST['finFecha']);
                });
        }
        if($_POST['periodo'] != ''){

        }
        if($_POST['ha_contratado'] != ''){
                $clientes = $clientes->whereHas('presupuestos', function ($query) {
                    $query->where('pre_estado', '=', $_POST['ha_contratado']);
                });
        }
        if($_POST['acc_com'] != ''){
                if($_POST['acc_com'] == 'c_general'){
                    $clientes = $clientes->whereHas('presupuestos', function ($query) {
                        $query->where('pre_acc_com', '=', NULL);
                    });
                }else{
                    $clientes = $clientes->whereHas('presupuestos', function ($query) {
                        $query->where('pre_acc_com', '=', $_POST['acc_com']);
                    });
                }
        }
        if($_POST['campanya'] != ''){

        }
        if($_POST['localidad'] != ''){
                $clientes = $clientes->where('cli_loc', '=', $_POST['localidad']);
        }
        if($_POST['sector'] != ''){

        }
        if($_POST['no_contrato'] != ''){
                $clientes = $clientes->whereHas('presupuestos', function ($query) {
                    $query->where('pre_motivo_rechazo', '=', $_POST['no_contrato']);
                });
        }
        $clientes = $clientes->get();

        $acciones = Presupuestos::where('pre_estado','=','PREDEFINIDO')
            ->get();

        $localidades = Clientes::select('cli_loc')
            ->where('cli_loc', '<>', '')
            ->distinct()
            ->orderBy('cli_loc')
            ->get();

        return view('clientes_tabla', ['clientes' => $clientes, 'array' => $_POST, 'acciones' => $acciones, 'localidades' => $localidades]);
    }

    public function datos_clientes(Request $request){

        session_start();
        $datos = NULL ;
        if ($_SESSION['status'] == 'admin') {
            $datos = clientes::select('cli_anu','cli_id')
            ->get();
        }
        else{
            $datos = clientes::select('cli_anu','cli_id')
            ->where('cli_age','=',$_SESSION['id_ase'])
            ->get();
        }

        header("Content-Type: application/json");
        echo json_encode($datos);
    }

    function datosDonut(){
        session_start();
        $inicio = $_POST['fecha_inicio'];
        $fin = $_POST['fecha_fin'];

        if($inicio == ""){
            $inicio = "2000-01-01";
        }
        if($fin == ""){
            $fin = "9999-01-01";
        }
        if($inicio > $fin){
            echo json_encode("Error");
            return;
        }

        $aceptados = Presupuestos::select('pre_cliente')
            ->where('pre_creador','=',$_SESSION['id_ase'])
            ->where('updated_at', '>=', $inicio)
            ->where('updated_at', '<=', $fin)
            ->where('pre_estado',  '=', 'ACEPTADO')
            ->distinct()
            ->get()
            ->count();

        $rechazados = Presupuestos::select('pre_cliente')
            ->where('pre_creador','=',$_SESSION['id_ase'])
            ->where('updated_at', '>=', $inicio)
            ->where('updated_at', '<=', $fin)
            ->where('pre_estado',  '=', 'RECHAZADO')
            ->distinct()
            ->get()
            ->count();


        $totales = $aceptados + $rechazados;

        $resultados = array();

        if($totales == 0){
            array_push($resultados, array('value' => 100, 'label' => 'Sin Datos'));
        }
        else{
            array_push($resultados, array('value' => number_format($aceptados), 'label' => 'Aceptados'));
            array_push($resultados, array('value' => number_format($rechazados), 'label' => 'Rechazados'));
        }

        echo json_encode($resultados);
    }

    public function traspasarCliente(){

        $cli = clientes::find($_POST['cliente_target']);

        $cli -> cli_age = $_POST['nuevo_asesor'];
        $cli -> save();

        header( "Location: clientes_cartera", true, 303 );
        exit();
    }
}
