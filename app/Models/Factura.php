<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';
    protected $fillable = ['id_pedido', 'fecha_factura', 'monto'];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }
}