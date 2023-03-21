<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mes extends Model
{
    use HasFactory;

    protected $table = 'mes';
    protected $primaryKey = 'mes_id';

    public $timestamps = false;

    public function importes()
    {
        return $this->hasMany(Importes::class, 'imp_mes');
    }
}
