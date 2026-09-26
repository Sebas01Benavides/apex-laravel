@extends('layouts.app')

@section('title', 'Factura FACT-' . str_pad($factura->id, 5, '0', STR_PAD_LEFT) . ' - ApexGestion')

@section('content')
<div class="container" style="max-width: 800px;">
    <div class="card border-0 shadow-sm p-4 bg-white">
        <!-- Encabezado de la Factura -->
        <div class="d-flex justify-content-between border-bottom pb-3 mb-4">
            <div>
                <h2 class="text-primary fw-bold mb-0"><i class="fa-solid fa-boxes-stacked me-2"></i>ApexGestion</h2>
                <small class="text-muted">Sistema de Gestión de Repuestos y Productos</small>
            </div>
            <div class="text-end">
                <h4 class="fw-bold text-dark mb-0">FACTURA</h4>
                <p class="text-danger fw-bold mb-0">N° FACT-{{ str_pad($factura->id, 5, '0', STR_PAD_LEFT) }}</p>
                <small class="text-muted">Fecha: {{ $factura->fecha_factura }}</small>
            </div>
        </div>

        <!-- Datos del Cliente y Pedido -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-uppercase text-muted small fw-bold">Facturado A:</h6>
                <p class="mb-1"><strong>Cliente:</strong> {{ $factura->pedido->cliente->nombre ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Identificación:</strong> {{ $factura->pedido->cliente->identificacion ?? 'N/A' }}</p>
                <p class="mb-1"><strong>Correo:</strong> {{ $factura->pedido->cliente->correo ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <h6 class="text-uppercase text-muted small fw-bold">Referencia:</h6>
                <p class="mb-1"><strong>Pedido Origen:</strong> #{{ $factura->id_pedido }}</p>
                <p class="mb-1"><strong>Estado del Pedido:</strong> <span class="badge bg-success">{{ $factura->pedido->estado }}</span></p>
            </div>
        </div>

        <!-- Tabla de Items -->
        <div class="table-responsive mb-4">
            <table class="table border align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Descripción</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-end">Precio Unit.</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($factura->pedido->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->producto->descripcion ?? 'N/A' }}</td>
                        <td class="text-center">{{ $detalle->cantidad }}</td>
                        <td class="text-end">${{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td class="text-end">${{ number_format($detalle->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end fs-5">Total Facturado:</th>
                        <th class="text-end fs-5 text-primary">${{ number_format($factura->monto, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Acciones -->
        <div class="d-flex justify-content-between d-print-none mt-3">
            <a href="{{ route('facturas.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> Volver a Facturas
            </a>
            <button onclick="window.print()" class="btn btn-success">
                <i class="fa-solid fa-print me-1"></i> Imprimir Factura
            </button>
        </div>
    </div>
</div>
@endsection