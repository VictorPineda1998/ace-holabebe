<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Triaje extends Model
{
    use HasFactory;

    protected $fillable = [
        'observaciones',
        'interrogatorio',
        'signos_vitales',
        'bienestar_fetal',
        'toma_signos_vitales',
        'resultado',
        'consulta_id',
        'usuario_id',
    ];
}
