<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineaPresupuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('linea_presupuestos', function (Blueprint $table) {
            $table->id('lin_pre_id');
            $table->date('lin_pre_dateini');
            $table->date('lin_pre_datefin');
            $table->unsignedBigInteger('lin_pre_sop');
            $table->unsignedBigInteger('lin_pre_tar');
            $table->unsignedBigInteger('lin_pre_dur');
            $table->unsignedBigInteger('lin_pre_pre');
            $table->integer('lin_pre_ncu');
            $table->integer('lin_pre_lin');
            $table->double('lin_pre_desc');
            $table->double('lin_pre_prec');
            $table->boolean('lin_pre_valido')->nullable();

            $table->foreign('lin_pre_sop') ->references('sop_pre_id') ->on('soportes_presupuestos');
            $table->foreign('lin_pre_tar') ->references('tar_pre_id') ->on('tarifas_presupuestos');
            $table->foreign('lin_pre_dur') ->references('dur_pre_id') ->on('duracion_presupuestos');
            $table->foreign('lin_pre_pre') ->references('pre_id') ->on('presupuestos') ->onDelete('cascade') ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('linea_presupuestos');
    }
}
