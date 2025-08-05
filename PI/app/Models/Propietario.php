<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Propietario extends Authenticatable
{
    use HasFactory;

    protected $table = 'propietarios';

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'correo',
        'contraseña',
        'telefono',
        'genero',
        'foto_perfil',
    ];

    protected $hidden = [
        'contraseña',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function apartamentos()
    {
        return $this->hasMany(Apartamento::class, 'propietario_id');
    }


    // Relación para mensajes con usuarios
    public function mensajesUsuarios()
    {
        return $this->hasMany(MensajePropietario::class);
    }

    public function getAuthPassword() {

        return $this->contraseña;
    }

    // Helper method to get full name
    public function getNombreCompletoAttribute()
    {
        return trim($this->nombre . ' ' . $this->apellido_paterno . ' ' . $this->apellido_materno);
    }

    //Solicitudes pendientes para la parte de solicitudes
    public function getSolicitudesPendientes()
    {
        return Usuario::whereHas('solicitudesArrendamiento', function ($query) {
            $query->whereHas('apartamento', function ($subQuery) {
                $subQuery->where('propietario_id', $this->id);
            })->where('estado', 'pendiente');
        })->distinct()->get();
    }
}
