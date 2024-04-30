<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colposcopia extends Model
{
    use HasFactory;

    protected $fillable = [
        'ahf',
        'app',
        'ago',
        'ago2',
        'ruta',
        'consulta_id',
    ];
}
