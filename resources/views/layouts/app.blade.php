<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ApexGestion - Sistema de Gestión')</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome para Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar-brand { font-weight: bold; letter-spacing: 1px; }
        .card-dash { transition: transform 0.2s; }
        .card-dash:hover { transform: translateY(-3px); }
    </style>
</head>
<body>

    <!-- Barra de Navegación Principal -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand text-primary" href="{{ route('dashboard') }}">
                <i class="fa-solid fa-boxes-stacked me-2"></i>ApexGestion
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fa-solid fa-chart-line me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('clientes.*') ? 'active fw-bold' : '' }}" href="{{ route('clientes.index') }}">
                            <i class="fa-solid fa-users me-1"></i> Clientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('productos.*') ? 'active fw-bold' : '' }}" href="{{ route('productos.index') }}">
                            <i class="fa-solid fa-box-open me-1"></i> Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('cotizaciones.*') ? 'active fw-bold' : '' }}" href="{{ route('cotizaciones.index') }}">
                            <i class="fa-solid fa-file-signature me-1"></i> Cotizaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pedidos.*') ? 'active fw-bold' : '' }}" href="{{ route('pedidos.index') }}">
                            <i class="fa-solid fa-cart-shopping me-1"></i> Pedidos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('facturas.*') ? 'active fw-bold' : '' }}" href="{{ route('facturas.index') }}">
                            <i class="fa-solid fa-file-invoice-dollar me-1"></i> Facturación
                        </a>
                    </li>
                </ul>
                
                @auth
                <div class="d-flex align-items-center gap-3">
                    <span class="text-light small">
                        <i class="fa-solid fa-user-circle me-1 text-info"></i> {{ Auth::user()->usuario }} ({{ Auth::user()->rol }})
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fa-solid fa-right-from-bracket me-1"></i>Salir
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Contenido Dinámico de las Vistas -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>