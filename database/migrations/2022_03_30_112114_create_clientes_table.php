<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('cli_id');
            $table->char('cli_nom')->nullable();
            $table->char('cli_cif')->nullable();
            $table->unsignedBigInteger('cli_age')->nullable();
            $table->char('cli_anu')->nullable();
            $table->char('cli_dir')->nullable();
            $table->char('cli_loc')->nullable();
            $table->char('cli_cp')->nullable();
            $table->char('cli_pro')->nullable();
            $table->char('cli_tel1')->nullable();
            $table->char('cli_mail1')->nullable();
            $table->char('cli_fax')->nullable();
            $table->char('cli_tel2')->nullable();
            $table->char('cli_mail2')->nullable();
            $table->unsignedBigInteger('cli_met_pago')->nullable();
            $table->char('cli_iban')->nullable();
            $table->char('cli_obs_pago')->nullable();
            $table->char('cli_cont_nom')->nullable();
            $table->char('cli_cont_tel')->nullable();
            $table->char('cli_cont_mail')->nullable();
            $table->char('cli_pot_publi')->nullable();
            $table->char('cli_pot_radio')->nullable();
            $table->char('cli_est_dat')->nullable();
            $table->char('cli_est_cli')->nullable();
            $table->date('cli_dateprox')->nullable();
            $table->char('cli_tipo_reunion')->nullable();
            $table->timestamps();

            $table->foreign('cli_age') ->references('ase_id') ->on('asesores');
            $table->foreign('cli_met_pago') ->references('met_pago_id') ->on('metodos_pagos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
