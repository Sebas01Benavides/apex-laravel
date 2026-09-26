<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'usuario',
        'contrasena',
        'rol',
    ];

    protected $hidden = [
        'contrasena',
    ];

    // Indicar a Laravel que la clave primaria o campo de contraseña se llama contrasena
    public function getAuthPassword()
    {
        return $this->contrasena;
    }
}