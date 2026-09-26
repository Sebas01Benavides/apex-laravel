@extends('layouts.app')

@section('title', 'Productos - ApexGestion')

@section('content')
<div class="container">
    <!-- Encabezado con Botones Alineados -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fa-solid fa-box-open me-2 text-primary"></i>Lista de Productos</h2>
        <div>
            <a href="{{ route('productos.excel') }}" class="btn btn-success me-2">
                <i class="fa-solid fa-file-excel me-1"></i> Exportar a Excel
            </a>
            <a href="{{ route('productos.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus me-1"></i> Nuevo Producto
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
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Marca</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Estado</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productos as $producto)
                        <tr>
                            <td><strong>{{ $producto->codigo }}</strong></td>
                            <td>{{ $producto->descripcion }}</td>
                            <td>{{ $producto->categoria }}</td>
                            <td>{{ $producto->marca }}</td>
                            <td>${{ number_format($producto->precio, 2) }}</td>
                            <td>
                                <span class="badge {{ $producto->stock > 0 ? 'bg-info text-dark' : 'bg-danger' }}">
                                    {{ $producto->stock }}
                                </span>
                            </td>
                            <td><span class="badge bg-success">{{ $producto->estado }}</span></td>
                            <td class="text-end pe-4">
                                <a href="{{ route('catalogo.show', $producto->id) }}" class="btn btn-sm btn-info text-white me-1" title="Ver Ficha Técnica">
                                    <i class="fa-solid fa-wrench"></i> Ficha
                                </a>
                                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </a>
                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Eliminar producto?')">
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
                            <td colspan="8" class="text-center py-4 text-muted">No hay productos registrados aún.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection