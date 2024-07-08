<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumoHospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'hospitalizacion_id',
        'materiales',
        'medicamentos',
        'guardias_henfermeria',
        'hospitalizacion',
        'honorarios_medicos',
    ];

    public function hospitalizacion()
    {
        return $this->belongsTo(Hospitalizacion::class);
    }
    
}
