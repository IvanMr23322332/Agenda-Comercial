<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricoGestionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_gestiones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hist_gest_cliente');
            $table->unsignedBigInteger('hist_gest_asesor');
            $table->char('hist_gest_tipo')->nullable();
            $table->timestamps();

            $table->foreign('hist_gest_cliente')->references('cli_id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historico_gestiones');
    }
}
