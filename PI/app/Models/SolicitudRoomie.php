<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudRoomie extends Model {
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'apartamento_id',
        'estado',
        'mensaje'
    ];

    public function usuario() {
        return $this->belongsTo(Usuario::class);
    }

    public function apartamento() {
        return $this->belongsTo(Apartamento::class);
    }
}
