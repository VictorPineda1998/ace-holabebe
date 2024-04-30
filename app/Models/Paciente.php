<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido_P',
        'apellido_M',
        'fecha_nacimiento',
        'telefono',
        'edad',
        'lugar_procedencia',
        'user_id',
    ];
}
