<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDuracionPresupuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duracion_presupuestos', function (Blueprint $table) {
            $table->id('dur_pre_id');
            $table->char('dur_pre_nombre');
            $table->integer('dur_pre_value');
        });

        DB::table('duracion_presupuestos')->insert(   array(    'dur_pre_nombre' => '10 sec.' , 'dur_pre_value' => '10'  )   );
        DB::table('duracion_presupuestos')->insert(   array(    'dur_pre_nombre' => '15 sec.' , 'dur_pre_value' => '15'  )   );
        DB::table('duracion_presupuestos')->insert(   array(    'dur_pre_nombre' => '20 sec.' , 'dur_pre_value' => '20'  )   );
        DB::table('duracion_presupuestos')->insert(   array(    'dur_pre_nombre' => 'MICRO 1 min.' , 'dur_pre_value' => '60'  )   );
        DB::table('duracion_presupuestos')->insert(   array(    'dur_pre_nombre' => 'MICRO 3 min.' , 'dur_pre_value' => '180'  )   );
        DB::table('duracion_presupuestos')->insert(   array(    'dur_pre_nombre' => '1 min.' , 'dur_pre_value' => '60'  )   );
        DB::table('duracion_presupuestos')->insert(   array(    'dur_pre_nombre' => '3 min.' , 'dur_pre_value' => '180'  )   );
        DB::table('duracion_presupuestos')->insert(   array(    'dur_pre_nombre' => '1 MES' , 'dur_pre_value' => '1'  )   );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('duracion_presupuestos');
    }
}
