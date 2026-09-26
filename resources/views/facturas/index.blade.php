@extends('layouts.app')

@section('title', 'Facturación - ApexGestion')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-file-invoice-dollar me-2 text-primary"></i>Módulo de Facturación</h2>
        <a href="{{ route('facturas.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i> Generar Factura
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>N° Factura</th>
                            <th>N° Pedido</th>
                            <th>Cliente</th>
                            <th>Fecha Factura</th>
                            <th>Monto Total</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($facturas as $factura)
                        <tr>
                            <td><strong>FACT-{{ str_pad($factura->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                            <td>#{{ $factura->id_pedido }}</td>
                            <td>{{ $factura->pedido->cliente->nombre ?? 'N/A' }}</td>
                            <td>{{ $factura->fecha_factura }}</td>
                            <td>${{ number_format($factura->monto, 2) }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-sm btn-info text-white me-1">
                                    <i class="fa-solid fa-eye"></i> Ver Factura
                                </a>
                                <form action="{{ route('facturas.destroy', $factura->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Anular esta factura?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa-solid fa-trash"></i> Anular
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No hay facturas emitidas aún.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection