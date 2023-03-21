<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anunciantes extends Model
{
    use HasFactory;

    protected $table = 'anunciantes';
    protected $primaryKey = 'anu_id';

    public $timestamps = false;
}
