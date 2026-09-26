@extends('layouts.app')

@section('title', 'Pedidos - ApexGestion')

@section('content')
<div class="container">
    <!-- Encabezado con Botones Alineados -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-cart-shopping me-2 text-primary"></i>Gestión de Pedidos</h2>
        <div>
            <a href="{{ route('pedidos.excel') }}" class="btn btn-success me-2">
                <i class="fa-solid fa-file-excel me-1"></i> Exportar a Excel
            </a>
            <a href="{{ route('pedidos.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus me-1"></i> Nuevo Pedido
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>N° Pedido</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pedidos as $pedido)
                        <tr>
                            <td><strong>#{{ $pedido->id }}</strong></td>
                            <td>{{ $pedido->cliente->nombre ?? 'N/A' }}</td>
                            <td>{{ $pedido->fecha }}</td>
                            <td>${{ number_format($pedido->total, 2) }}</td>
                            <td><span class="badge bg-warning text-dark">{{ $pedido->estado }}</span></td>
                            <td class="text-end pe-4">
                                <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-sm btn-info text-white me-1">
                                    <i class="fa-solid fa-eye"></i> Ver Detalle
                                </a>
                                <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Eliminar pedido?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa-solid fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No hay pedidos registrados aún.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection