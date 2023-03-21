<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsesoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asesores', function (Blueprint $table) {
            $table->id('ase_id');
            $table->char('ase_nombre')->nullable(false)->unique();
            $table->char('ase_canal')->nullable(true);

        });

        DB::table('asesores')->insert(array('ase_id' => '1',  'ase_nombre' => 'ADMINISTRADOR'));

        DB::table('asesores')->insert(array('ase_id' => '2',    'ase_nombre' => 'RADIO ELCHE'));
        DB::table('asesores')->insert(array('ase_id' => '3',    'ase_nombre' => 'DOMINGO CANDELA BOIX'));
        DB::table('asesores')->insert(array('ase_id' => '4',    'ase_nombre' => 'VERONICA FENOLL'));
        DB::table('asesores')->insert(array('ase_id' => '5',    'ase_nombre' => 'LLUNA SANCHEZ'));
        DB::table('asesores')->insert(array('ase_id' => '6',    'ase_nombre' => 'PATRICIA BRISA'));
        DB::table('asesores')->insert(array('ase_id' => '7',    'ase_nombre' => 'PABLO LATORRE'));
        DB::table('asesores')->insert(array('ase_id' => '8',    'ase_nombre' => 'MARCELO GARRIGOS'));



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asesores');
    }
}
