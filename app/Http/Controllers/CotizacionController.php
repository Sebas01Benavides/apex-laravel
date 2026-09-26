<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotizacion;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\DetalleCotizacion;
use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Support\Facades\DB;

class CotizacionController extends Controller
{
    public function index()
    {
        $cotizaciones = Cotizacion::with('cliente')->orderBy('id', 'desc')->get();
        return view('cotizaciones.index', compact('cotizaciones'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('cotizaciones.create', compact('clientes', 'productos'));
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

            $cotizacion = Cotizacion::create([
                'id_cliente' => $request->id_cliente,
                'fecha' => $request->fecha,
                'total' => 0,
                'estado' => 'Pendiente',
            ]);

            foreach ($request->productos as $index => $productoId) {
                $cantidad = $request->cantidades[$index];
                if ($cantidad > 0) {
                    $producto = Producto::findOrFail($productoId);
                    $subtotal = $producto->precio * $cantidad;
                    $total += $subtotal;

                    DetalleCotizacion::create([
                        'id_cotizacion' => $cotizacion->id,
                        'id_producto' => $producto->id,
                        'cantidad' => $cantidad,
                        'precio_unitario' => $producto->precio,
                        'subtotal' => $subtotal,
                    ]);
                }
            }

            $cotizacion->update(['total' => $total]);
        });

        return redirect()->route('cotizaciones.index')->with('success', 'Cotización registrada exitosamente');
    }

    public function show(Cotizacion $cotizacion)
    {
        $cotizacion->load('cliente', 'detalles.producto');
        return view('cotizaciones.show', compact('cotizacion'));
    }

    // Convertir una cotización aprobada en un Pedido real
    public function convertirAPedido(Cotizacion $cotizacion)
    {
        if ($cotizacion->estado === 'Convertida') {
            return redirect()->back()->with('error', 'Esta cotización ya fue convertida en pedido previamente.');
        }

        DB::transaction(function () use ($cotizacion) {
            // 1. Crear el Pedido
            $pedido = Pedido::create([
                'id_cliente' => $cotizacion->id_cliente,
                'fecha' => date('Y-m-d'),
                'total' => $cotizacion->total,
                'estado' => 'Pendiente',
            ]);

            // 2. Transferir items al detalle del pedido y descontar stock
            foreach ($cotizacion->detalles as $detalle) {
                DetallePedido::create([
                    'id_pedido' => $pedido->id,
                    'id_producto' => $detalle->id_producto,
                    'cantidad' => $detalle->cantidad,
                    'precio_unitario' => $detalle->precio_unitario,
                    'subtotal' => $detalle->subtotal,
                ]);

                // Descontar inventario
                $producto = Producto::find($detalle->id_producto);
                if ($producto) {
                    $producto->decrement('stock', $detalle->cantidad);
                }
            }

            // 3. Marcar cotización como Convertida
            $cotizacion->update([
                'estado' => 'Convertida',
                'id_pedido_generado' => $pedido->id,
            ]);
        });

        return redirect()->route('pedidos.index')->with('success', 'Cotización convertida en Pedido exitosamente');
    }

    public function destroy(Cotizacion $cotizacion)
    {
        $cotizacion->delete();
        return redirect()->route('cotizaciones.index')->with('success', 'Cotización eliminada exitosamente');
    }
}