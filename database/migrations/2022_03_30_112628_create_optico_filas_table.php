<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpticoFilasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('optico_filas', function (Blueprint $table) {
            $table->id('opt_fil_id');
            $table->boolean('opt_fil_isdata');
            $table->unsignedBigInteger('opt_fil_lin')->nullable();
            $table->unsignedBigInteger('opt_fil_pre');
            $table->unsignedBigInteger('opt_fil_mes');
            $table->integer('opt_fil_anyo');
            $table->unsignedBigInteger('opt_fil_sop')->nullable();
            $table->unsignedBigInteger('opt_fil_tar')->nullable();
            $table->unsignedBigInteger('opt_fil_dur')->nullable();
            $table->char('opt_fil_mat')->nullable();
            $table->char('opt_fil_hora')->nullable();
            $table->char('opt_fil_data1');
            $table->char('opt_fil_data2');
            $table->char('opt_fil_data3');
            $table->char('opt_fil_data4');
            $table->char('opt_fil_data5');
            $table->char('opt_fil_data6');
            $table->char('opt_fil_data7');
            $table->char('opt_fil_data8');
            $table->char('opt_fil_data9');
            $table->char('opt_fil_data10');
            $table->char('opt_fil_data11');
            $table->char('opt_fil_data12');
            $table->char('opt_fil_data13');
            $table->char('opt_fil_data14');
            $table->char('opt_fil_data15');
            $table->char('opt_fil_data16');
            $table->char('opt_fil_data17');
            $table->char('opt_fil_data18');
            $table->char('opt_fil_data19');
            $table->char('opt_fil_data20');
            $table->char('opt_fil_data21');
            $table->char('opt_fil_data22');
            $table->char('opt_fil_data23');
            $table->char('opt_fil_data24');
            $table->char('opt_fil_data25');
            $table->char('opt_fil_data26');
            $table->char('opt_fil_data27');
            $table->char('opt_fil_data28');
            $table->char('opt_fil_data29');
            $table->char('opt_fil_data30');
            $table->char('opt_fil_data31');
            $table->integer('opt_fil_datauds')->nullable();

            $table->foreign('opt_fil_mes')   ->references('mes_id')  ->on('mes');
            $table->foreign('opt_fil_sop')   ->references('sop_pre_id') ->on('soportes_presupuestos');
            $table->foreign('opt_fil_tar')   ->references('tar_pre_id') ->on('tarifas_presupuestos');
            $table->foreign('opt_fil_dur')   ->references('dur_pre_id') ->on('duracion_presupuestos');
            $table->foreign('opt_fil_pre')   ->references('pre_id') ->on('presupuestos') ->onDelete('cascade') ->onUpdate('cascade');
            $table->foreign('opt_fil_lin')   ->references('lin_pre_id') ->on('linea_presupuestos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('optico_filas');
    }
}
