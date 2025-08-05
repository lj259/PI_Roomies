<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensajePropietario extends Model
{
    use HasFactory;

    protected $table = 'mensajes_propietarios';

    protected $fillable = [
        'usuario_id',
        'propietario_id',
        'apartamento_id',
        'asunto',
        'contenido',
        'emisor_tipo', // 'usuario' o 'propietario'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relación con el usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    // Relación con el propietario
    public function propietario()
    {
        return $this->belongsTo(Propietario::class);
    }

    // Relación con el apartamento
    public function apartamento()
    {
        return $this->belongsTo(Apartamento::class);
    }

    // Scope para obtener mensajes entre un usuario y propietario específicos
    public static function obtenerConversacion($usuarioId, $propietarioId, $apartamentoId = null)
    {
        $query = self::where('usuario_id', $usuarioId)
                    ->where('propietario_id', $propietarioId);
        
        if ($apartamentoId) {
            $query->where('apartamento_id', $apartamentoId);
        }
        
        return $query->orderBy('created_at', 'asc')->get();
    }

    // Método para contar mensajes de un propietario
    public static function contarMensajesPropietario($propietarioId)
    {
        return self::where('propietario_id', $propietarioId)->count();
    }

    // Método para verificar si existe conversación
    public static function tieneConversacion($usuarioId, $propietarioId, $apartamentoId)
    {
        return self::where('usuario_id', $usuarioId)
                  ->where('propietario_id', $propietarioId)
                  ->where('apartamento_id', $apartamentoId)
                  ->exists();
    }
}
