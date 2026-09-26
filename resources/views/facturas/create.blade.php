@extends('layouts.app')

@section('title', 'Generar Factura - ApexGestion')

@section('content')
<div class="container" style="max-width: 600px;">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h3 class="mb-4"><i class="fa-solid fa-receipt me-2 text-primary"></i>Emitir Factura de Pedido</h3>

            <form action="{{ route('facturas.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Seleccionar Pedido a Facturar</label>
                    <select name="id_pedido" class="form-select" required>
                        <option value="">Seleccione un pedido...</option>
                        @foreach($pedidos as $pedido)
                            <option value="{{ $pedido->id }}">
                                Pedido #{{ $pedido->id }} - {{ $pedido->cliente->nombre ?? 'Sin Cliente' }} (${{ number_format($pedido->total, 2) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Fecha de Facturación</label>
                    <input type="date" name="fecha_factura" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('facturas.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-print me-1"></i> Generar Factura
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection