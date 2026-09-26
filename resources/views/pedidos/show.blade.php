<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Pedido #{{ $pedido->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5" style="max-width: 700px;">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <h3>Pedido #{{ $pedido->id }}</h3>
                <span class="badge bg-light text-dark align-self-center">{{ $pedido->fecha }}</span>
            </div>
            <div class="card-body">
                <p><strong>Cliente:</strong> {{ $pedido->cliente->nombre ?? 'N/A' }}</p>
                <p><strong>Identificación:</strong> {{ $pedido->cliente->identificacion ?? 'N/A' }}</p>
                
                <h5 class="mt-4">Items Solicitados</h5>
                <table class="table border">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unit.</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedido->detalles as $detalle)
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
                            <th colspan="3" class="text-end">Total:</th>
                            <th>${{ number_format($pedido->total, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
                <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Volver a Pedidos</a>
            </div>
        </div>
    </div>
</body>
</html>