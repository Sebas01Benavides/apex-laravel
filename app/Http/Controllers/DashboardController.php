<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Pedido;

class DashboardController extends Controller
{
    public function index()
    {
        $totalClientes = Cliente::count();
        $totalProductos = Producto::count();
        $totalPedidos = Pedido::count();
        $pedidosRecientes = Pedido::with('cliente')->orderBy('id', 'desc')->take(5)->get();

        return view('dashboard', compact('totalClientes', 'totalProductos', 'totalPedidos', 'pedidosRecientes'));
    }
}