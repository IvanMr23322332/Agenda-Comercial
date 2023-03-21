<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AnyoController;
use App\Http\Controllers\AsesoresController;
use App\Http\Controllers\SoportesController;
use App\Http\Controllers\AnunciantesController;
use App\Http\Controllers\ImportesController;

class CargarFicheros extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cargar:ficheros{directorio}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando utilizado para cargar los ficheros csv de importes en la base de datos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $directorio = $this->argument('directorio');
        $path = "./$directorio";

        $anyo_controller = new AnyoController;
        $asesores_controller = new AsesoresController;
        $soportes_controller = new SoportesController;
        $anunciantes_controller = new AnunciantesController;
        $importes_controller = new ImportesController;

        //1: Obtener nombre de todos los ficheros csv
        $ficheros = array_diff(scandir($path), array('..', '.'));
        $ficheros_csv = array();
        foreach ($ficheros as $fichero) {
            if(str_contains($fichero,'.csv'))
                array_push($ficheros_csv,$fichero);
        }

        //Por cada fichero csv encontrado
        foreach ($ficheros_csv as $fichero) {
            $path = "./$directorio";
            $path .= "/$fichero";

            //2: Primera lectura del fichero para calcular los espacios de los Asesores, Soportes y Anunciantes
            $fila = 0;
            if (($gestor = fopen($path, "r")) !== FALSE) {
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

            //3: Segunda lectura del fichero para extraer las querys necesarias para la base de datos
            $fila = 0;

            if (($gestor = fopen($path, "r")) !== FALSE) {
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

                    //Para las filas de datos, toca diferenciar entre 3 distintas: Asesores, Soporte y Anunciantes para ello, hay que contar el numero de espacios antes de los datos
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
        }
    }
}
