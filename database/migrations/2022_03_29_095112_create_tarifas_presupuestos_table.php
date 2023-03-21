<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTarifasPresupuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarifas_presupuestos', function (Blueprint $table) {
            $table->id('tar_pre_id');
            $table->char('tar_pre_nombre')->nullable(false);
            $table->unsignedBigInteger('tar_pre_soporte');

            $table->foreign('tar_pre_soporte') ->references('sop_pre_id') ->on('soportes_presupuestos');
        });

        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'HOY POR HOY (06-10)' , 'tar_pre_soporte' => '1'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'HOY POR HOY (10-12)' , 'tar_pre_soporte' => '1'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'HORA 14' , 'tar_pre_soporte' => '1'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'LA VENTANA' , 'tar_pre_soporte' => '1'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'HORA 25' , 'tar_pre_soporte' => '1'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'EL LARGUERO' , 'tar_pre_soporte' => '1'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'CARRUSEL' , 'tar_pre_soporte' => '1'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'A VIVIR' , 'tar_pre_soporte' => '1'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'PROG. LOCAL' , 'tar_pre_soporte' => '1'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'ROT. L a V' , 'tar_pre_soporte' => '1'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'ROT. S y D' , 'tar_pre_soporte' => '1'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'RESTO PROG.' , 'tar_pre_soporte' => '1'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'ANDA YA' , 'tar_pre_soporte' => '2'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'DEL 40 AL 1' , 'tar_pre_soporte' => '2'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'LUNES a VIERNES' , 'tar_pre_soporte' => '2'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'ROT. L a D' , 'tar_pre_soporte' => '2'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'RESTO PROG.' , 'tar_pre_soporte' => '2'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'ALQUILER VALLA 8X3' , 'tar_pre_soporte' => '3'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'IMP. y COLOC. VINILO' , 'tar_pre_soporte' => '3'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'SPOT 10 a 14 h.' , 'tar_pre_soporte' => '4'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'SPOT 14 a 21 h.' , 'tar_pre_soporte' => '4'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'SPOT 21 a 24 h.' , 'tar_pre_soporte' => '4'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'SPOT INFOR. 21 h.' , 'tar_pre_soporte' => '4'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'SOBREIMPRESION' , 'tar_pre_soporte' => '4'  )   );
        DB::table('tarifas_presupuestos')->insert(   array(    'tar_pre_nombre' => 'PUBLIRREPORTAJE' , 'tar_pre_soporte' => '4'  )   );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarifas_presupuestos');
    }
}
