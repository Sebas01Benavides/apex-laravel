<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Equivalencia;
use App\Models\Aplicacion;

class CatalogoTecnicoController extends Controller
{
    // Mostrar la ficha técnica de un producto con sus equivalencias y aplicaciones
    public function show(Producto $producto)
    {
        $producto->load('equivalencias', 'aplicaciones');
        return view('catalogo.show', compact('producto'));
    }

    // Agregar una equivalencia a un producto
    public function storeEquivalencia(Request $request, Producto $producto)
    {
        $request->validate([
            'codigo_equivalente' => 'required|string|max:40',
            'marca_equivalente' => 'required|string|max:60',
        ]);

        Equivalencia::create([
            'id_producto' => $producto->id,
            'codigo_equivalente' => $request->codigo_equivalente,
            'marca_equivalente' => $request->marca_equivalente,
        ]);

        return redirect()->back()->with('success', 'Equivalencia registrada correctamente.');
    }

    // Eliminar una equivalencia
    public function destroyEquivalencia(Equivalencia $equivalencia)
    {
        $equivalencia->delete();
        return redirect()->back()->with('success', 'Equivalencia eliminada.');
    }

    // Agregar una aplicación técnica a un producto
    public function storeAplicacion(Request $request, Producto $producto)
    {
        $request->validate([
            'vehiculo' => 'required|string|max:100',
            'motor' => 'nullable|string|max:60',
            'anio' => 'nullable|string|max:30',
            'oem' => 'nullable|string|max:50',
            'observacion' => 'nullable|string',
        ]);

        Aplicacion::create([
            'id_producto' => $producto->id,
            'vehiculo' => $request->vehiculo,
            'motor' => $request->motor,
            'anio' => $request->anio,
            'oem' => $request->oem,
            'observacion' => $request->observacion,
        ]);

        return redirect()->back()->with('success', 'Aplicación registrada correctamente.');
    }

    // Eliminar una aplicación
    public function destroyAplicacion(Aplicacion $aplicacion)
    {
        $aplicacion->delete();
        return redirect()->back()->with('success', 'Aplicación eliminada.');
    }
}