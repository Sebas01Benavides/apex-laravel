<?php

namespace App\Exports;

use App\Models\Pedido;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PedidosExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return Pedido::with('cliente')->get();
    }

    public function headings(): array
    {
        return ['N° Pedido', 'Cliente', 'Fecha', 'Total', 'Estado'];
    }

    public function map($pedido): array
    {
        return [
            $pedido->id,
            $pedido->cliente->nombre ?? 'N/A',
            $pedido->fecha,
            $pedido->total,
            $pedido->estado,
        ];
    }
}