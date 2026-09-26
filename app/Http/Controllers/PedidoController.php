<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\DetallePedido;
use Illuminate\Support\Facades\DB;
use App\Exports\PedidosExport;
use Maatwebsite\Excel\Facades\Excel;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('cliente')->orderBy('id', 'desc')->get();
        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::where('stock', '>', 0)->get();
        return view('pedidos.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'productos' => 'required|array|min:1',
            'cantidades' => 'required|array|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $total = 0;

            // Crear encabezado de pedido
            $pedido = Pedido::create([
                'id_cliente' => $request->id_cliente,
                'fecha' => $request->fecha,
                'total' => 0,
                'estado' => 'Pendiente',
            ]);

            // Procesar items del detalle
            foreach ($request->productos as $index => $productoId) {
                $cantidad = $request->cantidades[$index];
                if ($cantidad > 0) {
                    $producto = Producto::findOrFail($productoId);
                    $subtotal = $producto->precio * $cantidad;
                    $total += $subtotal;

                    DetallePedido::create([
                        'id_pedido' => $pedido->id,
                        'id_producto' => $producto->id,
                        'cantidad' => $cantidad,
                        'precio_unitario' => $producto->precio,
                        'subtotal' => $subtotal,
                    ]);

                    // Descontar stock
                    $producto->decrement('stock', $cantidad);
                }
            }

            // Actualizar el total calculado
            $pedido->update(['total' => $total]);
        });

        return redirect()->route('pedidos.index')->with('success', 'Pedido registrado exitosamente');
    }

    public function show(Pedido $pedido)
    {
        $pedido->load('cliente', 'detalles.producto');
        return view('pedidos.show', compact('pedido'));
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado exitosamente');
    }

    public function exportExcel()
    {
        return Excel::download(new PedidosExport, 'reporte_pedidos.xlsx');
    }
}