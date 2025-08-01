<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amigo extends Model
{
    use HasFactory;

    protected $fillable = [
        'idUsuario1',
        'idUsuario2', 
        'estatus'
    ];

    // Relación con el usuario que envía la solicitud
    public function usuario1()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario1', 'id');
    }

    // Relación con el usuario que recibe la solicitud
    public function usuario2()
    {
        return $this->belongsTo(Usuario::class, 'idUsuario2', 'id');
    }

    // Obtener amigos aceptados para un usuario
    public static function getAmigosAceptados($usuarioId)
    {
        return self::where('estatus', 'aceptado')
            ->where(function ($query) use ($usuarioId) {
                $query->where('idUsuario1', $usuarioId)
                      ->orWhere('idUsuario2', $usuarioId);
            })
            ->with(['usuario1', 'usuario2'])
            ->get()
            ->map(function ($amigo) use ($usuarioId) {
                return $amigo->idUsuario1 == $usuarioId ? $amigo->usuario2 : $amigo->usuario1;
            });
    }

    // Verificar si dos usuarios son amigos
    public static function sonAmigos($usuario1Id, $usuario2Id)
    {
        return self::where('estatus', 'aceptado')
            ->where(function ($query) use ($usuario1Id, $usuario2Id) {
                $query->where(function ($q) use ($usuario1Id, $usuario2Id) {
                    $q->where('idUsuario1', $usuario1Id)
                      ->where('idUsuario2', $usuario2Id);
                })->orWhere(function ($q) use ($usuario1Id, $usuario2Id) {
                    $q->where('idUsuario1', $usuario2Id)
                      ->where('idUsuario2', $usuario1Id);
                });
            })
            ->exists();
    }

    // Obtener solicitudes pendientes para un usuario
    public static function getSolicitudesPendientes($usuarioId)
    {
        return self::where('idUsuario2', $usuarioId)
            ->where('estatus', 'pendiente')
            ->with('usuario1')
            ->get();
    }
}
