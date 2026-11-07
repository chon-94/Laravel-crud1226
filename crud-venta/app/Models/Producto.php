<?php
// ↑ Etiqueta de apertura PHP. OBLIGATORIA. Sin esto, el archivo se sirve como texto.

namespace App\Models;
// ↑ Namespace de la clase. Se mapea a la carpeta app/Models/ (PSR-4).
//   Evita colisiones de nombres y permite el autoloading de Composer.

use Illuminate\Database\Eloquent\Model;
// ↑ Importa la clase base de Eloquent.
//   Al extender de ella, la clase hereda: consultas, persistencia,
//   timestamps, relaciones, serialización, eventos, etc.

class Producto extends Model
// ↑ Declara la clase Producto y la convierte en un modelo Eloquent.
//   Convenciones que Laravel deduce del nombre:
//     • Tabla:      productos             (plural, snake_case)
//     • Clave:      id                    (entero autoincremental)
//     • Timestamps: created_at, updated_at
{
    // Lista blanca de campos asignables en masa (mass assignment).
    // Protección contra la vulnerabilidad de mass assignment.
    protected $fillable = [
        'nombre',      // string  → nombre visible del producto
        'descripcion', // text    → descripción larga (puede ser null)
        'precio',      // decimal → precio con 2 decimales
        'telefono',    // string  → contacto para WhatsApp
        'imagen_url',  // string  → URL o ruta de la imagen
    ];
}
