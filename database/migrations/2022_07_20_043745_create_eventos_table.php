<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id('eve_id');
            $table->timestamps();
            $table->date('eve_fecha')->nullable();
            $table->char('eve_tipo')->nullable();
            $table->unsignedBigInteger('eve_presupuesto')->nullable();
            $table->unsignedBigInteger('eve_cliente')->nullable();
            $table->unsignedBigInteger('eve_asesor')->nullable();

            $table->foreign('eve_presupuesto') ->references('pre_id') ->on('presupuestos');
            $table->foreign('eve_cliente') ->references('cli_id') ->on('clientes');
            $table->foreign('eve_asesor') ->references('ase_id') ->on('asesores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eventos');
    }
}
