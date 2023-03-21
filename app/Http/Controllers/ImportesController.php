<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AnyoController;
use App\Http\Controllers\AsesoresController;
use App\Http\Controllers\SoportesController;
use App\Http\Controllers\AnunciantesController;
use App\Models\Importes;
use App\Models\Asesores;
use App\Models\Soportes;
use App\Models\Clientes;
use App\Models\historial_cambios;
use App\Models\Anyo;
use App\Models\Anunciantes;

use Illuminate\Support\Facades\DB;

class ImportesController extends Controller
{
    public function insertImporte($anyo,$mes_id,$asesor,$soporte,$anunciante,$importe) {
        $obj_importes = new Importes;

        $anyo_id = anyo::select ('anyo_id')
           -> where ('anyo_nombre','=',$anyo)
           -> first();
        $anyo_id = $anyo_id -> anyo_id;

        $asesor_id = asesores::select ('ase_id')
           -> where ('ase_nombre','=',$asesor)
           -> first();
        $asesor_id = $asesor_id -> ase_id;

        $soporte_id = soportes::select ('sop_id')
           -> where ('sop_nombre','=',$soporte)
           -> first();
        $soporte_id = $soporte_id -> sop_id;



        $anunciante_id = anunciantes::select ('anu_id')
           -> where ('anu_nombre','=',$anunciante)
           -> first();
        $anunciante_id = $anunciante_id -> anu_id;

        $parte_entera = strtok($importe, ",");
        $parte_decimal = substr($importe, -2);
        $parte_entera = str_replace(".","",$parte_entera);

        $importe = $parte_entera . "." . $parte_decimal;

        $obj_importes -> imp_anyo = $anyo_id;
        $obj_importes -> imp_mes = $mes_id;
        $obj_importes -> imp_ase = $asesor_id;
        $obj_importes -> imp_sop = $soporte_id;
        $obj_importes -> imp_anu = $anunciante_id;
        $obj_importes -> imp_importe = $importe;

        try {
            $consulta = importes::select ('imp_id')
               -> where ('imp_anyo','=',$anyo_id)
               -> where ('imp_mes','=',$mes_id)
               -> where ('imp_ase','=',$asesor_id)
               -> where ('imp_sop','=',$soporte_id)
               -> where ('imp_anu','=',$anunciante_id)
               -> first();
            $consulta = $consulta -> anu_nombre;
        } catch (\Exception $e) {

        }

        if($consulta == NULL){
            try{
                $obj_importes -> save();
            }
            catch(QueryException $e){
              $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){

                }
            }
        }


    }


    public function showImporte_admin($mes_elegido, $soporte_elegido){

      $canales = asesores::select('ase_canal')
        ->distinct()
        ->paginate(100);

      $query_anyos = anyo::select('anyo_nombre')
          ->orderBy('anyo_nombre', 'desc')
          ->take(4)
          ->get();
      $anyos = array();
      for($i = 3; $i >= 0; $i--){
          $anyos[3-$i] = $query_anyos[$i];
      }

      $soportes = importes::select('sop_nombre as imp_sop','sop_id')
          ->join('anyo','anyo_id','=','imp_anyo')
          ->join('anunciantes','anu_id','=','imp_anu')
          ->join('asesores','ase_id','=','imp_ase')
          ->join('soportes','sop_id','=','imp_sop')
          ->join('mes','mes_id','=','imp_mes')
          ->where('mes_nombre','=',$mes_elegido)
          ->distinct()
          ->paginate(1000);

      $asesores = asesores::select('ase_id', 'ase_nombre', 'ase_canal')
          ->distinct()
          ->paginate(1000);



        for ($i=0; $i < count($soportes); $i++) {
            switch($soportes[$i]->imp_sop){
                case "CADENA SER O.M.":
                    $soportes[$i]->imp_sop = "CADENA SER";
                    break;
                case "40 PRINCIPALES":
                    $soportes[$i]->imp_sop = "40 PRINCIP.";
                    break;
                case "RADIO ELCHE FM":
                    $soportes[$i]->imp_sop = "RADIO ELCHE";
                    break;
                case "INICIATIVAS DE PUBLICIDAD GENERAL,":
                    $soportes[$i]->imp_sop = "INICIATIVAS";
                    break;
                case "VALLAS PUBLICITARIAS":
                    $soportes[$i]->imp_sop = "VALLAS PUBL.";
                    break;
                case "ELCHE TV":
                    $soportes[$i]->imp_sop = "ELCHE 7 TV";
                    break;
                case "WEB":
                    $soportes[$i]->imp_sop = "PAGINAS WEB";
                    break;
                case "SER EMPRESARIOS":
                    $soportes[$i]->imp_sop = "SER EMPRES.";
                    break;
                case "INICIATIVAS DE PUBLICIDAD GENERAL J":
                    $soportes[$i]->imp_sop = "INICIATIVAS J";
                    break;
                case "TELEVISION DE ELCHE":
                    $soportes[$i]->imp_sop = "TV DE ELCHE";
                    break;
                case "SER PYMES":
                    $soportes[$i]->imp_sop = "SER PYMES";
                    break;
                case "ROTULACION Y COLOCACION VINILO":
                    $soportes[$i]->imp_sop = "VINILOS";
                    break;
            }
        }

        //Pasado hasta aquí

        if( $soporte_elegido != NULL ){
            //Totales por año, canal y soporte
            $query_canal_totales_anyo1 = importes::select('ase_canal as canal','imp_importe as importe')
                ->join('anyo','anyo_id','=','imp_anyo')
                ->join('asesores','ase_id','=','imp_ase')
                ->join('mes','mes_id','=','imp_mes')
                ->join('soportes','sop_id','=','imp_sop')
                ->where('sop_id','=',$soporte_elegido)
                ->where('mes_nombre','=', $mes_elegido)
                ->where('anyo_nombre', '=', $anyos[0]->anyo_nombre)
                ->paginate(1000);

            $query_canal_totales_anyo1 = $query_canal_totales_anyo1->groupBy('canal')->map(function ($row) {
                return $row->sum('importe');
            });

            $query_canal_totales_anyo2 = importes::select('ase_canal as canal','imp_importe as importe')
                ->join('anyo','anyo_id','=','imp_anyo')
                ->join('asesores','ase_id','=','imp_ase')
                ->join('mes','mes_id','=','imp_mes')
                ->join('soportes','sop_id','=','imp_sop')
                ->where('sop_id','=',$soporte_elegido)
                ->where('mes_nombre','=', $mes_elegido)
                ->where('anyo_nombre', '=', $anyos[1]->anyo_nombre)
                ->paginate(1000);

            $query_canal_totales_anyo2 = $query_canal_totales_anyo2->groupBy('canal')->map(function ($row) {
                return $row->sum('importe');
            });

            $query_canal_totales_anyo3 = importes::select('ase_canal as canal','imp_importe as importe')
                ->join('anyo','anyo_id','=','imp_anyo')
                ->join('asesores','ase_id','=','imp_ase')
                ->join('mes','mes_id','=','imp_mes')
                ->join('soportes','sop_id','=','imp_sop')
                ->where('sop_id','=',$soporte_elegido)
                ->where('mes_nombre','=', $mes_elegido)
                ->where('anyo_nombre', '=', $anyos[2]->anyo_nombre)
                ->paginate(1000);

            $query_canal_totales_anyo3 = $query_canal_totales_anyo3->groupBy('canal')->map(function ($row) {
                return $row->sum('importe');
            });

            $query_canal_totales_anyo4 = importes::select('ase_canal as canal','imp_importe as importe')
                ->join('anyo','anyo_id','=','imp_anyo')
                ->join('asesores','ase_id','=','imp_ase')
                ->join('mes','mes_id','=','imp_mes')
                ->join('soportes','sop_id','=','imp_sop')
                ->where('sop_id','=',$soporte_elegido)
                ->where('mes_nombre','=', $mes_elegido)
                ->where('anyo_nombre', '=', $anyos[3]->anyo_nombre)
                ->paginate(1000);

            $query_canal_totales_anyo4 = $query_canal_totales_anyo4->groupBy('canal')->map(function ($row) {
                return $row->sum('importe');
            });
        }
        else{
            $query_canal_totales_anyo1 = importes::select('ase_canal as canal','imp_importe as importe')
                ->join('anyo','anyo_id','=','imp_anyo')
                ->join('asesores','ase_id','=','imp_ase')
                ->join('mes','mes_id','=','imp_mes')
                ->join('soportes','sop_id','=','imp_sop')
                ->where('mes_nombre','=', $mes_elegido)
                ->where('anyo_nombre', '=', $anyos[0]->anyo_nombre)
                ->paginate(1000);

            $query_canal_totales_anyo1 = $query_canal_totales_anyo1->groupBy('canal')->map(function ($row) {
                return $row->sum('importe');
            });

            $query_canal_totales_anyo2 = importes::select('ase_canal as canal','imp_importe as importe')
                ->join('anyo','anyo_id','=','imp_anyo')
                ->join('asesores','ase_id','=','imp_ase')
                ->join('mes','mes_id','=','imp_mes')
                ->join('soportes','sop_id','=','imp_sop')
                ->where('mes_nombre','=', $mes_elegido)
                ->where('anyo_nombre', '=', $anyos[1]->anyo_nombre)
                ->paginate(1000);

            $query_canal_totales_anyo2 = $query_canal_totales_anyo2->groupBy('canal')->map(function ($row) {
                return $row->sum('importe');
            });

            $query_canal_totales_anyo3 = importes::select('ase_canal as canal','imp_importe as importe')
                ->join('anyo','anyo_id','=','imp_anyo')
                ->join('asesores','ase_id','=','imp_ase')
                ->join('mes','mes_id','=','imp_mes')
                ->join('soportes','sop_id','=','imp_sop')
                ->where('mes_nombre','=', $mes_elegido)
                ->where('anyo_nombre', '=', $anyos[2]->anyo_nombre)
                ->paginate(1000);

            $query_canal_totales_anyo3 = $query_canal_totales_anyo3->groupBy('canal')->map(function ($row) {
                return $row->sum('importe');
            });

            $query_canal_totales_anyo4 = importes::select('ase_canal as canal','imp_importe as importe')
                ->join('anyo','anyo_id','=','imp_anyo')
                ->join('asesores','ase_id','=','imp_ase')
                ->join('mes','mes_id','=','imp_mes')
                ->join('soportes','sop_id','=','imp_sop')
                ->where('mes_nombre','=', $mes_elegido)
                ->where('anyo_nombre', '=', $anyos[3]->anyo_nombre)
                ->paginate(1000);

            $query_canal_totales_anyo4 = $query_canal_totales_anyo4->groupBy('canal')->map(function ($row) {
                return $row->sum('importe');
            });
        }

        //Bucle para parsear canales y datos de canales

        $max = count($canales);
        $canales_data = array();;
        for ($i=0; $i < $max ; $i++) {
            $canales_data [$i] = array();
            $canales_data [$i][0] = $canales[$i]->ase_canal;

            if( isset($query_canal_totales_anyo1[$canales_data[$i][0]]) ){
                $canales_data[$i][1] = $query_canal_totales_anyo1[$canales_data[$i][0]];
            }
            else {
                $canales_data[$i][1] = 0;
            }

            if( isset($query_canal_totales_anyo2[$canales_data[$i][0]]) ){
                $canales_data[$i][2] = $query_canal_totales_anyo2[$canales_data[$i][0]];
            }
            else {
                $canales_data[$i][2] = 0;
            }

            if( isset($query_canal_totales_anyo3[$canales_data[$i][0]]) ){
                $canales_data[$i][3] = $query_canal_totales_anyo3[$canales_data[$i][0]];
            }
            else {
                $canales_data[$i][3] = 0;
            }

            if( isset($query_canal_totales_anyo4[$canales_data[$i][0]]) ){
                $canales_data[$i][4] = $query_canal_totales_anyo4[$canales_data[$i][0]];
            }
            else {
                $canales_data[$i][4] = 0;
            }

            if( is_numeric($canales_data[$i][4]) ){
                $canales_data[$i][5] = $canales_data[$i][4] - $canales_data[$i][3];
            }
            else{
                $canales_data[$i][5] = 0;
            }
        }

        $canales_data[$max] = array();
        $canales_data[$max][0]='TOTALES';

        for ($j=1; $j < 6 ; $j++) {
            $total = 0;
            for ($i=0; $i < $max ; $i++) {
                if( is_numeric($canales_data[$i][$j]) ){
                    $total += $canales_data[$i][$j];
                }
            }
            $canales_data[$max][$j] = $total;
        }

        array_multisort( array_column($canales_data, 4), SORT_DESC, $canales_data );

        //Para soportes
        $asesores_data = array();
        $tam = count($asesores);

        if( $soporte_elegido == NULL ){

            for ($i=0; $i <$tam ; $i++) {

                $asesores_data[$i] = array();
                $asesores_data[$i][0] = $asesores[$i]->ase_nombre;



                for ($j=0; $j < 4 ; $j++) {

                    $query_asesores = importes::select('ase_nombre as asesor','imp_importe as importe', "ase_canal as canal")
                        ->join('anyo','anyo_id','=','imp_anyo')
                        ->join('asesores','ase_id','=','imp_ase')
                        ->join('mes','mes_id','=','imp_mes')
                        ->join('soportes','sop_id','=','imp_sop')
                        ->where('mes_nombre','=', $mes_elegido)
                        ->where('anyo_nombre', '=', $anyos[$j]->anyo_nombre)
                        ->where('ase_nombre','=', $asesores[$i]->ase_nombre)
                        ->paginate(1000);

                    $query_asesores = $query_asesores->groupBy('asesor','canal')->map(function ($row) {
                        return $row->sum('importe');
                    });

                    if ( isset($query_asesores[$asesores_data[$i][0]]) )
                        $asesores_data[$i][$j+1] = $query_asesores[$asesores_data[$i][0]];
                    else
                        $asesores_data[$i][$j+1] = 0;

                }

                if( is_numeric($asesores_data[$i][4]) ){
                    $asesores_data[$i][5] = $asesores_data[$i][4] - $asesores_data[$i][3];
                }
                else{
                    $asesores_data[$i][5] = 0;
                }

                foreach ($canales_data as $canal) {
                    if(strcmp($canal[0],$asesores[$i]->ase_canal)){
                        $asesores_data[$i][6] = $asesores[$i]->ase_canal;
                        $asesores_data[$i][7] = $asesores[$i]->ase_id;
                    }
                }


            }

            array_multisort( array_column($asesores_data, 4), SORT_DESC, $asesores_data );


        }
        else{
            for ($i=0; $i <$tam ; $i++) {

                $asesores_data[$i] = array();
                $asesores_data[$i][0] = $asesores[$i]->ase_nombre;


                for ($j=0; $j < 4 ; $j++) {

                    $query_asesores = importes::select('ase_nombre as asesor','imp_importe as importe')
                        ->join('anyo','anyo_id','=','imp_anyo')
                        ->join('asesores','ase_id','=','imp_ase')
                        ->join('mes','mes_id','=','imp_mes')
                        ->join('soportes','sop_id','=','imp_sop')
                        ->where('mes_nombre','=', $mes_elegido)
                        ->where('sop_id', '=', $soporte_elegido)
                        ->where('anyo_nombre', '=', $anyos[$j]->anyo_nombre)
                        ->where('ase_nombre','=', $asesores[$i]->ase_nombre)
                        ->paginate(1000);

                    $query_asesores = $query_asesores->groupBy('asesor')->map(function ($row) {
                        return $row->sum('importe');
                    });

                    if ( isset($query_asesores[$asesores_data[$i][0]]) )
                        $asesores_data[$i][$j+1] = $query_asesores[$asesores_data[$i][0]];
                    else
                        $asesores_data[$i][$j+1] = 0;

                }

                if( is_numeric($asesores_data[$i][4]) ){
                    $asesores_data[$i][5] = $asesores_data[$i][4] - $asesores_data[$i][3];
                }
                else{
                    $asesores_data[$i][5] = 0;
                }

                foreach ($canales_data as $canal) {
                    if(strcmp($canal[0],$asesores[$i]->ase_canal)){
                        $asesores_data[$i][6] = $asesores[$i]->ase_canal;
                        $asesores_data[$i][7] = $asesores[$i]->ase_id;
                    }
                }

                array_multisort( array_column($asesores_data, 4), SORT_DESC, $asesores_data );
            }
        }

        //Importes

        $importes_data = array();
        $tam = count($asesores);


        if ( $soporte_elegido == NULL ) {
            for ($i=0; $i < $tam ; $i++) {
                //bucle de asesores

                $importes_data[$asesores[$i]->ase_nombre] = array();


                $query_importes1 = importes::select('anu_nombre as imp_anu','ase_nombre as imp_ase','sop_nombre as imp_sop','mes_nombre as imp_mes','anyo_nombre as imp_anyo','imp_importe')
                    ->join('anyo','anyo_id','=','imp_anyo')
                    ->join('anunciantes','anu_id','=','imp_anu')
                    ->join('asesores','ase_id','=','imp_ase')
                    ->join('soportes','sop_id','=','imp_sop')
                    ->join('mes','mes_id','=','imp_mes')
                    ->where('ase_nombre', '=', $asesores[$i]->ase_nombre)
                    ->where('anyo_nombre','=',$anyos[0]->anyo_nombre)
                    ->where('mes_nombre','=',$mes_elegido)
                    ->paginate(1000);

                $query_importes1 = $query_importes1->groupBy('imp_anu')->map(function ($row) {
                    return $row->sum('imp_importe');
                });

                $query_importes2 = importes::select('anu_nombre as imp_anu','ase_nombre as imp_ase','sop_nombre as imp_sop','mes_nombre as imp_mes','anyo_nombre as imp_anyo','imp_importe')
                    ->join('anyo','anyo_id','=','imp_anyo')
                    ->join('anunciantes','anu_id','=','imp_anu')
                    ->join('asesores','ase_id','=','imp_ase')
                    ->join('soportes','sop_id','=','imp_sop')
                    ->join('mes','mes_id','=','imp_mes')
                    ->where('ase_nombre', '=', $asesores[$i]->ase_nombre)
                    ->where('anyo_nombre','=',$anyos[1]->anyo_nombre)
                    ->where('mes_nombre','=',$mes_elegido)
                    ->paginate(1000);

                $query_importes2 = $query_importes2->groupBy('imp_anu')->map(function ($row) {
                    return $row->sum('imp_importe');
                });

                $query_importes3 = importes::select('anu_nombre as imp_anu','ase_nombre as imp_ase','sop_nombre as imp_sop','mes_nombre as imp_mes','anyo_nombre as imp_anyo','imp_importe')
                    ->join('anyo','anyo_id','=','imp_anyo')
                    ->join('anunciantes','anu_id','=','imp_anu')
                    ->join('asesores','ase_id','=','imp_ase')
                    ->join('soportes','sop_id','=','imp_sop')
                    ->join('mes','mes_id','=','imp_mes')
                    ->where('ase_nombre', '=', $asesores[$i]->ase_nombre)
                    ->where('anyo_nombre','=',$anyos[2]->anyo_nombre)
                    ->where('mes_nombre','=',$mes_elegido)
                    ->paginate(1000);

                $query_importes3 = $query_importes3->groupBy('imp_anu')->map(function ($row) {
                    return $row->sum('imp_importe');
                });
                //dd($query_importes3);
                $query_importes4 = importes::select('anu_nombre as imp_anu','ase_nombre as imp_ase','sop_nombre as imp_sop','mes_nombre as imp_mes','anyo_nombre as imp_anyo','imp_importe')
                    ->join('anyo','anyo_id','=','imp_anyo')
                    ->join('anunciantes','anu_id','=','imp_anu')
                    ->join('asesores','ase_id','=','imp_ase')
                    ->join('soportes','sop_id','=','imp_sop')
                    ->join('mes','mes_id','=','imp_mes')
                    ->where('ase_nombre', '=', $asesores[$i]->ase_nombre)
                    ->where('anyo_nombre','=',$anyos[3]->anyo_nombre)
                    ->where('mes_nombre','=',$mes_elegido)
                    ->paginate(1000);

                $query_importes4 = $query_importes4->groupBy('imp_anu')->map(function ($row) {
                    return $row->sum('imp_importe');
                });

                $anunciantes = importes::select('anu_nombre as imp_anu')
                  ->join('anyo','anyo_id','=','imp_anyo')
                  ->join('anunciantes','anu_id','=','imp_anu')
                  ->join('asesores','ase_id','=','imp_ase')
                  ->join('soportes','sop_id','=','imp_sop')
                  ->join('mes','mes_id','=','imp_mes')
                  ->where('mes_nombre','=',$mes_elegido)
                  ->where('ase_nombre', '=', $asesores[$i]->ase_nombre)
                  ->distinct()
                  ->orderBy('anu_nombre')
                  ->paginate(1000);

                $tam2 = count($anunciantes);

                if($tam2 == 0){
                  $importes_data[$asesores[$i]->ase_nombre][$j] = array();
                  $importes_data[$asesores[$i]->ase_nombre][$j][0] = "SIN DATOS";
                  $importes_data[$asesores[$i]->ase_nombre][$j][1]="SIN DATOS";
                  $importes_data[$asesores[$i]->ase_nombre][$j][2]="SIN DATOS";
                  $importes_data[$asesores[$i]->ase_nombre][$j][3]="SIN DATOS";
                  $importes_data[$asesores[$i]->ase_nombre][$j][4]="SIN DATOS";
                  $importes_data[$asesores[$i]->ase_nombre][$j][5]="SIN DATOS";
                }

                for ($j=0; $j < $tam2 ; $j++) {

                  $importes_data[$asesores[$i]->ase_nombre][$j] = array();



                    $importes_data[$asesores[$i]->ase_nombre][$j][0] = $anunciantes[$j] -> imp_anu;
                    $importes_data[$asesores[$i]->ase_nombre][$j][1]=0;
                    $importes_data[$asesores[$i]->ase_nombre][$j][2]=0;
                    $importes_data[$asesores[$i]->ase_nombre][$j][3]=0;
                    $importes_data[$asesores[$i]->ase_nombre][$j][4]=0;


                    foreach ($query_importes1 as $key=>$row) {
                      if( strcmp($importes_data[$asesores[$i]->ase_nombre][$j][0],$key) == 0){
                          $importes_data[$asesores[$i]->ase_nombre][$j][1] =  $row;
                          break;
                      }
                    }

                    foreach ($query_importes2 as $key=>$row) {
                      if( strcmp($importes_data[$asesores[$i]->ase_nombre][$j][0],$key) == 0){
                          $importes_data[$asesores[$i]->ase_nombre][$j][2] =  $row;
                          break;
                      }
                    }

                    foreach ($query_importes3 as $key=>$row) {
                      if( strcmp($importes_data[$asesores[$i]->ase_nombre][$j][0],$key) == 0){
                          $importes_data[$asesores[$i]->ase_nombre][$j][3] =  $row;
                          break;
                      }
                    }

                    foreach ($query_importes4 as $key=>$row) {
                      if( strcmp($importes_data[$asesores[$i]->ase_nombre][$j][0],$key) == 0){
                          $importes_data[$asesores[$i]->ase_nombre][$j][4] =  $row;
                          break;
                      }
                    }

                    if( is_numeric($importes_data[$asesores[$i]->ase_nombre][$j][4]) ){
                        $importes_data[$asesores[$i]->ase_nombre][$j][5] = $importes_data[$asesores[$i]->ase_nombre][$j][4] - $importes_data[$asesores[$i]->ase_nombre][$j][3];
                    }
                    else{
                        $importes_data[$asesores[$i]->ase_nombre][$j][5] = '---';
                    }


                    array_multisort( array_column($importes_data[$asesores[$i]->ase_nombre], 4), SORT_DESC, $importes_data[$asesores[$i]->ase_nombre] );

                }
            }


        }
        else{
            for ($i=0; $i < $tam ; $i++) {
                //bucle de asesores

                $importes_data[$asesores[$i]->ase_nombre] = array();


                $query_importes1 = importes::select('anu_nombre as imp_anu','ase_nombre as imp_ase','sop_nombre as imp_sop','mes_nombre as imp_mes','anyo_nombre as imp_anyo','imp_importe')
                    ->join('anyo','anyo_id','=','imp_anyo')
                    ->join('anunciantes','anu_id','=','imp_anu')
                    ->join('asesores','ase_id','=','imp_ase')
                    ->join('soportes','sop_id','=','imp_sop')
                    ->join('mes','mes_id','=','imp_mes')
                    ->where('ase_nombre', '=', $asesores[$i]->ase_nombre)
                    ->where('anyo_nombre','=',$anyos[0]->anyo_nombre)
                    ->where('mes_nombre','=',$mes_elegido)
                    ->where('sop_id','=',$soporte_elegido)
                    ->paginate(1000);

                $query_importes2 = importes::select('anu_nombre as imp_anu','ase_nombre as imp_ase','sop_nombre as imp_sop','mes_nombre as imp_mes','anyo_nombre as imp_anyo','imp_importe')
                    ->join('anyo','anyo_id','=','imp_anyo')
                    ->join('anunciantes','anu_id','=','imp_anu')
                    ->join('asesores','ase_id','=','imp_ase')
                    ->join('soportes','sop_id','=','imp_sop')
                    ->join('mes','mes_id','=','imp_mes')
                    ->where('ase_nombre', '=', $asesores[$i]->ase_nombre)
                    ->where('anyo_nombre','=',$anyos[1]->anyo_nombre)
                    ->where('mes_nombre','=',$mes_elegido)
                    ->where('sop_id','=',$soporte_elegido)
                    ->paginate(1000);

                $query_importes3 = importes::select('anu_nombre as imp_anu','ase_nombre as imp_ase','sop_nombre as imp_sop','mes_nombre as imp_mes','anyo_nombre as imp_anyo','imp_importe')
                    ->join('anyo','anyo_id','=','imp_anyo')
                    ->join('anunciantes','anu_id','=','imp_anu')
                    ->join('asesores','ase_id','=','imp_ase')
                    ->join('soportes','sop_id','=','imp_sop')
                    ->join('mes','mes_id','=','imp_mes')
                    ->where('ase_nombre', '=', $asesores[$i]->ase_nombre)
                    ->where('anyo_nombre','=',$anyos[2]->anyo_nombre)
                    ->where('mes_nombre','=',$mes_elegido)
                    ->where('sop_id','=',$soporte_elegido)
                    ->paginate(1000);

                $query_importes4 = importes::select('anu_nombre as imp_anu','ase_nombre as imp_ase','sop_nombre as imp_sop','mes_nombre as imp_mes','anyo_nombre as imp_anyo','imp_importe')
                    ->join('anyo','anyo_id','=','imp_anyo')
                    ->join('anunciantes','anu_id','=','imp_anu')
                    ->join('asesores','ase_id','=','imp_ase')
                    ->join('soportes','sop_id','=','imp_sop')
                    ->join('mes','mes_id','=','imp_mes')
                    ->where('ase_nombre', '=', $asesores[$i]->ase_nombre)
                    ->where('anyo_nombre','=',$anyos[3]->anyo_nombre)
                    ->where('mes_nombre','=',$mes_elegido)
                    ->where('sop_id','=',$soporte_elegido)
                    ->paginate(1000);

                $anunciantes = importes::select('anu_nombre as imp_anu')
                  ->join('anyo','anyo_id','=','imp_anyo')
                  ->join('anunciantes','anu_id','=','imp_anu')
                  ->join('asesores','ase_id','=','imp_ase')
                  ->join('soportes','sop_id','=','imp_sop')
                  ->join('mes','mes_id','=','imp_mes')
                  ->where('mes_nombre','=',$mes_elegido)
                  ->where('ase_nombre', '=', $asesores[$i]->ase_nombre)
                  ->distinct()
                  ->orderBy('anu_nombre')
                  ->paginate(1000);

                $tam2 = count($anunciantes);

                if($tam2 == 0){
                  $importes_data[$asesores[$i]->ase_nombre][$j] = array();
                  $importes_data[$asesores[$i]->ase_nombre][$j][0] = "SIN DATOS";
                  $importes_data[$asesores[$i]->ase_nombre][$j][1]="SIN DATOS";
                  $importes_data[$asesores[$i]->ase_nombre][$j][2]="SIN DATOS";
                  $importes_data[$asesores[$i]->ase_nombre][$j][3]="SIN DATOS";
                  $importes_data[$asesores[$i]->ase_nombre][$j][4]="SIN DATOS";
                  $importes_data[$asesores[$i]->ase_nombre][$j][5]="SIN DATOS";
                }

                for ($j=0; $j < $tam2 ; $j++) {

                    $importes_data[$asesores[$i]->ase_nombre][$j] = array();

                    $importes_data[$asesores[$i]->ase_nombre][$j][0] = $anunciantes[$j] -> imp_anu;
                    $importes_data[$asesores[$i]->ase_nombre][$j][1]=0;
                    $importes_data[$asesores[$i]->ase_nombre][$j][2]=0;
                    $importes_data[$asesores[$i]->ase_nombre][$j][3]=0;
                    $importes_data[$asesores[$i]->ase_nombre][$j][4]=0;
                    $importes_data[$asesores[$i]->ase_nombre][$j][5]=0;



                    foreach ($query_importes1 as $row) {
                        if( strcmp($importes_data[$asesores[$i]->ase_nombre][$j][0],$row->imp_anu) == 0){
                            $importes_data[$asesores[$i]->ase_nombre][$j][1] =  $row->imp_importe;
                            break;
                        }
                    }

                    foreach ($query_importes2 as $row) {
                        if( strcmp($importes_data[$asesores[$i]->ase_nombre][$j][0],$row->imp_anu) == 0){
                            $importes_data[$asesores[$i]->ase_nombre][$j][2] =  $row->imp_importe;
                            break;
                        }
                    }

                    foreach ($query_importes3 as $row) {
                        if( strcmp($importes_data[$asesores[$i]->ase_nombre][$j][0],$row->imp_anu) == 0){
                            $importes_data[$asesores[$i]->ase_nombre][$j][3] =  $row->imp_importe;
                            break;
                        }
                    }

                    foreach ($query_importes4 as $row) {
                        if( strcmp($importes_data[$asesores[$i]->ase_nombre][$j][0],$row->imp_anu) == 0){
                            $importes_data[$asesores[$i]->ase_nombre][$j][4 ] =  $row->imp_importe;
                            break;
                        }
                    }

                    if( is_numeric($importes_data[$asesores[$i]->ase_nombre][$j][4]) ){
                        $importes_data[$asesores[$i]->ase_nombre][$j][5] = $importes_data[$asesores[$i]->ase_nombre][$j][4] - $importes_data[$asesores[$i]->ase_nombre][$j][3];
                    }
                    else{
                        $importes_data[$asesores[$i]->ase_nombre][$j][5] = '---';
                    }

                    array_multisort( array_column($importes_data[$asesores[$i]->ase_nombre], 4), SORT_DESC, $importes_data[$asesores[$i]->ase_nombre] );

                }
            }
        }

        return view('table_admin',[ 'mes_elegido' => $mes_elegido,
                                    'canales' => $canales_data,
                                    'anyos' => $anyos,
                                    'soportes' => $soportes,
                                    'soporte_elegido' => $soporte_elegido,
                                    'asesores' => $asesores,
                                    'asesores_data' => $asesores_data,
                                    'importes_data' => $importes_data
                                  ]);
    }

    public function showImporte(){

      session_start();

      if(isset($_GET["mes"]))
          $mes_elegido = $_GET["mes"];
      else
          $mes_elegido = "Enero";

      if(isset($_GET["id"]))
          $soporte_elegido = $_GET["id"];
      else{
          $soporte_elegido = NULL;
      }

      if ($_SESSION['status'] == 'admin') {
          return $this->showImporte_admin($mes_elegido, $soporte_elegido);
      }

      $data = array();



      $anyos = anyo::select('anyo_nombre')
      ->orderby('anyo_nombre')
      ->paginate(4);

      $soportes = importes::select('sop_nombre as imp_sop','sop_id')
        ->join('anyo','anyo_id','=','imp_anyo')
        ->join('anunciantes','anu_id','=','imp_anu')
        ->join('asesores','ase_id','=','imp_ase')
        ->join('soportes','sop_id','=','imp_sop')
        ->join('mes','mes_id','=','imp_mes')
        ->join('clientes','anu_nombre','cli_nom')
        ->where('cli_age','=',$_SESSION['id_ase'])
        ->where('mes_nombre','=',$mes_elegido)
        ->distinct()
        ->paginate(1000);



          for ($i=0; $i < count($soportes); $i++) {
              switch($soportes[$i]->imp_sop){
                  case "CADENA SER O.M.":
                      $soportes[$i]->imp_sop = "CADENA SER";
                      break;
                  case "40 PRINCIPALES":
                      $soportes[$i]->imp_sop = "40 PRINCIP.";
                      break;
                  case "RADIO ELCHE FM":
                      $soportes[$i]->imp_sop = "RADIO ELCHE";
                      break;
                  case "INICIATIVAS DE PUBLICIDAD GENERAL,":
                      $soportes[$i]->imp_sop = "INICIATIVAS";
                      break;
                  case "VALLAS PUBLICITARIAS":
                      $soportes[$i]->imp_sop = "VALLAS PUBL.";
                      break;
                  case "ELCHE TV":
                      $soportes[$i]->imp_sop = "ELCHE 7 TV";
                      break;
                  case "WEB":
                      $soportes[$i]->imp_sop = "PAGINAS WEB";
                      break;
                  case "SER EMPRESARIOS":
                      $soportes[$i]->imp_sop = "SER EMPRES.";
                      break;
                  case "INICIATIVAS DE PUBLICIDAD GENERAL J":
                      $soportes[$i]->imp_sop = "INICIATIVAS J";
                      break;
                  case "TELEVISION DE ELCHE":
                      $soportes[$i]->imp_sop = "TV DE ELCHE";
                      break;
                  case "SER PYMES":
                      $soportes[$i]->imp_sop = "SER PYMES";
                      break;
                  case "ROTULACION Y COLOCACION VINILO":
                      $soportes[$i]->imp_sop = "VINILOS";
                      break;
              }
          }


        if(isset($_GET["id"]))
          $soporte_elegido = $_GET["id"];
        else {

          $query_inicial1 = importes::select('anu_nombre as imp_anu','ase_nombre as imp_ase','sop_nombre as imp_sop','mes_nombre as imp_mes','anyo_nombre as imp_anyo','imp_importe')
            ->join('anyo','anyo_id','=','imp_anyo')
            ->join('anunciantes','anu_id','=','imp_anu')
            ->join('asesores','ase_id','=','imp_ase')
            ->join('soportes','sop_id','=','imp_sop')
            ->join('mes','mes_id','=','imp_mes')
            ->join('clientes','anu_nombre','cli_nom')
            ->where('cli_age','=',$_SESSION['id_ase'])
            ->where('anyo_nombre','=',$anyos[0]->anyo_nombre)
            ->where('mes_nombre','=',$mes_elegido)
            ->paginate(1000);

            $query_inicial1 = $query_inicial1->groupBy('imp_anu')->map(function ($row) {
                return $row->sum('imp_importe');
            });

          $query_inicial2 = importes::select('anu_nombre as imp_anu','ase_nombre as imp_ase','sop_nombre as imp_sop','mes_nombre as imp_mes','anyo_nombre as imp_anyo','imp_importe')
            ->join('anyo','anyo_id','=','imp_anyo')
            ->join('anunciantes','anu_id','=','imp_anu')
            ->join('asesores','ase_id','=','imp_ase')
            ->join('soportes','sop_id','=','imp_sop')
            ->join('mes','mes_id','=','imp_mes')
            ->join('clientes','anu_nombre','cli_nom')
            ->where('cli_age','=',$_SESSION['id_ase'])
            ->where('anyo_nombre','=',$anyos[1]->anyo_nombre)
            ->where('mes_nombre','=',$mes_elegido)
            ->paginate(1000);

            $query_inicial2 = $query_inicial2->groupBy('imp_anu')->map(function ($row) {
                return $row->sum('imp_importe');
            });

          $query_inicial3 = importes::select('anu_nombre as imp_anu','ase_nombre as imp_ase','sop_nombre as imp_sop','mes_nombre as imp_mes','anyo_nombre as imp_anyo','imp_importe')
            ->join('anyo','anyo_id','=','imp_anyo')
            ->join('anunciantes','anu_id','=','imp_anu')
            ->join('asesores','ase_id','=','imp_ase')
            ->join('soportes','sop_id','=','imp_sop')
            ->join('mes','mes_id','=','imp_mes')
            ->join('clientes','anu_nombre','cli_nom')
            ->where('cli_age','=',$_SESSION['id_ase'])
            ->where('anyo_nombre','=',$anyos[2]->anyo_nombre)
            ->where('mes_nombre','=',$mes_elegido)
            ->paginate(1000);

            $query_inicial3 = $query_inicial3->groupBy('imp_anu')->map(function ($row) {
                return $row->sum('imp_importe');
            });

          $query_inicial4 = importes::select('anu_nombre as imp_anu','ase_nombre as imp_ase','sop_nombre as imp_sop','mes_nombre as imp_mes','anyo_nombre as imp_anyo','imp_importe')
            ->join('anyo','anyo_id','=','imp_anyo')
            ->join('anunciantes','anu_id','=','imp_anu')
            ->join('asesores','ase_id','=','imp_ase')
            ->join('soportes','sop_id','=','imp_sop')
            ->join('mes','mes_id','=','imp_mes')
            ->join('clientes','anu_nombre','cli_nom')
            ->where('cli_age','=',$_SESSION['id_ase'])
            ->where('anyo_nombre','=',$anyos[3]->anyo_nombre)
            ->where('mes_nombre','=',$mes_elegido)
            ->paginate(1000);

            $query_inicial4 = $query_inicial4->groupBy('imp_anu')->map(function ($row) {
                return $row->sum('imp_importe');
            });

            $anunciantes = importes::select('anu_nombre as imp_anu', 'cli_age')
              ->join('anyo','anyo_id','=','imp_anyo')
              ->join('anunciantes','anu_id','=','imp_anu')
              ->join('asesores','ase_id','=','imp_ase')
              ->join('soportes','sop_id','=','imp_sop')
              ->join('mes','mes_id','=','imp_mes')
              ->join('clientes','anu_nombre','cli_nom')
              ->where('cli_age','=',$_SESSION['id_ase'])
              ->where('mes_nombre','=',$mes_elegido)
              ->distinct()
              ->orderBy('anu_nombre')
              ->get();



            $max = count($anunciantes);

            for($i = 0 ; $i < $max ; $i++){
                $data[$i] = array();

                $data[$i][1] = 0;
                $data[$i][2] = 0;
                $data[$i][3] = 0;
                $data[$i][4] = 0;

                $data[$i][0] = $anunciantes[$i]->imp_anu;



                foreach ($query_inicial1 as $key=>$row) {
                  if( strcmp($data[$i][0],$key) == 0){
                      $data[$i][1] =  $row;
                      break;
                  }
                }

                foreach ($query_inicial2 as $key=>$row) {
                  if( strcmp($data[$i][0],$key) == 0){
                      $data[$i][2] =  $row;
                      break;
                  }
                }

                foreach ($query_inicial3 as $key=>$row) {
                  if( strcmp($data[$i][0],$key) == 0){
                      $data[$i][3] =  $row;
                      break;
                  }
                }

                foreach ($query_inicial4 as $key=>$row) {
                  if( strcmp($data[$i][0],$key) == 0){
                      $data[$i][4] =  $row;
                      break;
                  }
                }

                if( is_numeric($data[$i][4]) ) {
                    $data[$i][5] = $data[$i][4] - $data[$i][3];
                }
                else{
                    $data[$i][5] = "---";
                }

            }

            $data[$max][0] = "TOTAL";
            $suma1 = 0;
            $suma2 = 0;
            $suma3 = 0;
            $suma4 = 0;

            for($i=0 ; $i<$max ; $i++){
                $suma1 += $data[$i][1];
                $suma2 += $data[$i][2];
                $suma3 += $data[$i][3];
                $suma4 += $data[$i][4];
            }

            $data[$max][1]=$suma1;
            $data[$max][2]=$suma2;
            $data[$max][3]=$suma3;
            $data[$max][4]=$suma4;

            $data[$max][5]=$suma4 - $suma3;

            $aux = $data[0];
            $data[0] = $data[$max];
            $data[$max] = $aux;

            array_multisort( array_column($data, 4), SORT_DESC, $data );

            $iterador = 0;

            foreach($data as $dato){
                if($dato[4] == 0){
                    $id_cli=clientes::where('cli_nom','=',$dato[0])
                        ->get();

                    if(isset($id_cli[0]->cli_id)){
                        $id_cli = $id_cli[0]->cli_id;

                        $nota = historial_cambios::where('hist_cliente','=',$id_cli)
                            ->where('hist_auto','=','0')
                            ->orderBy('created_at','desc')
                            ->limit(1)
                            ->get();

                        if(isset($nota[0])){

                            $data[$iterador][4] = trim(preg_replace("/\s+/u", " ", $nota[0]->hist_comentario));
                            $data[$iterador][10] = true;
                        }
                    }
                }
                $iterador++;
            }

          return view('table', ['importes' => $data, 'anyos' => $anyos, 'soportes' => $soportes, 'mes_elegido' => $mes_elegido]);
        }

        $query_anyo1 = importes::select('anu_nombre as imp_anu','ase_nombre as imp_ase','sop_nombre as imp_sop','mes_nombre as imp_mes','anyo_nombre as imp_anyo','imp_importe')
          ->join('anyo','anyo_id','=','imp_anyo')
          ->join('anunciantes','anu_id','=','imp_anu')
          ->join('asesores','ase_id','=','imp_ase')
          ->join('soportes','sop_id','=','imp_sop')
          ->join('mes','mes_id','=','imp_mes')
          ->join('clientes','anu_nombre','cli_nom')
          ->where('cli_age','=',$_SESSION['id_ase'])
          ->where('anyo_nombre','=',$anyos[0]->anyo_nombre)
          ->where('sop_id','=',$soporte_elegido)
          ->where('mes_nombre','=',$mes_elegido)
          ->paginate(1000);


        $query_anyo2 = importes::select('anu_nombre as imp_anu','ase_nombre as imp_ase','sop_nombre as imp_sop','mes_nombre as imp_mes','anyo_nombre as imp_anyo','imp_importe')
          ->join('anyo','anyo_id','=','imp_anyo')
          ->join('anunciantes','anu_id','=','imp_anu')
          ->join('asesores','ase_id','=','imp_ase')
          ->join('soportes','sop_id','=','imp_sop')
          ->join('mes','mes_id','=','imp_mes')
          ->join('clientes','anu_nombre','cli_nom')
          ->where('cli_age','=',$_SESSION['id_ase'])
          ->where('anyo_nombre','=',$anyos[1]->anyo_nombre)
          ->where('sop_id','=',$soporte_elegido)
          ->where('mes_nombre','=',$mes_elegido)
          ->paginate(1000);

        $query_anyo3 = importes::select('anu_nombre as imp_anu','ase_nombre as imp_ase','sop_nombre as imp_sop','mes_nombre as imp_mes','anyo_nombre as imp_anyo','imp_importe')
          ->join('anyo','anyo_id','=','imp_anyo')
          ->join('anunciantes','anu_id','=','imp_anu')
          ->join('asesores','ase_id','=','imp_ase')
          ->join('soportes','sop_id','=','imp_sop')
          ->join('mes','mes_id','=','imp_mes')
          ->join('clientes','anu_nombre','cli_nom')
          ->where('cli_age','=',$_SESSION['id_ase'])
          ->where('anyo_nombre','=',$anyos[2]->anyo_nombre)
          ->where('sop_id','=',$soporte_elegido)
          ->where('mes_nombre','=',$mes_elegido)
          ->paginate(1000);

        $query_anyo4 = importes::select('anu_nombre as imp_anu','ase_nombre as imp_ase','sop_nombre as imp_sop','mes_nombre as imp_mes','anyo_nombre as imp_anyo','imp_importe')
          ->join('anyo','anyo_id','=','imp_anyo')
          ->join('anunciantes','anu_id','=','imp_anu')
          ->join('asesores','ase_id','=','imp_ase')
          ->join('soportes','sop_id','=','imp_sop')
          ->join('mes','mes_id','=','imp_mes')
          ->join('clientes','anu_nombre','cli_nom')
          ->where('cli_age','=',$_SESSION['id_ase'])
          ->where('anyo_nombre','=',$anyos[3]->anyo_nombre)
          ->where('sop_id','=',$soporte_elegido)
          ->where('mes_nombre','=',$mes_elegido)
          ->paginate(1000);

        $anunciantes = importes::select('anu_nombre as imp_anu')
          ->join('anyo','anyo_id','=','imp_anyo')
          ->join('anunciantes','anu_id','=','imp_anu')
          ->join('asesores','ase_id','=','imp_ase')
          ->join('soportes','sop_id','=','imp_sop')
          ->join('mes','mes_id','=','imp_mes')
          ->join('clientes','anu_nombre','cli_nom')
          ->where('cli_age','=',$_SESSION['id_ase'])
          ->where('sop_id','=',$soporte_elegido)
          ->where('mes_nombre','=',$mes_elegido)
          ->distinct()
          ->paginate(1000);

        $max = count($anunciantes);

        for($i = 0 ; $i < $max ; $i++){
            $data[$i] = array();

            $data[$i][1] = 0;
            $data[$i][2] = 0;
            $data[$i][3] = 0;
            $data[$i][4] = 0;

            $data[$i][0] = $anunciantes[$i]->imp_anu;

            foreach ($query_anyo1 as $row) {
                if( strcmp($data[$i][0],$row->imp_anu) == 0){
                    $data[$i][1] =  $row->imp_importe;
                    break;
                }
            }

            foreach ($query_anyo2 as $row) {
                if( strcmp($data[$i][0],$row->imp_anu) == 0){
                    $data[$i][2] =  $row->imp_importe;
                    break;
                }
            }

            foreach ($query_anyo3 as $row) {
                if( strcmp($data[$i][0],$row->imp_anu) == 0){
                    $data[$i][3] =  $row->imp_importe;
                    break;
                }
            }

            foreach ($query_anyo4 as $row) {
                if( strcmp($data[$i][0],$row->imp_anu) == 0){
                    $data[$i][4] = $row->imp_importe;
                    break;
                }
            }

            if( is_numeric($data[$i][4]) ) {
                $data[$i][5] = $data[$i][4] - $data[$i][3];
            }
            else{
                $data[$i][5] = "---";
            }

        }

        $data[$max][0] = "TOTAL";
        $suma1 = 0;
        $suma2 = 0;
        $suma3 = 0;
        $suma4 = 0;

        for($i=0 ; $i<$max ; $i++){
            $suma1 += $data[$i][1];
            $suma2 += $data[$i][2];
            $suma3 += $data[$i][3];
            $suma4 += $data[$i][4];
        }

        $data[$max][1]=$suma1;
        $data[$max][2]=$suma2;
        $data[$max][3]=$suma3;
        $data[$max][4]=$suma4;
        $data[$max][5]=$suma4 - $suma3;

        $aux = $data[0];
        $data[0] = $data[$max];
        $data[$max] = $aux;

        array_multisort( array_column($data, 4), SORT_DESC, $data );
        $iterador = 0;

        foreach($data as $dato){
            if($dato[4] == 0){
                $id_cli=clientes::where('cli_nom','=',$dato[0])
                    ->get();

                if(isset($id_cli[0]->cli_id)){
                    $id_cli = $id_cli[0]->cli_id;

                    $nota = historial_cambios::where('hist_cliente','=',$id_cli)
                        ->where('hist_auto','=','0')
                        ->orderBy('created_at','desc')
                        ->limit(1)
                        ->get();

                    if(isset($nota[0])){

                        $data[$iterador][4] = trim(preg_replace("/\s+/u", " ", $nota[0]->hist_comentario));
                        $data[$iterador][10] = true;
                    }
                }
            }
            $iterador++;
        }


        return view('table', ['importes' => $data, 'anyos' => $anyos, 'soportes' => $soportes, 'soporte_elegido' => $soporte_elegido,'mes_elegido' => $mes_elegido]);
    }

    public function introducirDatos(Request $request){
        //21/04/2022 -> https://www.php.net/manual/en/features.file-upload.post-method.php
        //21/04/2022 -> https://www.php.net/manual/en/features.file-upload.php
        $anyo_controller = new AnyoController;
        $asesores_controller = new AsesoresController;
        $soportes_controller = new SoportesController;
        $anunciantes_controller = new AnunciantesController;
        $importes_controller = new ImportesController;

        $fila = 0;
        if (($gestor = fopen($_FILES['fichero']['tmp_name'], "r")) !== FALSE) {
            while (($datos = fgetcsv($gestor, 10000, ";")) !== FALSE) {
                $numero = count($datos);
                $flag = true;
                $contador = 0;
                for ($c=0; $c < $numero; $c++) {
                    if($datos[$c]=="" and $flag == true){
                      $contador ++;
                    }
                    else if($datos[$c]!=""){
                      $flag = false;
                    }
                }

                $contadores[] = $contador;
                $fila++;
            }
            fclose($gestor);
            $niveles = array_count_values($contadores);
            $niveles = array_diff( $niveles, [1] );
            $nivel1 = min(array_keys($niveles));
            unset($niveles[$nivel1]);
            $nivel2 = min(array_keys($niveles));
            unset($niveles[$nivel2]);
            $nivel3 = min(array_keys($niveles));
            unset($niveles[$nivel3]);
            unset($niveles);
            unset($contadores);
        }

        $fila = 0;

        if (($gestor = fopen($_FILES['fichero']['tmp_name'], "r")) !== FALSE) {
            $distancia_importe = 0;
            while (($datos = fgetcsv($gestor, 10000, ";")) !== FALSE) {
                $fila ++;
                //if ($fila==10)die;
                $numero = count($datos);
                for ($c=0; $c < $numero; $c++) {
                    if(str_contains($datos[$c],"Informe de ventas comparativo entre")){
                        //fecha
                        $fecha1 = substr($datos[$c], -24,10);

                        //Sacamos mes y años
                        $mes = substr($fecha1, -7,2);

                        $anyo1 = (int) substr($fecha1,-4,4);
                        $anyo2 = $anyo1 - 1;

                        $anyo_controller -> insertAnyo($anyo1);
                        $anyo_controller -> insertAnyo($anyo2);

                    }
                }

                $contador = 0;
                $flag = true;
                $asesor;
                $soporte;
                $anunciante;



                for ($c=0; $c < $numero; $c++) {
                    if($datos[$c]=="" and $flag == true){
                      $contador ++;
                    }
                    else if($datos[$c]!=""){
                      $flag = false;
                    }
                }

                //Saltamos las primeras filas que son de cabecera
                if($fila < 4){
                  continue;
                }

                if($contador == $nivel1){
                    //Asesor, se recoge el nombre del asesor y se lanza la query por medio de eloquent
                    for ($c=0; $c < $numero; $c++) {
                        if($datos[$c] != ""){
                          //La primera casilla no vacía será el nombre del asesor.
                          $asesor = utf8_encode($datos[$c]);
                          break;
                        }
                    }

                    $asesores_controller -> insertAsesor($asesor);

                }
                else if($contador == $nivel2){
                    //Soporte, se recoge el nombre del soporte y se lanza la query por medio de eloquent
                    for ($c=0; $c < $numero; $c++) {
                        if($datos[$c] != ""){
                          //La primera casilla no vacía será el nombre del soporte.
                          $soporte = utf8_encode($datos[$c]);
                          break;
                        }
                    }

                    if($distancia_importe == 0){
                        for ($c=0; $c < $numero; $c++) {
                            if($datos[$c] == "" OR $datos[$c] == $soporte){
                                $distancia_importe ++;
                            }
                            else{
                              break;
                            }
                        }
                    }
                    $soportes_controller -> insertSoporte($soporte);
                }
                else if($contador == $nivel3){

                  //Anunciante, se recoge el nombre del anunciante y se lanza la query por medio de eloquent
                    for ($c=0; $c < $numero; $c++) {
                        if($datos[$c] != ""){
                          //La primera casilla no vacía será el nombre del anunciante.
                          $anunciante = utf8_encode($datos[$c]);
                          break;
                        }
                    }

                    $anunciantes_controller -> insertAnunciante($anunciante);

                    $actual = 0;
                    $importe1 = NULL ;
                    $importe2 = NULL;

                    for ($c=0; $c < $numero; $c++) {
                        if($datos[$c] == "" OR $datos[$c]==$anunciante){
                            $actual ++;
                        }
                        else if($actual == $distancia_importe AND $datos[$c] != NULL){
                            $importe1 = $datos[$c];
                            $actual++;
                        }
                        else if($actual > $distancia_importe AND $datos[$c] != NULL){
                            $importe2 = $datos[$c];
                        }
                    }


                    if($importe1 != NULL)
                        $importes_controller -> insertImporte($anyo1,$mes,$asesor,$soporte,$anunciante,$importe1);
                    if($importe2 != NULL)
                        $importes_controller -> insertImporte($anyo2,$mes,$asesor,$soporte,$anunciante,$importe2);

                }
            }
        }

        return $this->showImporte();
    }
}
