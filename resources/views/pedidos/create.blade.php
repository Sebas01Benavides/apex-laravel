<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5" style="max-width: 800px;">
        <h1>Crear Nuevo Pedido</h1>
        <form action="{{ route('pedidos.store') }}" method="POST">
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

            <h4 class="mt-4">Seleccionar Productos</h4>
            <table class="table border">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio Unitario</th>
                        <th>Stock Disp.</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                    <tr>
                        <td>
                            <input type="hidden" name="productos[]" value="{{ $producto->id }}">
                            {{ $producto->descripcion }} ({{ $producto->codigo }})
                        </td>
                        <td>${{ number_format($producto->precio, 2) }}</td>
                        <td>{{ $producto->stock }}</td>
                        <td style="width: 150px;">
                            <input type="number" name="cantidades[]" class="form-control" min="0" max="{{ $producto->stock }}" value="0">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-success mt-3">Guardar Pedido</button>
            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
        </form>
    </div>
</body>
</html>