<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Soli_arrendamiento extends Model
{
    use HasFactory;
    protected $table = 'solicitud_arrendamiento';

    protected $fillable = ['usuario_id', 'apartamento_id', 'estado', 'mensaje_usuario', 'mensaje_respuesta'];

    protected $hidden = ['created_at', 'updated_at'];

    // Añadir relaciones (recomendado)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function apartamento()
    {
        return $this->belongsTo(Apartamento::class, 'apartamento_id');
    }
}
