<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('importes', function (Blueprint $table) {
            $table->id('imp_id');

            $table->unsignedBigInteger('imp_anyo');
            $table->unsignedBigInteger('imp_mes');
            $table->unsignedBigInteger('imp_ase');
            $table->unsignedBigInteger('imp_sop');
            $table->unsignedBigInteger('imp_anu');
            $table->double('imp_importe');

            $table->foreign('imp_anyo') ->references('anyo_id') ->on('anyo');
            $table->foreign('imp_mes')  ->references('mes_id')  ->on('mes');
            $table->foreign('imp_ase')  ->references('ase_id')  ->on('asesores');
            $table->foreign('imp_sop')  ->references('sop_id')  ->on('soportes');
            $table->foreign('imp_anu')  ->references('anu_id')  ->on('anunciantes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('importes');
    }
}
