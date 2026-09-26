@extends('layouts.app')

@section('title', 'Cotizaciones - ApexGestion')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-file-signature me-2 text-primary"></i>Gestión de Cotizaciones</h2>
        <a href="{{ route('cotizaciones.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-1"></i> Nueva Cotización
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>N° Cotización</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cotizaciones as $cotizacion)
                        <tr>
                            <td><strong>#{{ $cotizacion->id }}</strong></td>
                            <td>{{ $cotizacion->cliente->nombre ?? 'N/A' }}</td>
                            <td>{{ $cotizacion->fecha }}</td>
                            <td>${{ number_format($cotizacion->total, 2) }}</td>
                            <td>
                                <span class="badge {{ $cotizacion->estado === 'Convertida' ? 'bg-success' : 'bg-warning text-dark' }}">
                                    {{ $cotizacion->estado }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('cotizaciones.show', $cotizacion->id) }}" class="btn btn-sm btn-info text-white me-1">
                                    <i class="fa-solid fa-eye"></i> Ver Detalle
                                </a>

                                @if($cotizacion->estado !== 'Convertida')
                                <form action="{{ route('cotizaciones.convertir', $cotizacion->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Convertir esta cotización en un Pedido definitivo?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success me-1">
                                        <i class="fa-solid fa-cart-arrow-down"></i> Convertir a Pedido
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('cotizaciones.destroy', $cotizacion->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Eliminar cotización?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No hay cotizaciones registradas aún.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection