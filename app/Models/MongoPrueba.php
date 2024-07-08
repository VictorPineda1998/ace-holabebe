<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

// use Illuminate\Database\Eloquent\Model as Eloquent;

class MongoPrueba extends Model {

    // Si deseas usar una conexión diferente, puedes especificarla aquí
    protected $connection = 'mongodb';
    
    // Indica la colección de MongoDB que este modelo usará
    protected $collection = 'users';    

    // Los campos que pueden ser asignados masivamente
    protected $fillable = [
        'username', 'email', 'password', 'role'
    ];

    // Los campos que deben ser ocultos en la serialización
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Si estás utilizando las marcas de tiempo de Laravel
    public $timestamps = true;

    // Campos de marca de tiempo personalizados
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
}

// $usuario = new App\Models\MongoPrueba;
// $usuario->username = 'Juan';
// $usuario->email = 'Juan@gmail.com';
// $usuario->password = '123456789';
// $usuario->role = 'Enfermera Clinica';
// $usuario->save();
