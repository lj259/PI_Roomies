<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Authenticatable 
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'correo',
        'contraseña',
        'telefono',
        'foto_perfil',
        'descripcion',
        'preferencias_roomie'
    ];

    protected $casts = [
        'preferencias_roomie' => 'array',
    ];

    public function apartamentos(): HasMany {
        return $this->hasMany(Apartamento::class, 'propietario_id');
    }
}
