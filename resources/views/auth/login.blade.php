<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - ApexGestion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-login {
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="card card-login border-0 p-4 bg-white">
    <div class="text-center mb-4">
        <h2 class="text-primary fw-bold"><i class="fa-solid fa-boxes-stacked me-2"></i>ApexGestion</h2>
        <p class="text-muted small">Ingresa tus credenciales para acceder</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger py-2 small">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label text-secondary small fw-bold">Usuario</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fa-solid fa-user text-muted"></i></span>
                <input type="text" name="usuario" class="form-control" value="{{ old('usuario') }}" required autofocus placeholder="Nombre de usuario">
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label text-secondary small fw-bold">Contraseña</label>
            <div class="input-group">
                <span class="input-group-text bg-light"><i class="fa-solid fa-lock text-muted"></i></span>
                <input type="password" name="contrasena" class="form-control" required placeholder="••••••••">
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
            <i class="fa-solid fa-right-to-bracket me-2"></i>Iniciar Sesión
        </button>
    </form>
</div>

</body>
</html>