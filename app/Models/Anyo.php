<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anyo extends Model
{
    use HasFactory;

    protected $table = 'anyo';
    protected $primaryKey = 'anyo_id';

    public $timestamps = false;
}
