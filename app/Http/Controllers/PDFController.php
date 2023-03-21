<?php

namespace App\Http\Controllers;

use App\Models\Presupuestos;
use App\Models\linea_presupuesto;
use App\Models\Tarifas_Presupuesto;
use App\Models\Duracion_presupuesto;
use App\Models\Precios_Presupuesto;
use App\Models\Optico_fila;
use App\Models\historial_cambios;
use App\Models\historico_presupuestos;
use App\Models\eventos;

use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function intermedio(){
        $id_presupuesto = $_POST['pre_id'];
        if($_POST['fecha_pdf'] != NULL){
            $fecha = $_POST['fecha_pdf'];
        } else {
            $fecha = "2000-01-01";
        }

        if($_POST['tipo_visita'] != NULL){
            $tipo = $_POST['tipo_visita'];
        } else {
            $tipo = "default";
        }


        return view('DescargaPDF',[ 'id' => $id_presupuesto, 'fecha' => $fecha, 'tipo' => $tipo]);
    }

    public function intermedioID($pre_id){
        $fecha = presupuestos::find($pre_id) -> pre_dateprox;

        return view('DescargaPDF',[ 'id' => $pre_id, 'fecha' => $fecha, 'no_presentar' => 'si', 'tipo' => 'default']);
    }

    public function generarPDF(){

        $contador = 0;
        $contador2 = 0;
        $informacion = array();

        $id_presupuesto = $_POST['pre_id'];

        $accion_id = presupuestos::find($id_presupuesto)->pre_acc_com;



        $presupuesto = presupuestos::with('sociedades')
            ->with('asesores')
            ->with('clientes')
            ->find($id_presupuesto);

        $sociedad  = presupuestos::with('sociedades')
                        ->find($id_presupuesto);


        $eve = NULL;
        try {
            $eve = eventos::where('eve_cliente', '=', $presupuesto -> pre_cliente)
                    ->get()[0];
        } catch (\Exception $e) {

        }


        if($_POST['fecha_pdf'] == '2000-01-01'){
            $fecha = $eve -> eve_fecha;
            $tipo = $eve -> eve_tipo;
        } else {
            $fecha = $_POST['fecha_pdf'];
            $tipo = $_POST['tipo_visita'];
        }

        $var_fecha = presupuestos::find($id_presupuesto);
        $var_fecha -> pre_dateprox = $fecha;
        $var_fecha -> save();

        if(!isset($_SESSION)){
            session_start();
        }

        if($_POST['no_presentar'] == '1'){

            if($_POST['fecha_pdf'] == '2000-01-01'){
                $eve -> eve_presupuesto = $_POST['pre_id'];
                $eve -> save();
            } else {
                if($eve != NULL){
                    $eve -> delete();
                }
                $evento = new eventos;
                $evento -> eve_fecha = $fecha;
                $evento -> eve_tipo = $tipo;
                $evento -> eve_presupuesto = $_POST['pre_id'];
                $evento -> eve_cliente = $presupuesto -> pre_cliente;
                $evento -> eve_asesor = $_SESSION['id_ase'];
                $evento -> save();
            }

            $obj_historico = new historial_cambios;
            $obj_historico -> hist_cliente     = $presupuesto->clientes->cli_id;
            $obj_historico -> hist_asesor  = $_SESSION['id_ase'];
            $obj_historico -> hist_comentario  = "Presentación del Presupuesto #" . $_POST['pre_id'] . " para el " . $fecha . ". El tipo de la visita será por via " . $tipo;
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
            $obj_hist_pres -> hist_pres_estado_presupuesto = $tipo;
            $obj_hist_pres -> hist_pres_asesor = $_SESSION['id_ase'];
            $obj_hist_pres -> save();

        }


        //Array para la sociedad
        $informacion['razon_social'] = array($presupuesto->sociedades->soc_nom,
                                $presupuesto->sociedades->soc_cif,
                                $presupuesto->pre_emisora,
                                $presupuesto->sociedades->soc_dir,
                                $presupuesto->sociedades->soc_cp,
                                $presupuesto->sociedades->soc_loc . " (" . $sociedad->sociedades->soc_pro . ")");



        //Array para el cliente
        $informacion['cliente'] = array(    $presupuesto->clientes->cli_nom,
                                            $presupuesto->clientes->cli_anu,
                                            $presupuesto->clientes->cli_cif,
                                            $presupuesto->clientes->cli_dir,
                                            $presupuesto->clientes->cli_cp,
                                            $presupuesto->clientes->cli_loc,
                                            $presupuesto->clientes->cli_pro,
                                            $presupuesto->clientes->cli_tel1
                                        );

        //TODO Query para los detalles de la campaña
        $informacion['detalles_campanya'] = array("CADENA SER",
                                $presupuesto->pre_dateini,
                                $presupuesto->pre_datefin,
                                "20\" sg",
                                $presupuesto->asesores->ase_nombre);

        //Query para las observaciones (accion comercial + observaciones del cliente):
        $acc = presupuestos::find($accion_id);

        if($acc !== NULL){
            $informacion['observaciones_cliente'] = array();
            $informacion['observaciones_cliente']['accion_comercial'] =  $acc->acc_com_name . " " . $acc->acc_com_tipo;
        }


        //Query para las observaciones:
        $informacion['observaciones_cliente']['otra_informacion'] = 'Observaciones'; /*presupuestos::where('pre_id', '=', $id_presupuesto)
                            ->get('observaciones');*/

        //Query para cada una de las lineas de presupuesto
        $informacion['lineas'] = array();
        $lineas = linea_presupuesto::where('lin_pre_pre', '=', $id_presupuesto)
                            ->with('soportes_presupuestos')
                            ->with('tarifas_presupuestos')
                            ->with('Duracion_Presupuestos')
                            ->get();

        foreach ($lineas as $linea) {

            $contador2 = 0;

            $informacion ['lineas'] [$contador] = array();

            $informacion ['lineas'] [$contador] ['programa']    = $linea->  soportes_presupuestos   ->sop_pre_nombre;
            $informacion ['lineas'] [$contador] ['tarifa']      = $linea->  tarifas_presupuestos    ->tar_pre_nombre;
            $informacion ['lineas'] [$contador] ['formato']     = $linea->  duracion_presupuestos   ->dur_pre_nombre;
            $informacion ['lineas'] [$contador] ['unidades']    = $linea->  lin_pre_ncu;
            $informacion ['lineas'] [$contador] ['descuento']   = $linea->  lin_pre_desc;
            $informacion ['lineas'] [$contador] ['total_neto']  = $linea->  lin_pre_prec;
            $informacion ['lineas'] [$contador] ['precio']      = Precios_Presupuesto::where('pre_pre_tarifa','=',$linea->lin_pre_tar)
                                                                            ->where('pre_pre_duracion', '=', $linea -> lin_pre_dur)
                                                                            ->get('pre_pre_value')[0]->pre_pre_value;
            $informacion ['lineas'] [$contador] ['total_tarifa']= intval($linea->  lin_pre_ncu) * floatval($informacion ['lineas'] [$contador] ['precio']);
            $informacion ['lineas'] [$contador] ['precio_dto']  = floatval($informacion ['lineas'] [$contador] ['precio']) * (1-(floatval($linea->  lin_pre_desc)/100));

            //Ópticos

            $informacion ['lineas'] [$contador] ['opticos'] = array();

            $filas_optico = optico_fila::where('opt_fil_pre','=',$linea -> lin_pre_pre)
                                ->where('opt_fil_sop','=',$linea -> lin_pre_sop)
                                ->with('tarifas_presupuestos')
                                ->with('mes')
                                ->with('duracion_presupuestos')
                                ->get();

            foreach ($filas_optico as $fila) {

                $info_dias = $fila->toArray();

                $informacion ['lineas'] [$contador] ['opticos'] [$contador2] = array();

                $informacion ['lineas'] [$contador] ['opticos'] [$contador2] ['is_data']    = $fila -> opt_fil_isdata;
                $informacion ['lineas'] [$contador] ['opticos'] [$contador2] ['mes']        = $fila -> mes -> mes_nombre;
                $informacion ['lineas'] [$contador] ['opticos'] [$contador2] ['matricula']  = $fila -> opt_fil_mat;

                if (isset($fila -> duracion_presupuestos)){
                    $informacion ['lineas'] [$contador] ['opticos'] [$contador2] ['duracion']   = $fila -> duracion_presupuestos -> dur_pre_nombre;
                }
                else{
                    $informacion ['lineas'] [$contador] ['opticos'] [$contador2] ['duracion']   = null;
                }

                $informacion ['lineas'] [$contador] ['opticos'] [$contador2] ['tarifa']     = $fila -> opt_fil_tar;
                if(isset($fila -> tarifas_presupuestos))
                $informacion ['lineas'] [$contador] ['opticos'] [$contador2] ['tarifa_name']= $fila -> tarifas_presupuestos -> tar_pre_nombre;
                $informacion ['lineas'] [$contador] ['opticos'] [$contador2] ['hora']       = $fila -> opt_fil_hora;

                for ($i=1; $i <32 ; $i++) {
                    $informacion ['lineas'] [$contador] ['opticos'] [$contador2] ['data'.$i]= $info_dias['opt_fil_data' . $i];
                }

                $informacion ['lineas'] [$contador] ['opticos'] [$contador2] ['total']      =$fila -> opt_fil_datauds;


                $contador2++;
            }



            $contador++;
        }

        $emisoras = '';
        $total_cunyas_global = 0;
        $total_neto_global = 0;
        $total_bruto_global = 0;

        foreach ($informacion['lineas'] as $linea) {

            if(!str_contains($emisoras,$linea['programa'])){
                if(strcmp($linea['programa'], "VALLAS PUBLICITARIAS") ){
                    $emisoras .= $linea['programa'] . " | ";
                }
                else{
                    $emisoras .= "VALLAS" . " | ";
                }
            }

            $total_cunyas_global += $linea['unidades'];
            $total_neto_global += $linea['total_neto'];
            $total_bruto_global += $linea['total_tarifa'];


        }
        $precios = array(
            'total_cunyas'  =>  $total_cunyas_global,
            'total_neto'    =>  $total_neto_global,
            'total_bruto'   =>  $total_bruto_global,
            'gastos_prod'   =>  0,
            'iva'           =>  21
        );
        $informacion['razon_social'][2] = $emisoras;



        if($_POST['no_presentar'] == '1'){
            $act = presupuestos::find($id_presupuesto);
            $act -> pre_estado = 'PRESENTADO';
            $act ->save();

            $aux = $act -> pre_valido;
        } else {
            $act = presupuestos::find($id_presupuesto);
            $aux = $act -> pre_valido;
        }


        return view('generar_PDF',[ 'datos' => $informacion, 'precios' => $precios, 'isvalid' => $aux  ]);

    }
}
