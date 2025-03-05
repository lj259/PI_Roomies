<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Apartamento extends Model {
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'direccion',
        'latitud',
        'longitud',
        'precio',
        'habitaciones_disponibles',
        'servicios',
        'imagenes'
    ];

    protected $casts = [
        'servicios' => 'array',
        'imagenes' => 'array',
    ];

    public function propietario(): BelongsTo {
        return $this->belongsTo(Usuario::class, 'propietario_id');
    }
}