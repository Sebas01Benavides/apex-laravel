@extends('layouts.app')

@section('title', 'Clientes - ApexGestion')

@section('content')
<div class="container">
    <!-- Encabezado con Botones Alineados -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-users me-2 text-primary"></i>Lista de Clientes</h2>
        <div>
            <a href="{{ route('clientes.excel') }}" class="btn btn-success me-2">
                <i class="fa-solid fa-file-excel me-1"></i> Exportar a Excel
            </a>
            <a href="{{ route('clientes.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-user-plus me-1"></i> Nuevo Cliente
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
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Identificación</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clientes as $cliente)
                        <tr>
                            <td><strong>#{{ $cliente->id }}</strong></td>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->identificacion }}</td>
                            <td>{{ $cliente->correo }}</td>
                            <td>{{ $cliente->telefono ?? 'N/A' }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </a>
                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este cliente?')">
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
                            <td colspan="6" class="text-center py-4 text-muted">No hay clientes registrados aún.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection