<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model {
    use HasFactory;

    protected $fillable = [
        'remitente_id',
        'receptor_id',
        'mensaje'
    ];

    public function remitente() {
        return $this->belongsTo(Usuario::class, 'remitente_id');
    }

    public function receptor() {
        return $this->belongsTo(Usuario::class, 'receptor_id');
    }
}
