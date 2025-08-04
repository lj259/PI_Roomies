<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'genero',
        'correo',
        'contraseña',
        'telefono',
        'foto_perfil',
        'genero',
        'rol',
        'preferencias_roomie'
    ];

    protected $casts = [
        'preferencias_roomie' => 'array',
    ];

    public function apartamentos(): HasMany
    {
        return $this->hasMany(Apartamento::class, 'propietario_id');
    }

    // Relaciones para amistades
    public function amigosEnviados()
    {
        return $this->hasMany(Amigo::class, 'idUsuario1');
    }

    public function amigosRecibidos()
    {
        return $this->hasMany(Amigo::class, 'idUsuario2');
    }

    // Relaciones para mensajes
    public function mensajesEnviados()
    {
        return $this->hasMany(Mensaje::class, 'emisor_id');
    }

    public function mensajesRecibidos()
    {
        return $this->hasMany(Mensaje::class, 'receptor_id');
    }

    // Obtener todos los amigos aceptados
    public function getAmigosAttribute()
    {
        return Amigo::getAmigosAceptados($this->id);
    }

    public function getAuthPassword()
    {
        return $this->contraseña;
    }

    public function solicitudesArrendamiento()
    {
        return $this->hasMany(Soli_arrendamiento::class, 'usuario_id');
    }

}
