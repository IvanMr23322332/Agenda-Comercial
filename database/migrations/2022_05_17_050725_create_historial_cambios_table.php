<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialCambiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_cambios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hist_cliente')->nullable(false);
            $table->unsignedBigInteger('hist_asesor')->nullable(false);
            $table->char('hist_comentario');
            $table->unsignedBigInteger('hist_presupuesto')->nullable();
            $table->boolean('hist_auto')->default(true);
            $table->timestamps();

            $table->foreign('hist_asesor')      ->references('ase_id')  ->on('asesores');
            $table->foreign('hist_cliente')     ->references('cli_id')  ->on('clientes');
            $table->foreign('hist_presupuesto') ->references('pre_id')  ->on('presupuestos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historial_cambios');
    }
}
