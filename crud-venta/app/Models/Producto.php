<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // Estos son los campos que Laravel permite asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'telefono',
        'imagen_url',
    ];
}