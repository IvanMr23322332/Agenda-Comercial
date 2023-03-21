<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetodosPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metodos_pagos', function (Blueprint $table) {
            $table->id('met_pago_id');
            $table->char('met_pago_orig');
            $table->char('met_pago_desc');
        });

        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'RECIBO BCO. A LA VISTA',        'met_pago_desc' => 'Recibo banco a la vista'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'RECIBO BANCO 10 DIAS F.F.',     'met_pago_desc' => 'Recibo banco 10 días desde fecha factura'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'RECIBO BCO. 30 DIAS F.F.',      'met_pago_desc' => 'Recibo banco 30 días desde fecha factura'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'RECIBO BCO. 45 DIAS F.F.',      'met_pago_desc' => 'Recibo banco 45 días desde fecha factura'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'RECIBO BCO. 60 DIAS F.F.',      'met_pago_desc' => 'Recibo banco 60 días desde fecha factura'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'RECIBO BCO. 90 DIAS F-F-',      'met_pago_desc' => 'Recibo banco 90 días desde fecha factura'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'RECIBO BCO. 120 DIAS F-F-',     'met_pago_desc' => 'Recibo banco 120 días desde fecha factura'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'RECIBO AGENTE',                 'met_pago_desc' => 'Recibo agente'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'RCBO.AGENTE 891',               'met_pago_desc' => 'Recibo agente 891'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'RBO.BCO.30 Y 60 DIAS F.F.',     'met_pago_desc' => 'Recibo banco con vencimiento a 30 y 60 días desde fecha factura'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'COMPENSACION',                  'met_pago_desc' => 'Compesación'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'CONTADO',                       'met_pago_desc' => 'Contado'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'RECIBO BCO.VTO. 15 Y 30',       'met_pago_desc' => 'Recibo banco con vencimiento a 15 y 30 días desde fecha factura'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'RECIBO BCO.VTO.30;60 Y 90',     'met_pago_desc' => 'Recibo banco con vencimiento a 30, 60 y 90 días desde fecha factura'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'RECIBO COBRADOR',               'met_pago_desc' => 'Recibo cobrador'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'REPOSICION 30 DIAS F.F.',       'met_pago_desc' => 'Reposición 30 días desde fecha factura'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'REPOSICION 60 DIAS F.F.',       'met_pago_desc' => 'Reposición 60 días desde fecha factura'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'REPOSICION 90 DIAS F.F.',       'met_pago_desc' => 'Reposición 90 días desde fecha factura'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'REPOSICION 120 DIAS F.F.',      'met_pago_desc' => 'Reposición 120 días desde fecha factura'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'REPOSICION RECEPC. FRA',        'met_pago_desc' => 'Reposición recepción frag'    )   );
        DB::table('metodos_pagos')->insert(   array(    'met_pago_orig' => 'TRANSFERENCIA',                 'met_pago_desc' => 'Transferencia'    )   );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metodos_pagos');
    }
}
