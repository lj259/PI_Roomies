<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Propietario extends Model {
    use HasFactory;

    protected $table = 'propietarios';

    protected $fillable = [
        'nombre',
        'correo',
        'telefono',
    ];
    public function apartamentos() {
        return $this->hasMany(Apartamento::class, 'propietario_id');
    }

    public function propietario() {
        return $this->belongsTo(Propietario::class, 'propietario_id');
    }
    
}
