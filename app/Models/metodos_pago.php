<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class metodos_pago extends Model
{
    use HasFactory;

    protected $table = 'metodos_pagos';
    protected $primaryKey = 'met_pago_id';
}
