<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class MongoHospitalizacion extends Model
{
    
    protected $connection = 'mongodb';
    
    protected $collection = 'hospitalizacions'; 
    
    // protected $collection = 'ucins'; 
    
}
