<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Mensaje extends Model
{
    use HasFactory;

    protected $fillable = [
        'emisor_id', 
        'receptor_id', 
        'contenido',
        'read_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime'
    ];

    // Definir la relación con el modelo Usuario (emisor)
    public function emisor()
    {
        return $this->belongsTo(Usuario::class, 'emisor_id');
    }

    // Definir la relación con el modelo Usuario (receptor)
    public function receptor()
    {
        return $this->belongsTo(Usuario::class, 'receptor_id');
    }

    // Check if message is read
    public function isRead()
    {
        return !is_null($this->read_at);
    }

    // Mark message as read
    public function markAsRead()
    {
        $this->read_at = now();
        $this->save();
    }

    // Scope for unread messages
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    // Scope for messages between two users
    public function scopeBetweenUsers($query, $user1, $user2)
    {
        return $query->where(function($q) use ($user1, $user2) {
            $q->where('emisor_id', $user1)->where('receptor_id', $user2);
        })->orWhere(function($q) use ($user1, $user2) {
            $q->where('emisor_id', $user2)->where('receptor_id', $user1);
        });
    }
}
