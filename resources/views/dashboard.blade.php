@extends('layouts.app')

@section('title', 'Dashboard - ApexGestion')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-chart-pie me-2 text-primary"></i>Panel de Control</h2>
        <span class="text-muted">Bienvenido al nuevo sistema ApexGestion</span>
    </div>

    <!-- Tarjetas de Métricas -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card card-dash border-0 shadow-sm bg-primary text-white">
                <div class="card-body p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase small mb-1">Clientes</h6>
                        <h2 class="mb-0 font-weight-bold">{{ $totalClientes }}</h2>
                    </div>
                    <i class="fa-solid fa-users fa-2x opacity-50"></i>
                </div>
                <div class="card-footer bg-transparent border-0 text-end">
                    <a href="{{ route('clientes.index') }}" class="text-white text-decoration-none small">Ver lista <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-dash border-0 shadow-sm bg-success text-white">
                <div class="card-body p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase small mb-1">Productos</h6>
                        <h2 class="mb-0 font-weight-bold">{{ $totalProductos }}</h2>
                    </div>
                    <i class="fa-solid fa-boxes-packing fa-2x opacity-50"></i>
                </div>
                <div class="card-footer bg-transparent border-0 text-end">
                    <a href="{{ route('productos.index') }}" class="text-white text-decoration-none small">Ver inventario <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-dash border-0 shadow-sm bg-warning text-dark">
                <div class="card-body p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase small mb-1">Pedidos Registrados</h6>
                        <h2 class="mb-0 font-weight-bold">{{ $totalPedidos }}</h2>
                    </div>
                    <i class="fa-solid fa-file-invoice-dollar fa-2x opacity-50"></i>
                </div>
                <div class="card-footer bg-transparent border-0 text-end">
                    <a href="{{ route('pedidos.index') }}" class="text-dark text-decoration-none small">Ver pedidos <i class="fa-solid fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Pedidos Recientes -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-secondary"><i class="fa-solid fa-clock-history me-2"></i>Últimos Pedidos</h5>
            <a href="{{ route('pedidos.create') }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-plus me-1"></i>Nuevo Pedido</a>
        </div>
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
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pedidosRecientes as $pedido)
                        <tr>
                            <td><strong>#{{ $pedido->id }}</strong></td>
                            <td>{{ $pedido->cliente->nombre ?? 'N/A' }}</td>
                            <td>{{ $pedido->fecha }}</td>
                            <td>${{ number_format($pedido->total, 2) }}</td>
                            <td><span class="badge bg-warning text-dark">{{ $pedido->estado }}</span></td>
                            <td>
                                <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
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