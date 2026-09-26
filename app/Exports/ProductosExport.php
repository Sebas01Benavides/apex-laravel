<?php

namespace App\Exports;

use App\Models\Producto;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductosExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return Producto::all();
    }

    public function headings(): array
    {
        return ['ID', 'Código', 'Descripción', 'Categoría', 'Marca', 'Precio', 'Stock', 'Estado'];
    }

    public function map($producto): array
    {
        return [
            $producto->id,
            $producto->codigo,
            $producto->descripcion,
            $producto->categoria,
            $producto->marca,
            $producto->precio,
            $producto->stock,
            $producto->estado,
        ];
    }
}