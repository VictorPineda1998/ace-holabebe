<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_consulta',
        'paciente_id',
        'triaje_id',
    ];

    public function paciente()
{
    return $this->belongsTo(Paciente::class, 'paciente_id');
}
public function triaje()
{
    return $this->belongsTo(Triaje::class, 'triaje_id');
}
}
