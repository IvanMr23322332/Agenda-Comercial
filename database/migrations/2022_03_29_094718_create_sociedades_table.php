<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSociedadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sociedades', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->char('soc_nom');
            $table->char('soc_cif');
            $table->char('soc_dir');
            $table->char('soc_cp');
            $table->char('soc_loc');
            $table->char('soc_pro');
            $table->char('soc_tlf');

        });

        DB::table('sociedades')->insert(   array(    'soc_nom' => 'Iniciativas de Publicidad General, S. L.',   'soc_cif' => 'B03486081',    'soc_dir' => 'C/Doctor Caro 43',   'soc_cp' => '03201',   'soc_loc' => 'Elche',   'soc_pro' => 'Alicante',    'soc_tlf' => '965443111' )   );
        DB::table('sociedades')->insert(   array(    'soc_nom' => 'Radio Elche, S. L. ',                        'soc_cif' => 'B53845426',    'soc_dir' => 'C/Doctor Caro 43',   'soc_cp' => '03201',   'soc_loc' => 'Elche',   'soc_pro' => 'Alicante',    'soc_tlf' => '965443111' )   );
        DB::table('sociedades')->insert(   array(    'soc_nom' => 'Radio Comunicación, S. A. ',                 'soc_cif' => 'A03273679',    'soc_dir' => 'C/Doctor Caro 43',   'soc_cp' => '03201',   'soc_loc' => 'Elche',   'soc_pro' => 'Alicante',    'soc_tlf' => '965443111' )   );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sociedades');
    }
}
