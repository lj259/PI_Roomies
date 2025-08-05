<?php

namespace App\Http\Controllers;

use App\Models\Amigo;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AmigosController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        
        if (!$usuario) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }
        
        $amigos = Amigo::getAmigosAceptados($usuario->id);
        $solicitudesPendientes = Amigo::getSolicitudesPendientes($usuario->id);
        
        return view('amigos.index', compact('amigos', 'solicitudesPendientes'));
    }

    public function buscar(Request $request)
    {
        $busqueda = $request->get('busqueda');
        $usuarioActual = Auth::id();
        
        $usuarios = Usuario::where('id', '!=', $usuarioActual)
            ->where(function($query) use ($busqueda) {
                $query->where('nombre', 'LIKE', "%{$busqueda}%")
                      ->orWhere('apellido_paterno', 'LIKE', "%{$busqueda}%")
                      ->orWhere('correo', 'LIKE', "%{$busqueda}%");
            })
            ->get()
            ->map(function ($usuario) use ($usuarioActual) {
                $usuario->es_amigo = Amigo::sonAmigos($usuarioActual, $usuario->id);
                $usuario->solicitud_pendiente = Amigo::where('idUsuario1', $usuarioActual)
                    ->where('idUsuario2', $usuario->id)
                    ->where('estatus', 'pendiente')
                    ->exists();
                return $usuario;
            });

        return view('amigos.buscar', compact('usuarios', 'busqueda'));
    }

    public function enviarSolicitud(Request $request)
    {
        $usuarioActual = Auth::id();
        $usuarioDestino = $request->usuario_id;

        // Verificar que no sean ya amigos o que no exista una solicitud pendiente
        $solicitudExistente = Amigo::where(function($query) use ($usuarioActual, $usuarioDestino) {
            $query->where('idUsuario1', $usuarioActual)
                  ->where('idUsuario2', $usuarioDestino);
        })->orWhere(function($query) use ($usuarioActual, $usuarioDestino) {
            $query->where('idUsuario1', $usuarioDestino)
                  ->where('idUsuario2', $usuarioActual);
        })->first();

        if ($solicitudExistente) {
            return back()->with('error', 'Ya existe una solicitud de amistad o ya son amigos.');
        }

        Amigo::create([
            'idUsuario1' => $usuarioActual,
            'idUsuario2' => $usuarioDestino,
            'estatus' => 'pendiente'
        ]);

        return back()->with('success', 'Solicitud de amistad enviada correctamente.');
    }

    public function responderSolicitud(Request $request)
    {
        $solicitud = Amigo::findOrFail($request->solicitud_id);
        $accion = $request->accion; // 'aceptar' o 'rechazar'

        // Verificar que la solicitud es para el usuario autenticado
        if ($solicitud->idUsuario2 != Auth::id()) {
            return back()->with('error', 'No tienes permisos para responder esta solicitud.');
        }

        if ($accion == 'aceptar') {
            $solicitud->update(['estatus' => 'aceptado']);
            return back()->with('success', 'Solicitud de amistad aceptada.');
        } else {
            $solicitud->update(['estatus' => 'rechazado']);
            return back()->with('success', 'Solicitud de amistad rechazada.');
        }
    }

    public function eliminarAmigo(Request $request, $amigoId)
    {
        $usuarioActual = Auth::id();
        
        $amistad = Amigo::where('estatus', 'aceptado')
            ->where(function($query) use ($usuarioActual, $amigoId) {
                $query->where(function($q) use ($usuarioActual, $amigoId) {
                    $q->where('idUsuario1', $usuarioActual)
                      ->where('idUsuario2', $amigoId);
                })->orWhere(function($q) use ($usuarioActual, $amigoId) {
                    $q->where('idUsuario1', $amigoId)
                      ->where('idUsuario2', $usuarioActual);
                });
            })->first();

        if ($amistad) {
            $amistad->delete();
            
            // Check if it's an AJAX request
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Amigo eliminado correctamente.'
                ]);
            }
            
            return back()->with('success', 'Amigo eliminado correctamente.');
        }

        // Check if it's an AJAX request
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró la amistad.'
            ]);
        }

        return back()->with('error', 'No se encontró la amistad.');
    }
}
