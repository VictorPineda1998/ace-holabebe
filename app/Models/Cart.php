<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['hospitalizacion_id', 'items'];

    protected $casts = [
        'items' => 'array',
    ];

    public function hospitalizacion()
    {
        return $this->belongsTo(Hospitalizacion::class);
    }
}
