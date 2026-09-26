<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Exports\ProductosExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:40|unique:productos',
            'descripcion' => 'required|string',
            'categoria' => 'required|string|max:60',
            'marca' => 'required|string|max:60',
            'precio' => 'required|numeric',
            'costo' => 'nullable|numeric',
            'stock' => 'required|integer',
        ]);

        Producto::create($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente');
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'codigo' => 'required|string|max:40|unique:productos,codigo,' . $producto->id,
            'descripcion' => 'required|string',
            'categoria' => 'required|string|max:60',
            'marca' => 'required|string|max:60',
            'precio' => 'required|numeric',
            'costo' => 'nullable|numeric',
            'stock' => 'required|integer',
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado exitosamente');
    }
    
    public function exportExcel()
    {
        return Excel::download(new ProductosExport, 'inventario_productos.xlsx');
    }
}