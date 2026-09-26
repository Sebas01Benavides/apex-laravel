<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'usuario' => 'required|string',
            'contrasena' => 'required|string',
        ]);

        // Buscar el usuario en PostgreSQL
        $usuario = Usuario::where('usuario', $credentials['usuario'])->first();

        // Verificar contraseña (soporta Hash de Bcrypt o texto plano si viene del sistema legacy)
        if ($usuario && (Hash::check($credentials['contrasena'], $usuario->contrasena) || $credentials['contrasena'] === $usuario->contrasena)) {
            
            // Si la contraseña estaba en texto plano, la actualizamos automáticamente a Bcrypt por seguridad
            if ($credentials['contrasena'] === $usuario->contrasena) {
                $usuario->update(['contrasena' => Hash::make($credentials['contrasena'])]);
            }

            Auth::login($usuario);
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'usuario' => 'Las credenciales ingresadas no son correctas.',
        ])->onlyInput('usuario');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}