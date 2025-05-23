<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sugerencia extends Model
{
    //
    protected $fillable = ['solicitante', 'titulo', 'descripcion', 'departamento', 'estado'];
    protected $table='sugerencias';
}
