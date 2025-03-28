<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    protected $fillable = [
        'emisor_id', 
        'receptor_id', 
        'contenido',
    ];

    // Definir la relación con el modelo User (emisor)
    public function emisor()
    {
        return $this->belongsTo(User::class, 'emisor_id');
    }

    // Definir la relación con el modelo User (receptor)
    public function receptor()
    {
        return $this->belongsTo(User::class, 'receptor_id');
    }
}
