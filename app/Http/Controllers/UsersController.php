<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Auth\Middleware\Authenticate;

use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\Clientes;
use App\Models\historico_presupuestos;
use App\Models\historial_cambios;
use App\Models\historico_gestiones;
use App\Models\Mes;
use App\Models\Presupuestos;
use App\Models\eventos;
use Carbon\Carbon;
use DateTime;

use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    function verificationLogIn(Request $request){
        $credentials = $request->all();


        $consulta = users::where ('user_mail','=',$credentials['email'])
           -> where ('user_pass','=',$credentials['password'])
           -> first();

        if ($consulta != NULL) {
            session_start();
            if ($consulta->user_name == 'ADMINISTRADOR') {
                $_SESSION['status'] = 'admin';
                $_SESSION['id_user'] = $consulta->user_id;
                $_SESSION['id_name'] = $consulta->user_name;
                $_SESSION['id_ase']  = $consulta->user_ase;
            }
            else {
                $_SESSION['status'] = 'user';
                $_SESSION['id_user'] = $consulta->user_id;
                $_SESSION['id_name'] = $consulta->user_name;
                $_SESSION['id_ase']  = $consulta->user_ase;
            }
            return view('home');
        }
        else {
            return view('login');
        }
    }

    function listaUsers(){
        $usuarios = Users::get();

        return view('admin_users',[ 'usuarios' => $usuarios ]);
    }

    function consultarUsuario($user_id, $mes = 0, $anyo = 0) {
        //TODO HACER CONSULTA CON EL USER_ID ACERCA DE REGISTROS DEL ULTIMO MES Y PASAR POR VIEW

        if($mes == 0){
            $mes = date('m');
        }
        if($anyo == 0){
            $anyo = date('Y');
        }

        //AQUI VAN LAS QUERYS PARA IR LLENANDO LOS datos

        $primera_tabla = array();

        $primera_tabla[0] = array();
        $primera_tabla[1] = array();
        $primera_tabla[2] = array();
        $primera_tabla[3] = array();

        $primera_tabla[0][0] = "LLAMADAS";
        $primera_tabla[1][0] = "VISITAS";
        $primera_tabla[2][0] = "EMAILS";
        $primera_tabla[3][0] = "REPORTES";


        //AQUI VAN LAS QUERYS PARA IR LLENANDO LOS datos

        //Tabla 1

        //Consultas auxiliares

        $array_potenciales = array();
        $array_aceptados = array();
        $q1 = clientes::select('cli_id')->where('cli_est_cli','like','%POTENCIAL%')->get();
        $q2 = clientes::select('cli_id')->where('cli_est_cli','=','ACEPTADO')->get();



        $total = historico_gestiones::where('hist_gest_asesor',$user_id)
        ->whereYear('created_at','=',$anyo)
        ->whereMonth('created_at','=',$mes)
        ->whereIn('hist_gest_tipo',['Reunion','Llamada','Email','Reporte'])
        ->get()
        ->count();


        foreach ($q1 as $value) {
            array_push($array_potenciales, $value->cli_id);
        }
        foreach ($q2 as $value) {
            array_push($array_aceptados, $value->cli_id);
        }

        //Fila de LLAMADAS
        $primera_tabla[0][1] = historico_gestiones::where('hist_gest_asesor','=',$user_id)
            ->whereYear('created_at','=',$anyo)
            ->whereMonth('created_at','=',$mes)
            ->whereIn('hist_gest_cliente',$array_potenciales)
            ->where('hist_gest_tipo','=','Llamada')
            ->get()
            ->count();
        $primera_tabla[0][2] = historico_gestiones::where('hist_gest_asesor','=',$user_id)
            ->whereYear('created_at','=',$anyo)
            ->whereMonth('created_at','=',$mes)
            ->whereIn('hist_gest_cliente',$array_aceptados)
            ->where('hist_gest_tipo','=','Llamada')
            ->get()
            ->count();
        $primera_tabla[0][3] = $primera_tabla[0][1] + $primera_tabla[0][2];
        if($total == 0){
            $primera_tabla[0][4] = 0;
        }
        else{
            $primera_tabla[0][4] = number_format($primera_tabla[0][3] / $total * 100,2);
        }
        $primera_tabla[0][4] .= "%";

        //Fila de VISITAS
        $primera_tabla[1][1] = historico_gestiones::where('hist_gest_asesor','=',$user_id)
            ->whereYear('created_at','=',$anyo)
            ->whereMonth('created_at','=',$mes)
            ->whereIn('hist_gest_cliente',$array_potenciales)
            ->where('hist_gest_tipo','=','Reunión')
            ->get()
            ->count();
        $primera_tabla[1][2] = historico_gestiones::where('hist_gest_asesor','=',$user_id)
            ->whereYear('created_at','=',$anyo)
            ->whereMonth('created_at','=',$mes)
            ->whereIn('hist_gest_cliente',$array_aceptados)
            ->where('hist_gest_tipo','=','Reunión')
            ->get()
            ->count();
        $primera_tabla[1][3] = $primera_tabla[1][1] + $primera_tabla[1][2];
        if($total == 0){
            $primera_tabla[1][4] = 0;
        }
        else{
            $primera_tabla[1][4] = number_format($primera_tabla[1][3] / $total * 100,2);
        }
        $primera_tabla[1][4] .= "%";

        //Fila de correos
        $primera_tabla[2][1] = historico_gestiones::where('hist_gest_asesor','=',$user_id)
            ->whereYear('created_at','=',$anyo)
            ->whereMonth('created_at','=',$mes)
            ->whereIn('hist_gest_cliente',$array_potenciales)
            ->where('hist_gest_tipo','=','Email')
            ->get()
            ->count();
        $primera_tabla[2][2] = historico_gestiones::where('hist_gest_asesor','=',$user_id)
            ->whereYear('created_at','=',$anyo)
            ->whereMonth('created_at','=',$mes)
            ->whereIn('hist_gest_cliente',$array_aceptados)
            ->where('hist_gest_tipo','=','Email')
            ->get()
            ->count();
        $primera_tabla[2][3] = $primera_tabla[2][1] + $primera_tabla[2][2];
        if($total == 0){
            $primera_tabla[2][4] = 0;
        }
        else{
            $primera_tabla[2][4] = number_format($primera_tabla[2][3] / $total * 100,2);
        }
        $primera_tabla[2][4] .= "%";

        //Fila de reportes
        $primera_tabla[3][1] = historico_gestiones::where('hist_gest_asesor','=',$user_id)
            ->whereYear('created_at','=',$anyo)
            ->whereMonth('created_at','=',$mes)
            ->whereIn('hist_gest_cliente',$array_potenciales)
            ->where('hist_gest_tipo','=','Reporte')
            ->get()
            ->count();
        $primera_tabla[3][2] = historico_gestiones::where('hist_gest_asesor','=',$user_id)
            ->whereYear('created_at','=',$anyo)
            ->whereMonth('created_at','=',$mes)
            ->whereIn('hist_gest_cliente',$array_aceptados)
            ->where('hist_gest_tipo','=','Reporte')
            ->get()
            ->count();
        $primera_tabla[3][3] = $primera_tabla[3][1] + $primera_tabla[3][2];
        if($total == 0){
            $primera_tabla[3][4] = 0;
        }
        else{
            $primera_tabla[3][4] = number_format($primera_tabla[3][3] / $total * 100,2);
        }
        $primera_tabla[3][4] .= "%";



        //Tabla 2

        $segunda_tabla = array();

        $segunda_tabla[0] = array();
        $segunda_tabla[1] = array();
        $segunda_tabla[2] = array();
        $segunda_tabla[3] = array();

        $segunda_tabla[0][0] = "ENVIADOS";
        $segunda_tabla[1][0] = "ACEPTADOS";
        $segunda_tabla[2][0] = "RECHAZADOS";
        $segunda_tabla[3][0] = "PENDIENTES";

        //Fila de ENVIADOS
        $segunda_tabla[0][1] = historico_presupuestos::select('hist_pres_presupuesto')
            ->distinct()
            ->where('hist_pres_estado_cliente','like','%POTENCIAL%')
            ->where('hist_pres_asesor','=',$user_id)
            ->whereYear('created_at','=',$anyo)
            ->whereMonth('created_at','=',$mes)
            ->get()
            ->count();
        $segunda_tabla[0][2] = historico_presupuestos::select('hist_pres_presupuesto')
            ->distinct()
            ->where('hist_pres_estado_cliente','=','ACEPTADO')
            ->where('hist_pres_asesor','=',$user_id)
            ->whereYear('created_at','=',$anyo)
            ->whereMonth('created_at','=',$mes)
            ->get()
            ->count();
        $segunda_tabla[0][3] = $segunda_tabla[0][1] + $segunda_tabla[0][2];
        $segunda_tabla[0][4] = "100%";

        //Fila de ACEPTADOS
        $segunda_tabla[1][1] = historico_presupuestos::where('hist_pres_estado_cliente','like','%POTENCIAL%')
                ->where('hist_pres_estado_presupuesto', '=', 'ACEPTADO')
                ->where('hist_pres_asesor','=',$user_id)
                ->whereYear('created_at','=',$anyo)
                ->whereMonth('created_at','=',$mes)
                ->get()
                ->count();
        $segunda_tabla[1][2] = historico_presupuestos::where('hist_pres_estado_cliente','=','ACEPTADO')
                ->where('hist_pres_estado_presupuesto', '=', 'ACEPTADO')
                ->where('hist_pres_asesor','=',$user_id)
                ->whereYear('created_at','=',$anyo)
                ->whereMonth('created_at','=',$mes)
                ->get()
                ->count();
        $segunda_tabla[1][3] = $segunda_tabla[1][2] + $segunda_tabla[1][1];
        if($segunda_tabla[0][3] == 0){
            $segunda_tabla[1][4] = 0;
        }
        else {
            $segunda_tabla[1][4] = number_format($segunda_tabla[1][3] / $segunda_tabla[0][3] * 100,2);
        }

        $segunda_tabla[1][4] .= "%";

        //Fila de RECHAZADOS
        $segunda_tabla[2][1] = historico_presupuestos::where('hist_pres_estado_cliente','like','%POTENCIAL%')
                ->where('hist_pres_estado_presupuesto', '=', 'RECHAZADO')
                ->where('hist_pres_asesor','=',$user_id)
                ->whereYear('created_at','=',$anyo)
                ->whereMonth('created_at','=',$mes)
                ->get()
                ->count();
        $segunda_tabla[2][2] = historico_presupuestos::where('hist_pres_estado_cliente','=','ACEPTADO')
                ->where('hist_pres_estado_presupuesto', '=', 'RECHAZADO')
                ->where('hist_pres_asesor','=',$user_id)
                ->whereYear('created_at','=',$anyo)
                ->whereMonth('created_at','=',$mes)
                ->get()
                ->count();
        $segunda_tabla[2][3] = $segunda_tabla[2][2] + $segunda_tabla[2][1];
        if ($segunda_tabla[0][3] == 0) {
            $segunda_tabla[2][4] = 0;
        }
        else{
            $segunda_tabla[2][4] = number_format($segunda_tabla[2][3] / $segunda_tabla[0][3] * 100, 2);
        }
        $segunda_tabla[2][4] .= "%";

        //Fila de PENDIENTES

        $query_aux = historico_presupuestos::select('hist_pres_presupuesto')
            ->whereIn('hist_pres_estado_presupuesto', ['ACEPTADO' , 'RECHAZADO'])
            ->get();

        $array_aux = array();

        foreach ($query_aux as $fila) {
            array_push($array_aux, $fila -> hist_pres_presupuesto);
        }

        $segunda_tabla[3][1] = $segunda_tabla[0][1] - ($segunda_tabla[2][1] + $segunda_tabla[1][1]);

        $segunda_tabla[3][1] = $segunda_tabla[0][1] - ($segunda_tabla[2][1] + $segunda_tabla[1][1]);
        $segunda_tabla[3][2] = $segunda_tabla[0][2] - ($segunda_tabla[2][2] + $segunda_tabla[1][2]);

        $segunda_tabla[3][3] = $segunda_tabla[3][2] + $segunda_tabla[3][1];
        if($segunda_tabla[0][3] == 0){
            $segunda_tabla[3][4] = 0;
        }
        else{
            $segunda_tabla[3][4] = number_format($segunda_tabla[3][3] / $segunda_tabla[0][3] * 100, 2);
        }

        $segunda_tabla[3][4] .= "%";

        $mes_num = $mes;

        $mes = mes::find($mes)->mes_nombre;

        $lista_mes = mes::get();

        $anyos = historial_cambios::select('created_at')
            ->orderBy('created_at')
            ->get();
        $lista_anyos = array();

        foreach ($anyos as $elem) {
            array_push($lista_anyos, date('Y', strtotime($elem->created_at)));
        }
        $lista_anyos = array_unique($lista_anyos);
        array_push($lista_anyos, "2021");

        //TODO preguntar si quiere que se vea el admin como seleccionable
        $usuarios = users::get();
        $usuario = users::where('user_ase','=',$user_id)->get()[0];


        return view('users_info', [ "primera_tabla" => $primera_tabla,
                                    "segunda_tabla" => $segunda_tabla,
                                    "mes"           => $mes,
                                    "lista_meses"   => $lista_mes,
                                    "lista_anyos"   => $lista_anyos,
                                    "anyo"          => $anyo,
                                    "mes_numero"    => $mes_num,
                                    "usuarios"      => $usuarios,
                                    "usuario"       => $usuario,
        ]);
    }

    function ratiosUsuario($user_id){
        $ratios1 = array();
        $ratios2 = array();
        $ratios3 = array();
        $ratios4 = array();
        $meses   = array();

        for($i = 11; $i >= 0; $i--){
            $month = idate('m') - $i;
            $year = idate('Y');

            if($month <= 0){
                $month = 12 + $month;
                $year = $year - 1;
            }

            if($month == 12){
                $date1 = Carbon::createFromFormat('Y-m-d', $year.'-'.$month.'-01');
                $year = $year + 1;
                $date2 = Carbon::createFromFormat('Y-m-d', $year.'-01-01');
                $year = $year - 1;
            } else {
                $date1 = Carbon::createFromFormat('Y-m-d', $year.'-'.$month.'-01');
                $month = $month + 1;
                $date2 = Carbon::createFromFormat('Y-m-d', $year.'-'.$month.'-01');
                $month = $month - 1;
            }


            $visitas = historico_gestiones::where('hist_gest_asesor', '=', $user_id)
                ->where('hist_gest_tipo', '=', 'Reunion')
                ->where('created_at', '<>', NULL)
                ->where('created_at', '>=', $date1)
                ->where('created_at', '<', $date2)
                ->count();

            $llamadas = historico_gestiones::whereIn('hist_gest_tipo', ['Reporte', 'Email', 'Llamada'])
                ->get();

            $llamadas = $llamadas->where('hist_gest_asesor', '=', $user_id)
                ->where('created_at', '<>', NULL)
                ->where('created_at', '>=', $date1)
                ->where('created_at', '<', $date2)
                ->count();

            $aceptados = Presupuestos::where('pre_creador', '=', $user_id)
                ->where('pre_estado', '=', 'ACEPTADO')
                ->where('updated_at', '<>', NULL)
                ->where('updated_at', '>=', $date1)
                ->where('updated_at', '<', $date2)
                ->count();

            $enviados = Presupuestos::whereIn('pre_estado', ['ACEPTADO', 'RECHAZADO', 'PRESENTADO'])
                ->get();

            $enviados = $enviados->where('pre_creador', '=', $user_id)
                ->where('updated_at', '<>', NULL)
                ->where('updated_at', '>=', $date1)
                ->where('updated_at', '<', $date2)
                ->count();

            switch ($month) {
                case '1':
                    array_push($ratios1, $visitas);
                    array_push($ratios2, $llamadas);
                    array_push($ratios3, $aceptados);
                    array_push($ratios4, $enviados);
                    array_push($meses,   'Enero');
                    break;
                case '2':
                    array_push($ratios1, $visitas);
                    array_push($ratios2, $llamadas);
                    array_push($ratios3, $aceptados);
                    array_push($ratios4, $enviados);
                    array_push($meses,   'Febrero');
                    break;
                case '3':
                    array_push($ratios1, $visitas);
                    array_push($ratios2, $llamadas);
                    array_push($ratios3, $aceptados);
                    array_push($ratios4, $enviados);
                    array_push($meses,   'Marzo');
                    break;
                case '4':
                    array_push($ratios1, $visitas);
                    array_push($ratios2, $llamadas);
                    array_push($ratios3, $aceptados);
                    array_push($ratios4, $enviados);
                    array_push($meses,   'Abril');
                    break;
                case '5':
                    array_push($ratios1, $visitas);
                    array_push($ratios2, $llamadas);
                    array_push($ratios3, $aceptados);
                    array_push($ratios4, $enviados);
                    array_push($meses,   'Mayo');
                    break;
                case '6':
                    array_push($ratios1, $visitas);
                    array_push($ratios2, $llamadas);
                    array_push($ratios3, $aceptados);
                    array_push($ratios4, $enviados);
                    array_push($meses,   'Junio');
                    break;
                case '7':
                    array_push($ratios1, $visitas);
                    array_push($ratios2, $llamadas);
                    array_push($ratios3, $aceptados);
                    array_push($ratios4, $enviados);
                    array_push($meses,   'Julio');
                    break;
                case '8':
                    array_push($ratios1, $visitas);
                    array_push($ratios2, $llamadas);
                    array_push($ratios3, $aceptados);
                    array_push($ratios4, $enviados);
                    array_push($meses,   'Agosto');
                    break;
                case '9':
                    array_push($ratios1, $visitas);
                    array_push($ratios2, $llamadas);
                    array_push($ratios3, $aceptados);
                    array_push($ratios4, $enviados);
                    array_push($meses,   'Septiembre');
                    break;
                case '10':
                    array_push($ratios1, $visitas);
                    array_push($ratios2, $llamadas);
                    array_push($ratios3, $aceptados);
                    array_push($ratios4, $enviados);
                    array_push($meses,   'Octubre');
                    break;
                case '11':
                    array_push($ratios1, $visitas);
                    array_push($ratios2, $llamadas);
                    array_push($ratios3, $aceptados);
                    array_push($ratios4, $enviados);
                    array_push($meses,   'Noviembre');
                    break;
                case '12':
                    array_push($ratios1, $visitas);
                    array_push($ratios2, $llamadas);
                    array_push($ratios3, $aceptados);
                    array_push($ratios4, $enviados);
                    array_push($meses,   'Diciembre');
                    break;
            }
        }

        //Mensual
        $esfuerzo_mes = array();
        if($llamadas != 0){
            array_push($esfuerzo_mes, array('value' => number_format( 100 * ($visitas / $llamadas)), 'label' => 'Visitas Mensuales'));
            array_push($esfuerzo_mes, array('value' => number_format( 100 - (100 * ($visitas / $llamadas))), 'label' => 'Resto Mensual'));
        } else {
            array_push($esfuerzo_mes, array('value' => 100, 'label' => 'Sin Datos'));
        }

        $efectividad_mes = array();
        if($enviados != 0){
            array_push($efectividad_mes, array('value' => number_format( 100 * ($aceptados / $enviados)), 'label' => 'Efectividad Mensual'));
            array_push($efectividad_mes, array('value' => number_format( 100 - (100 * ($aceptados / $enviados))), 'label' => 'No Aceptados'));
        } else {
            array_push($efectividad_mes, array('value' => 100, 'label' => 'Sin Datos'));
        }


        //Semanal
        $date1 = Carbon::now()->subDays(7);
        $date2 = Carbon::now();

        $visitas_semanal = historico_gestiones::where('hist_gest_asesor', '=', $user_id)
            ->where('hist_gest_tipo', '=', 'Reunion')
            ->where('created_at', '<>', NULL)
            ->where('created_at', '>=', $date1)
            ->where('created_at', '<', $date2)
            ->count();

        $llamadas_semanal = historico_gestiones::whereIn('hist_gest_tipo', ['Reporte', 'Email', 'Llamada'])
            ->get();

        $llamadas_semanal = $llamadas_semanal->where('hist_gest_asesor', '=', $user_id)
            ->where('created_at', '<>', NULL)
            ->where('created_at', '>=', $date1)
            ->where('created_at', '<', $date2)
            ->count();

        $aceptados_semanal = Presupuestos::where('pre_creador', '=', $user_id)
            ->where('pre_estado', '=', 'ACEPTADO')
            ->where('updated_at', '<>', NULL)
            ->where('updated_at', '>=', $date1)
            ->where('updated_at', '<', $date2)
            ->count();

        $enviados_semanal = Presupuestos::whereIn('pre_estado', ['ACEPTADO', 'RECHAZADO', 'PRESENTADO'])
            ->get();

        $enviados_semanal = $enviados_semanal->where('pre_creador', '=', $user_id)
            ->where('updated_at', '<>', NULL)
            ->where('updated_at', '>=', $date1)
            ->where('updated_at', '<', $date2)
            ->count();

        $esfuerzo_semanal = array();
        if($llamadas_semanal != 0){
            array_push($esfuerzo_semanal, array('value' => number_format( 100 * ($visitas_semanal / $llamadas_semanal)), 'label' => 'Visitas Semanales'));
            array_push($esfuerzo_semanal, array('value' => number_format( 100 - (100 * ($visitas_semanal / $llamadas_semanal))), 'label' => 'Resto Semanal'));
        } else {
            array_push($esfuerzo_semanal, array('value' => 100, 'label' => 'Sin Datos'));
        }

        $efectividad_semanal = array();
        if($enviados_semanal != 0){
            array_push($efectividad_semanal, array('value' => number_format( 100 * ($aceptados_semanal / $enviados_semanal)), 'label' => 'Efectividad Semanal'));
            array_push($efectividad_semanal, array('value' => number_format( 100 - (100 * ($aceptados_semanal / $enviados_semanal))), 'label' => 'No Aceptados'));
        } else {
            array_push($efectividad_semanal, array('value' => 100, 'label' => 'Sin Datos'));
        }

        $usuarios = users::get();
        $usuario = users::where('user_ase','=',$user_id)->get()[0];

        return view('users_ratio', [    'meses'                 => $meses,
                                        'ratios1'               => $ratios1,
                                        'ratios2'               => $ratios2,
                                        'ratios3'               => $ratios3,
                                        'ratios4'               => $ratios4,
                                        'esfuerzo_mes'          => $esfuerzo_mes,
                                        'esfuerzo_semanal'      => $esfuerzo_semanal,
                                        'efectividad_mes'       => $efectividad_mes,
                                        'efectividad_semanal'   => $efectividad_semanal,
                                        'usuarios'              => $usuarios,
                                        'usuario'               => $usuario
                                    ]);
    }

    function EndSession(){
        session_start();
        $_SESSION = array();
        session_destroy();
        header( "Location: /", true, 303 );
        exit();
    }

    function analisis_cartera($user_id = 0){
        session_start();

        if($user_id == 0){
            $user_id = $_SESSION['id_ase'];
        }

        $clientes_y_potenciales = array();

        $potenciales = Clientes::where('cli_est_cli','=','POTENCIAL VALIDO')
        ->where('cli_age','=',$user_id)
        ->count();
        $clientes = Clientes:: where('cli_est_cli','=','ACEPTADO')
        ->where('cli_age','=',$user_id)
        ->count();

        $total = $clientes + $potenciales;

        if($total == 0){
            array_push($clientes_y_potenciales, array('value' => 100, 'label' => 'Sin Datos'));
        }
        else{
            array_push($clientes_y_potenciales, array('value' => number_format(100*$clientes/$total), 'label' => 'Aceptados'));
            array_push($clientes_y_potenciales, array('value' => number_format(100*$potenciales/$total), 'label' => 'Potenciales'));
        }

        $array_reiteracion = array(0,0,0,0,0,0,0,0,0,0,0,0);

        $query = Presupuestos::where('pre_creador', '=', $user_id)
        ->whereIn('pre_estado', ['ACEPTADO', 'RECHAZADO'])
        ->orderBy('updated_at', 'desc')
        ->get();

        $reiteracion = $query->mapToGroups(function ($item, $key) {
            return [$item['pre_cliente'] => $item];
        });

        foreach ($reiteracion as $cliente) {
            $contador = 0;

            foreach ($cliente as $presupuesto) {
                if($presupuesto->pre_estado == 'ACEPTADO'){
                    break;
                }
                $contador++;
            }

            if($contador != 0){
                $contador--;
            }

            $array_reiteracion[$contador]++;
        }

        $array_dilacion = array(0,0,0,0,0,0,0,0,0,0,0,0);

        $clientes = clientes::where('cli_age', '=', $user_id)
        ->with('historial_cambios')
        ->get();

        foreach ($clientes as $cliente) {

            $flag_auto = true;
            $fecha_mayor = '01/01/1800';

            foreach($cliente->historial_cambios as $fila){
                if($fila -> hist_auto == 0){
                    if($fecha_mayor < $fila->updated_at){
                        $fecha_mayor = $fila->updated_at;
                    }
                }
            }

            if($fecha_mayor == "01/01/1800"){
                $array_dilacion[0] ++;
            }
            else{
                $year1 = date('Y', strtotime(date($fecha_mayor)));
                $year2 = date('Y', strtotime(date('d-m-Y h:i:s')));

                $month1 = date('m', strtotime(date($fecha_mayor)));
                $month2 = date('m', strtotime(date('d-m-Y h:i:s')));

                $diff = ((($year2 - $year1) * 12) + ($month2 - $month1)) ;

                if($diff >= 12)
                    $diff = 0;

                if($diff != 0){
                    $diff--;
                }

                $array_dilacion[$diff]++;
            }
        }

        $array_contratacion = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach ($clientes as $cliente) {

            $flag_auto = true;
            $fecha_mayor = '01/01/1800';

            foreach($cliente->historial_cambios as $fila){
                if(str_contains($fila -> hist_comentario, "Aceptado el Presupuesto")){
                    if($fecha_mayor < $fila->updated_at){
                        $fecha_mayor = $fila->updated_at;
                    }
                }
            }

            if($fecha_mayor == "01/01/1800"){
                $array_contratacion[0] ++;
            }
            else{
                $year1 = date('Y', strtotime(date($fecha_mayor)));
                $year2 = date('Y', strtotime(date('d-m-Y h:i:s')));

                $month1 = date('m', strtotime(date($fecha_mayor)));
                $month2 = date('m', strtotime(date('d-m-Y h:i:s')));

                $diff = ((($year2 - $year1) * 12) + ($month2 - $month1)) ;

                if($diff >= 12)
                    $diff = 0;

                if($diff != 0){
                    $diff--;
                }
                $array_contratacion[$diff]++;
            }
        }

        $array_agenda = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $array_agenda_clientes = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        $array_agenda_potenciales = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];

        $potenciales = clientes::select('cli_id')
            ->where('cli_est_cli','LIKE','%POTENCIAL%')
            ->get();
        $potenciales_id = array();
        foreach ($potenciales as $key => $value) {
            array_push($potenciales_id, $value -> cli_id);
        }

        $aceptados = clientes::select('cli_id')
            ->where('cli_est_cli','ACEPTADO')
            ->get();
        $aceptados_id = array();
        foreach ($aceptados as $key => $value) {
            array_push($aceptados_id, $value -> cli_id);
        }


        $eventos = eventos::where('eve_asesor', $user_id)
            ->get();

        foreach($eventos as $evento){
            $start = new DateTime(date("y-m-d"));
            $end = new DateTime($evento->eve_fecha);
            $diff = $start->diff($end);

            $yearsInMonths = $diff->format('%r%y') * 12;
            $months = $diff->format('%r%m');
            $totalMonths = $yearsInMonths + $months;

            if( $totalMonths < -12 ){
                $array_agenda[0]++;
            }
            else if( $totalMonths > 12 ){
                $array_agenda[24]++;
            }
            else{
                $array_agenda[12 + $totalMonths]++;
            }
            $total ++;

        }


        $eventos_pot = eventos::where('eve_asesor', $user_id)
            ->whereIn('eve_cliente',$potenciales_id)
            ->get();

        foreach($eventos_pot as $evento){
            $start = new DateTime(date("y-m-d"));
            $end = new DateTime($evento->eve_fecha);
            $diff = $start->diff($end);

            $yearsInMonths = $diff->format('%r%y') * 12;
            $months = $diff->format('%r%m');
            $totalMonths = $yearsInMonths + $months;

            if( $totalMonths < -12 ){
                $array_agenda_potenciales[0]++;
            }
            else if( $totalMonths > 12 ){
                $array_agenda_potenciales[24]++;
            }
            else{
                $array_agenda_potenciales[12 + $totalMonths]++;
            }
            $total ++;

        }

        $eventos_cli = eventos::where('eve_asesor', $user_id)
            ->whereIn('eve_cliente',$aceptados_id)
            ->get();

        $total = 0;

        foreach($eventos_cli as $evento){
            $start = new DateTime(date("y-m-d"));
            $end = new DateTime($evento->eve_fecha);
            $diff = $start->diff($end);

            $yearsInMonths = $diff->format('%r%y') * 12;
            $months = $diff->format('%r%m');
            $totalMonths = $yearsInMonths + $months;

            if( $totalMonths < -12 ){
                $array_agenda_clientes[0]++;
            }
            else if( $totalMonths > 12 ){
                $array_agenda_clientes[24]++;
            }
            else{
                $array_agenda_clientes[12 + $totalMonths]++;
            }
            $total ++;

        }



        return view('analisis_cartera', ['donut1' => $clientes_y_potenciales, 'tabla1' => $array_reiteracion, 'tabla2' => $array_dilacion, 'tabla3' => $array_contratacion, 'array_agenda' => $array_agenda, 'array_potenciales' => $array_agenda_potenciales, 'array_clientes' => $array_agenda_clientes]);

    }
}
