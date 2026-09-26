<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equivalencia extends Model
{
    protected $table = 'equivalencias';
    protected $fillable = ['id_producto', 'codigo_equivalente', 'marca_equivalente'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}