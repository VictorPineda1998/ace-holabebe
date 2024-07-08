<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospitalizacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'habitacion',
        'servicio',
        'procedimiento',
        'fecha_alta',
        'dietas',        
        'medico_tratante',
        'paciente_id',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}
