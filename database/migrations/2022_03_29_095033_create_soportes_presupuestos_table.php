<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoportesPresupuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soportes_presupuestos', function (Blueprint $table) {
            $table->id('sop_pre_id');
            $table->char('sop_pre_nombre')->nullable(false)->unique();
        });

        DB::table('soportes_presupuestos')->insert(   array(    'sop_pre_nombre' => 'CADENA SER'     )   );
        DB::table('soportes_presupuestos')->insert(   array(    'sop_pre_nombre' => 'LOS 40 ELCHE'   )   );
        DB::table('soportes_presupuestos')->insert(   array(    'sop_pre_nombre' => 'VALLAS PUBLICITARIAS'     )   );
        DB::table('soportes_presupuestos')->insert(   array(    'sop_pre_nombre' => 'ELCHE 7TV'     )   );
        DB::table('soportes_presupuestos')->insert(   array(    'sop_pre_nombre' => 'WEB'     )   );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soportes_presupuestos');
    }
}
