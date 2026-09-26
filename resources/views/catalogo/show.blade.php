@extends('layouts.app')

@section('title', 'Ficha Técnica - ' . $producto->codigo)

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="fa-solid fa-wrench me-2 text-primary"></i>Ficha Técnica: {{ $producto->codigo }}</h2>
            <p class="text-muted mb-0">{{ $producto->descripcion }} (Marca: <strong>{{ $producto->marca }}</strong> | Categoría: <strong>{{ $producto->categoria }}</strong>)</p>
        </div>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Volver a Productos
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- SECCIÓN EQUIVALENCIAS -->
        <div class="col-md-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0"><i class="fa-solid fa-arrows-rotate me-2"></i>Códigos Equivalentes</h5>
                </div>
                <div class="card-body">
                    <!-- Formulario de rápida adición -->
                    <form action="{{ route('catalogo.equivalencia.store', $producto->id) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="text" name="codigo_equivalente" class="form-control form-control-sm" placeholder="Código equiv." required>
                            </div>
                            <div class="col-6">
                                <input type="text" name="marca_equivalente" class="form-control form-control-sm" placeholder="Marca (ej: Bosch, WIX)" required>
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-sm btn-primary mt-1 w-100">
                                    <i class="fa-solid fa-plus me-1"></i> Agregar Equivalencia
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Lista de Equivalencias -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Código</th>
                                    <th>Marca</th>
                                    <th class="text-end">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($producto->equivalencias as $eq)
                                <tr>
                                    <td><strong>{{ $eq->codigo_equivalente }}</strong></td>
                                    <td>{{ $eq->marca_equivalente }}</td>
                                    <td class="text-end">
                                        <form action="{{ route('catalogo.equivalencia.destroy', $eq->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar equivalencia?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">Sin equivalencias registradas.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN APLICACIONES VEHICULARES -->
        <div class="col-md-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="fa-solid fa-car me-2"></i>Aplicaciones y Compatibilidad</h5>
                </div>
                <div class="card-body">
                    <!-- Formulario de adición de Aplicación -->
                    <form action="{{ route('catalogo.aplicacion.store', $producto->id) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row g-2 mb-2">
                            <div class="col-md-6">
                                <input type="text" name="vehiculo" class="form-control form-control-sm" placeholder="Vehículo/Modelo (ej: Toyota Hilux)" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="motor" class="form-control form-control-sm" placeholder="Motor (ej: 2.8 1GD)">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="anio" class="form-control form-control-sm" placeholder="Año (ej: 2016-2022)">
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <input type="text" name="oem" class="form-control form-control-sm" placeholder="N° OEM Original">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="observacion" class="form-control form-control-sm" placeholder="Observación opcional">
                            </div>
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-sm btn-success mt-1 w-100">
                                    <i class="fa-solid fa-plus me-1"></i> Agregar Aplicación
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Lista de Aplicaciones -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Vehículo</th>
                                    <th>Motor</th>
                                    <th>Año</th>
                                    <th>OEM</th>
                                    <th class="text-end">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($producto->aplicaciones as $ap)
                                <tr>
                                    <td><strong>{{ $ap->vehiculo }}</strong></td>
                                    <td>{{ $ap->motor ?? 'N/A' }}</td>
                                    <td>{{ $ap->anio ?? 'N/A' }}</td>
                                    <td><code>{{ $ap->oem ?? 'N/A' }}</code></td>
                                    <td class="text-end">
                                        <form action="{{ route('catalogo.aplicacion.destroy', $ap->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar aplicación?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">Sin aplicaciones registradas.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection