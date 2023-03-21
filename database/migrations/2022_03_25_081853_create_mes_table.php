<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mes', function (Blueprint $table) {
            $table->id('mes_id');
            $table->char('mes_nombre')->nullable(false);

        });

        DB::table('mes')->insert(   array(    'mes_nombre' => 'ENERO'     )   );
        DB::table('mes')->insert(   array(    'mes_nombre' => 'FEBRERO'   )   );
        DB::table('mes')->insert(   array(    'mes_nombre' => 'MARZO'     )   );
        DB::table('mes')->insert(   array(    'mes_nombre' => 'ABRIL'     )   );
        DB::table('mes')->insert(   array(    'mes_nombre' => 'MAYO'      )   );
        DB::table('mes')->insert(   array(    'mes_nombre' => 'JUNIO'     )   );
        DB::table('mes')->insert(   array(    'mes_nombre' => 'JULIO'     )   );
        DB::table('mes')->insert(   array(    'mes_nombre' => 'AGOSTO'    )   );
        DB::table('mes')->insert(   array(    'mes_nombre' => 'SEPTIEMBRE')   );
        DB::table('mes')->insert(   array(    'mes_nombre' => 'OCTUBRE'   )   );
        DB::table('mes')->insert(   array(    'mes_nombre' => 'NOVIEMBRE' )   );
        DB::table('mes')->insert(   array(    'mes_nombre' => 'DICIEMBRE' )   );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mes');
    }
}
