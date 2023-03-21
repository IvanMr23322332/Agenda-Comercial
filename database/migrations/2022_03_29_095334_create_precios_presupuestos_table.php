<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreciosPresupuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precios_presupuestos', function (Blueprint $table) {
            $table->id('pre_pre_id');
            $table->double('pre_pre_value');
            $table->unsignedBigInteger('pre_pre_tarifa');
            $table->unsignedBigInteger('pre_pre_duracion');

            $table->foreign('pre_pre_tarifa') ->references('tar_pre_id') ->on('tarifas_presupuestos');
            $table->foreign('pre_pre_duracion') ->references('dur_pre_id') ->on('duracion_presupuestos');
        });

        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '68.75'  , 'pre_pre_tarifa' => '1'  , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '93.75'  , 'pre_pre_tarifa' => '1'  , 'pre_pre_duracion' => '2' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '125'    , 'pre_pre_tarifa' => '1'  , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '303.26' , 'pre_pre_tarifa' => '1'  , 'pre_pre_duracion' => '5' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '63.25'  , 'pre_pre_tarifa' => '2'  , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '86.25'  , 'pre_pre_tarifa' => '2'  , 'pre_pre_duracion' => '2' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '115'    , 'pre_pre_tarifa' => '2'  , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '2'  , 'pre_pre_duracion' => '5' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '58.30'  , 'pre_pre_tarifa' => '3'  , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '79.50'  , 'pre_pre_tarifa' => '3'  , 'pre_pre_duracion' => '2' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '106'    , 'pre_pre_tarifa' => '3'  , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '3'  , 'pre_pre_duracion' => '5' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '37.40'  , 'pre_pre_tarifa' => '4'  , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '51'     , 'pre_pre_tarifa' => '4'  , 'pre_pre_duracion' => '2' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '68'     , 'pre_pre_tarifa' => '4'  , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '4'  , 'pre_pre_duracion' => '5' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '42.35'  , 'pre_pre_tarifa' => '5'  , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '57.75'  , 'pre_pre_tarifa' => '5'  , 'pre_pre_duracion' => '2' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '77'     , 'pre_pre_tarifa' => '5'  , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '5'  , 'pre_pre_duracion' => '5' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '51.70'  , 'pre_pre_tarifa' => '6'  , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '70.50'  , 'pre_pre_tarifa' => '6'  , 'pre_pre_duracion' => '2' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '94'     , 'pre_pre_tarifa' => '6'  , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '6'  , 'pre_pre_duracion' => '5' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '35.75'  , 'pre_pre_tarifa' => '7'  , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '48.75'  , 'pre_pre_tarifa' => '7'  , 'pre_pre_duracion' => '2' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '65'     , 'pre_pre_tarifa' => '7'  , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '7'  , 'pre_pre_duracion' => '5' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '42.35'  , 'pre_pre_tarifa' => '8'  , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '57.75'  , 'pre_pre_tarifa' => '8'  , 'pre_pre_duracion' => '2' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '77'     , 'pre_pre_tarifa' => '8'  , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '8'  , 'pre_pre_duracion' => '5' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '37.40'  , 'pre_pre_tarifa' => '9'  , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '51'     , 'pre_pre_tarifa' => '9'  , 'pre_pre_duracion' => '2' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '68'     , 'pre_pre_tarifa' => '9'  , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '9'  , 'pre_pre_duracion' => '5' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '47.30'  , 'pre_pre_tarifa' => '10' , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '64.50'  , 'pre_pre_tarifa' => '10' , 'pre_pre_duracion' => '2' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '86'     , 'pre_pre_tarifa' => '10' , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '10' , 'pre_pre_duracion' => '5' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '37.40'  , 'pre_pre_tarifa' => '11' , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '51'     , 'pre_pre_tarifa' => '11' , 'pre_pre_duracion' => '2' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '68'     , 'pre_pre_tarifa' => '11' , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '11' , 'pre_pre_duracion' => '5' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '34.10'  , 'pre_pre_tarifa' => '12' , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '46.50'  , 'pre_pre_tarifa' => '12' , 'pre_pre_duracion' => '2' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '62'     , 'pre_pre_tarifa' => '12' , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '12' , 'pre_pre_duracion' => '5' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '42.90'  , 'pre_pre_tarifa' => '13' , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '58.50'  , 'pre_pre_tarifa' => '13' , 'pre_pre_duracion' => '2' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '78'     , 'pre_pre_tarifa' => '13' , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '137.90' , 'pre_pre_tarifa' => '13' , 'pre_pre_duracion' => '4' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '37.40'  , 'pre_pre_tarifa' => '14' , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '51'     , 'pre_pre_tarifa' => '14' , 'pre_pre_duracion' => '2' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '68'     , 'pre_pre_tarifa' => '14' , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '14' , 'pre_pre_duracion' => '4' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '32.45'  , 'pre_pre_tarifa' => '15' , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '44.25'  , 'pre_pre_tarifa' => '15' , 'pre_pre_duracion' => '2' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '59'     , 'pre_pre_tarifa' => '15' , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '15' , 'pre_pre_duracion' => '4' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '29.15'  , 'pre_pre_tarifa' => '16' , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '39.75'  , 'pre_pre_tarifa' => '16' , 'pre_pre_duracion' => '2' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '53'     , 'pre_pre_tarifa' => '16' , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '16' , 'pre_pre_duracion' => '4' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '28.60'  , 'pre_pre_tarifa' => '17' , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '39'     , 'pre_pre_tarifa' => '17' , 'pre_pre_duracion' => '2' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '52'     , 'pre_pre_tarifa' => '17' , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '17' , 'pre_pre_duracion' => '4' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '20' , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '70'     , 'pre_pre_tarifa' => '20' , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '20' , 'pre_pre_duracion' => '6' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '20' , 'pre_pre_duracion' => '7' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '21' , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '75'     , 'pre_pre_tarifa' => '21' , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '21' , 'pre_pre_duracion' => '6' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '21' , 'pre_pre_duracion' => '7' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '22' , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '125'    , 'pre_pre_tarifa' => '22' , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '22' , 'pre_pre_duracion' => '6' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '22' , 'pre_pre_duracion' => '7' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '23' , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '160'    , 'pre_pre_tarifa' => '23' , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '23' , 'pre_pre_duracion' => '6' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '23' , 'pre_pre_duracion' => '7' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '30'     , 'pre_pre_tarifa' => '24' , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '24' , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '24' , 'pre_pre_duracion' => '6' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '24' , 'pre_pre_duracion' => '7' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '25' , 'pre_pre_duracion' => '1' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '-1'     , 'pre_pre_tarifa' => '25' , 'pre_pre_duracion' => '3' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '110'    , 'pre_pre_tarifa' => '25' , 'pre_pre_duracion' => '6' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '165'    , 'pre_pre_tarifa' => '25' , 'pre_pre_duracion' => '7' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '9.67'    , 'pre_pre_tarifa' => '18' , 'pre_pre_duracion' => '8' )   );
        DB::table('precios_presupuestos')->insert(   array(   'pre_pre_value' => '15'    , 'pre_pre_tarifa' => '19' , 'pre_pre_duracion' => '8' )   );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('precios_presupuestos');
    }
}
