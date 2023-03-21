<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescuentosPresupuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descuentos_presupuestos', function (Blueprint $table) {
            $table->id('des_pre_id');
            $table->double('des_pre_value');
            $table->unsignedBigInteger('des_pre_soporte');
            $table->unsignedBigInteger('des_pre_duracion');

            $table->foreign('des_pre_soporte') ->references('sop_pre_id') ->on('soportes_presupuestos');
            $table->foreign('des_pre_duracion') ->references('dur_pre_id') ->on('duracion_presupuestos');
        });

        DB::table('descuentos_presupuestos')->insert(   array(   'des_pre_value' => '0'     , 'des_pre_soporte' => '1'  , 'des_pre_duracion' => '1' )   );
        DB::table('descuentos_presupuestos')->insert(   array(   'des_pre_value' => '0'     , 'des_pre_soporte' => '1'  , 'des_pre_duracion' => '2' )   );
        DB::table('descuentos_presupuestos')->insert(   array(   'des_pre_value' => '81'    , 'des_pre_soporte' => '1'  , 'des_pre_duracion' => '3' )   );
        DB::table('descuentos_presupuestos')->insert(   array(   'des_pre_value' => '0'     , 'des_pre_soporte' => '1'  , 'des_pre_duracion' => '5' )   );
        DB::table('descuentos_presupuestos')->insert(   array(   'des_pre_value' => '0'     , 'des_pre_soporte' => '2'  , 'des_pre_duracion' => '1' )   );
        DB::table('descuentos_presupuestos')->insert(   array(   'des_pre_value' => '0'     , 'des_pre_soporte' => '2'  , 'des_pre_duracion' => '2' )   );
        DB::table('descuentos_presupuestos')->insert(   array(   'des_pre_value' => '70'    , 'des_pre_soporte' => '2'  , 'des_pre_duracion' => '3' )   );
        DB::table('descuentos_presupuestos')->insert(   array(   'des_pre_value' => '0'     , 'des_pre_soporte' => '2'  , 'des_pre_duracion' => '4' )   );
        DB::table('descuentos_presupuestos')->insert(   array(   'des_pre_value' => '45'    , 'des_pre_soporte' => '3'  , 'des_pre_duracion' => '8' )   );
        DB::table('descuentos_presupuestos')->insert(   array(   'des_pre_value' => '0'     , 'des_pre_soporte' => '4'  , 'des_pre_duracion' => '1' )   );
        DB::table('descuentos_presupuestos')->insert(   array(   'des_pre_value' => '80'    , 'des_pre_soporte' => '4'  , 'des_pre_duracion' => '3' )   );
        DB::table('descuentos_presupuestos')->insert(   array(   'des_pre_value' => '0'     , 'des_pre_soporte' => '4'  , 'des_pre_duracion' => '6' )   );
        DB::table('descuentos_presupuestos')->insert(   array(   'des_pre_value' => '0'     , 'des_pre_soporte' => '4'  , 'des_pre_duracion' => '7' )   );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('descuentos_presupuestos');
    }
}
