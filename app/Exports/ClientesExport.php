<?php

namespace App\Exports;

use App\Models\Cliente;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClientesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return Cliente::all();
    }

    public function headings(): array
    {
        return ['ID', 'Nombre', 'Identificación', 'Correo', 'Teléfono'];
    }

    public function map($cliente): array
    {
        return [
            $cliente->id,
            $cliente->nombre,
            $cliente->identificacion,
            $cliente->correo,
            $cliente->telefono ?? 'N/A',
        ];
    }
}