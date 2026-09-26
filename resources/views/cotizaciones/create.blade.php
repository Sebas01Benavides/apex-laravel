@extends('layouts.app')

@section('title', 'Nueva Cotización - ApexGestion')

@section('content')
<div class="container" style="max-width: 800px;">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <h3 class="mb-4"><i class="fa-solid fa-file-circle-plus me-2 text-primary"></i>Crear Nueva Cotización</h3>
            
            <form action="{{ route('cotizaciones.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Cliente</label>
                        <select name="id_cliente" class="form-select" required>
                            <option value="">Seleccione un cliente...</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }} ({{ $cliente->identificacion }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>

                <h5 class="mt-4 mb-3">Productos a Cotizar</h5>
                <table class="table border align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th>Precio Unit.</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                        <tr>
                            <td>
                                <input type="hidden" name="productos[]" value="{{ $producto->id }}">
                                <strong>{{ $producto->codigo }}</strong> - {{ $producto->descripcion }}
                            </td>
                            <td>${{ number_format($producto->precio, 2) }}</td>
                            <td style="width: 150px;">
                                <input type="number" name="cantidades[]" class="form-control" min="0" value="0">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('cotizaciones.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i> Guardar Cotización</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection