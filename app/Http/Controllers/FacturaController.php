<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Pedido;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    public function index()
    {
        $facturas = Factura::with('pedido.cliente')->orderBy('id', 'desc')->get();
        return view('facturas.index', compact('facturas'));
    }

    public function create()
    {
        // Solo pedidos que aún no han sido facturados
        $pedidos = Pedido::doesntHave('factura')->with('cliente')->get();
        return view('facturas.create', compact('pedidos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pedido' => 'required|exists:pedidos,id|unique:facturas,id_pedido',
            'fecha_factura' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            $pedido = Pedido::findOrFail($request->id_pedido);

            // Generar Factura
            Factura::create([
                'id_pedido' => $pedido->id,
                'fecha_factura' => $request->fecha_factura,
                'monto' => $pedido->total,
            ]);

            // Actualizar estado del pedido a 'Facturado'
            $pedido->update(['estado' => 'Facturado']);
        });

        return redirect()->route('facturas.index')->with('success', 'Factura generada exitosamente');
    }

    public function show(Factura $factura)
    {
        $factura->load('pedido.cliente', 'pedido.detalles.producto');
        return view('facturas.show', compact('factura'));
    }

    public function destroy(Factura $factura)
    {
        DB::transaction(function () use ($factura) {
            if ($factura->pedido) {
                $factura->pedido->update(['estado' => 'Pendiente']);
            }
            $factura->delete();
        });

        return redirect()->route('facturas.index')->with('success', 'Factura anulada/eliminada exitosamente');
    }
}