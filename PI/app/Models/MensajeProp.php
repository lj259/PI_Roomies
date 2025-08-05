<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensajeProp extends Model
{
    protected $table = 'mensajes_props';
    
    protected $fillable = [
        'emisor_id',
        'receptor_id',
        'contenido'
    ];

    public function emisor()
    {
        return $this->belongsTo(Usuario::class, 'emisor_id');
    }

    public function receptor()
    {
        return $this->belongsTo(Propietario::class, 'receptor_id');
    }
}
