<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aplicacion extends Model
{
    protected $table = 'aplicaciones';
    protected $fillable = ['id_producto', 'vehiculo', 'motor', 'anio', 'oem', 'observacion'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}