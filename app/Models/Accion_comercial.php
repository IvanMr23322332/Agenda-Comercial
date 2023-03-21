<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accion_comercial extends Model
{
    use HasFactory;

    protected $table = 'accion_comercial';
    protected $primaryKey = 'acc_com_id';

    public $timestamps = false;
}
