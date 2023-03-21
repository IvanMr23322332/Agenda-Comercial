<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->id('pre_id');
            $table->double('pre_fact_anu')->nullable();
            $table->double('pre_antig')->nullable();
            $table->boolean('pre_pront_pago')->nullable();
            $table->unsignedBigInteger('pre_acc_com')->nullable();
            $table->char('pre_estado');
            $table->double('pre_tot_brut');
            $table->double('pre_tot_desc');
            $table->double('pre_tot_neto');
            $table->date('pre_dateini');
            $table->date('pre_datefin');
            $table->char('pre_motivo_rechazo')->nullable();
            $table->char('acc_com_name')->nullable();
            $table->char('acc_com_tipo')->nullable();
            $table->unsignedBigInteger('pre_soc')->nullable();
            $table->char('pre_emisora')->nullable();
            $table->unsignedBigInteger('pre_cliente')->nullable();
            $table->boolean('pre_valido')->nullable();
            $table->boolean('pre_pago_valido')->nullable();
            $table->unsignedBigInteger('pre_creador')->nullable();
            $table->date('pre_dateprox')->nullable();
            $table->char('pre_observ')->nullable();
            $table->timestamps();

            $table->foreign('pre_cliente')->references('cli_id')->on('clientes');
            $table->foreign('pre_soc')->references('id')->on('sociedades');
            $table->foreign('pre_creador')->references('ase_id')->on('asesores');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presupuestos');
    }
}
