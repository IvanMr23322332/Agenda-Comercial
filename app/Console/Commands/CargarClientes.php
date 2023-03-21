<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ClientesController;

class CargarClientes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cargar:clientes{directorio}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando utilizado para cargar los ficheros csv de clientes en la base de datos';

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

        $cliente = new ClientesController;

        //1: Obtener nombre de todos los ficheros csv
        $ficheros = array_diff(scandir($path), array('..', '.'));
        $ficheros_csv = array();
        foreach ($ficheros as $fichero) {
            if(str_contains($fichero,'.csv'))
                array_push($ficheros_csv,$fichero);
        }

        //Por cada fichero encontrado leemos datos e insertamos
        foreach ($ficheros_csv as $fichero) {
            $path = "./$directorio";
            $path .= "/$fichero";
            if (($gestor = fopen($path, "r")) !== FALSE) {
                $fila = 0;
                $datos = fgetcsv($gestor, 10000, ";");
                while (($datos = fgetcsv($gestor, 10000, ";")) !== FALSE) {
                    $fila ++;
                    //print_r($datos);

                    $cliente -> insertCliente($datos);
                }
            }
        }



        return Command::SUCCESS;
    }
}
