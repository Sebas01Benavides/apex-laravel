<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    public $timestamps = false; // Tu migración usa creado_en en lugar de timestamps de Laravel
    protected $fillable = [
        'codigo', 'descripcion', 'categoria', 'marca', 
        'precio', 'costo', 'imagen', 'estado', 'tipo', 'stock', 'creado_en'
    ];

    public function equivalencias()
    {
        return $this->hasMany(Equivalencia::class, 'id_producto');
    }

    public function aplicaciones()
    {
        return $this->hasMany(Aplicacion::class, 'id_producto');
    }
}