@extends('layouts.app')

@section('title', 'Cotización #' . $cotizacion->id . ' - ApexGestion')

@section('content')
<div class="container" style="max-width: 700px;">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-dark text-white p-3 d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Cotización #{{ $cotizacion->id }}</h4>
            <span class="badge bg-light text-dark">{{ $cotizacion->fecha }}</span>
        </div>
        <div class="card-body p-4">
            <p><strong>Cliente:</strong> {{ $cotizacion->cliente->nombre ?? 'N/A' }}</p>
            <p><strong>Identificación:</strong> {{ $cotizacion->cliente->identificacion ?? 'N/A' }}</p>
            <p><strong>Estado:</strong> 
                <span class="badge {{ $cotizacion->estado === 'Convertida' ? 'bg-success' : 'bg-warning text-dark' }}">
                    {{ $cotizacion->estado }}
                </span>
            </p>

            <h5 class="mt-4 mb-3">Desglose de Cotización</h5>
            <table class="table border align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unit.</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cotizacion->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->producto->descripcion ?? 'N/A' }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td>${{ number_format($detalle->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total Cotizado:</th>
                        <th>${{ number_format($cotizacion->total, 2) }}</th>
                    </tr>
                </tfoot>
            </table>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('cotizaciones.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left me-1"></i> Volver
                </a>
                
                @if($cotizacion->estado !== 'Convertida')
                <form action="{{ route('cotizaciones.convertir', $cotizacion->id) }}" method="POST" onsubmit="return confirm('¿Convertir esta cotización en un Pedido definitivo?')">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-cart-arrow-down me-1"></i> Convertir a Pedido
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection