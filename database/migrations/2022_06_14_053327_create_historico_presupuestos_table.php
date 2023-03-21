<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricoPresupuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_presupuestos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hist_pres_cliente');
            $table->unsignedBigInteger('hist_pres_presupuesto');
            $table->unsignedBigInteger('hist_pres_asesor');
            $table->char('hist_pres_estado_cliente')->nullable();
            $table->char('hist_pres_estado_presupuesto')->nullable();
            $table->timestamps();

            $table->foreign('hist_pres_cliente')->references('cli_id')->on('clientes');
            $table->foreign('hist_pres_presupuesto')->references('pre_id')->on('presupuestos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historico_presupuestos');
    }
}
