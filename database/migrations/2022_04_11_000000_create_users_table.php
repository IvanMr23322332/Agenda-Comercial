<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->char('user_name')->nullable(false);
            $table->char('user_mail')->nullable(false)->unique();
            $table->char('user_pass')->nullable(false);
            $table->unsignedBigInteger('user_ase')->nullable(true);

            $table->foreign('user_ase')   ->references('ase_id')  ->on('asesores');
        });

        DB::table('users')->insert(array('user_name' => 'ADMINISTRADOR',        'user_mail' => 'admin@admin.com',           'user_pass' => 'admin', 'user_ase' => '1'));

        DB::table('users')->insert(array('user_name' => 'RADIO ELCHE',          'user_mail' => 'radio@elche.com',           'user_pass' => '1234',  'user_ase' => '2'));
        DB::table('users')->insert(array('user_name' => 'DOMINGO CANDELA BOIX', 'user_mail' => 'dcandela@radioelche.com',   'user_pass' => '1234',  'user_ase' => '3'));
        DB::table('users')->insert(array('user_name' => 'VERONICA FENOLL',      'user_mail' => 'vfenoll@radioelche.com',    'user_pass' => '1234',  'user_ase' => '4'));
        DB::table('users')->insert(array('user_name' => 'LLUNA SANCHEZ',        'user_mail' => 'lsanchez@radioelche.com',   'user_pass' => '1234',  'user_ase' => '5'));
        DB::table('users')->insert(array('user_name' => 'PATRICIA BRISA',       'user_mail' => 'pbrisa@radioelche.com',     'user_pass' => '1234',  'user_ase' => '6'));
        DB::table('users')->insert(array('user_name' => 'PABLO LATORRE',        'user_mail' => 'platorre@radioelche.com',   'user_pass' => '1234',  'user_ase' => '7'));
        DB::table('users')->insert(array('user_name' => 'MARCELO GARRIGOS',     'user_mail' => 'mgarrigos@radioelche.com',  'user_pass' => '1234',  'user_ase' => '8'));



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
