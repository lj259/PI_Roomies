<?php

namespace App\Http\Controllers;

use App\Models\Propietario;
use App\Models\Apartamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class PropietarioController extends Controller {

    // Admin methods
    public function index() {
        $propietarios = Propietario::all();
        return view('Administradores.Propietarios.index', compact('propietarios'));
    }

    public function create() {
        return view('Administradores.Propietarios.Registro_Propietarios');
    }

    public function store(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:propietarios,correo',
            'telefono' => 'required|numeric|digits:10',
        ]);

        Propietario::create($request->all());
        return redirect()->route('propietarios.index')->with('Exito', 'Propietario registrado correctamente');
    }

    public function edit(Propietario $propietario) {
        return view('Propietarios.edit', compact('propietario'));
    }

    public function update(Request $request, Propietario $propietario) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:propietarios,correo,' . $propietario->id,
            'telefono' => 'nullable|numeric|string|digits:10',
        ]);

        $propietario->update($request->all());
        return redirect()->route('propietarios.index')->with('Exito', 'Propietario actualizado correctamente');
    }

    public function destroy(Propietario $propietario) {
        $propietario->delete();
        return redirect()->route('propietarios.index')->with('Exito', 'Propietario eliminado correctamente');
    }

    // Propietario authentication and self-management methods
    
    public function showRegistrationForm() {
        return view('propietarios.registro');
    }

    public function register(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'correo' => 'required|email|unique:propietarios,correo',
            'contraseña' => 'required|string|min:8|confirmed',
            'telefono' => 'required|string|digits:10',
            'genero' => 'required|in:masculino,femenino,otro',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only(['nombre', 'apellido_paterno', 'apellido_materno', 'correo', 'telefono', 'genero']);
        $data['contraseña'] = Hash::make($request->contraseña);

        if ($request->hasFile('foto_perfil')) {
            $data['foto_perfil'] = $request->file('foto_perfil')->store('perfil', 'public');
        }

        $propietario = Propietario::create($data);

        return redirect()->route('propietario.login')->with('Exito', 'Registro exitoso. Ahora puedes iniciar sesión.');
    }

    public function showLoginForm() {
        return view('propietarios.login');
    }

    public function login(Request $request) {
        $request->validate([
            'correo' => 'required|email',
            'contraseña' => 'required|string'
        ]);

        $propietario = Propietario::where('correo', $request->correo)->first();

        if ($propietario && Hash::check($request->contraseña, $propietario->contraseña)) {
            Session::put('propietario', $propietario);
            Session::put('propietario_id', $propietario->id);
            
            return redirect()->route('propietario.dashboard')->with('Exito', 'Bienvenido, ' . $propietario->nombre);
        }

        return back()->withErrors(['correo' => 'Credenciales incorrectas'])->withInput();
    }

    public function dashboard() {
        $propietario = Session::get('propietario');
        if (!$propietario) {
            return redirect()->route('propietario.login');
        }

        $apartamentos = Apartamento::where('propietario_id', $propietario->id)->get();
        $total_apartamentos = $apartamentos->count();
        $apartamentos_ocupados = $apartamentos->where('habitaciones_disponibles', 0)->count();
        $ingresos_totales = $apartamentos->sum('precio');

        return view('propietarios.dashboard', compact('propietario', 'apartamentos', 'total_apartamentos', 'apartamentos_ocupados', 'ingresos_totales'));
    }

    public function perfil() {
        $propietario = Session::get('propietario');
        if (!$propietario) {
            return redirect()->route('propietario.login');
        }

        return view('propietarios.perfil', compact('propietario'));
    }

    public function updateProfile(Request $request) {
        $propietario = Session::get('propietario');
        if (!$propietario) {
            return redirect()->route('propietario.login');
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'nullable|string|max:255',
            'correo' => 'required|email|unique:propietarios,correo,' . $propietario->id,
            'telefono' => 'required|string|digits:10',
            'genero' => 'required|in:masculino,femenino,otro',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $propietarioModel = Propietario::find($propietario->id);
        $data = $request->only(['nombre', 'apellido_paterno', 'apellido_materno', 'correo', 'telefono', 'genero']);

        if ($request->hasFile('foto_perfil')) {
            // Eliminar foto anterior si existe
            if ($propietarioModel->foto_perfil) {
                Storage::disk('public')->delete($propietarioModel->foto_perfil);
            }
            $data['foto_perfil'] = $request->file('foto_perfil')->store('perfil', 'public');
        }

        $propietarioModel->update($data);
        Session::put('propietario', $propietarioModel->fresh());

        return back()->with('Exito', 'Perfil actualizado correctamente');
    }

    public function logout() {
        Session::forget(['propietario', 'propietario_id']);
        return redirect()->route('propietario.login')->with('Exito', 'Sesión cerrada correctamente');
    }

    // Property management methods
    public function misApartamentos() {
        $propietario = Session::get('propietario');
        if (!$propietario) {
            return redirect()->route('propietario.login');
        }

        $apartamentos = Apartamento::where('propietario_id', $propietario->id)->get();
        return view('propietarios.apartamentos.index', compact('apartamentos'));
    }

    public function crearApartamento() {
        $propietario = Session::get('propietario');
        if (!$propietario) {
            return redirect()->route('propietario.login');
        }

        return view('propietarios.apartamentos.crear');
    }

    public function storeApartamento(Request $request) {
        $propietario = Session::get('propietario');
        if (!$propietario) {
            return redirect()->route('propietario.login');
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'direccion' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'habitaciones_disponibles' => 'required|integer|min:1',
            'disponible_para' => 'required|in:masculino,femenino,otro',
            'servicios' => 'nullable|array',
            'imagenes.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only(['titulo', 'descripcion', 'direccion', 'precio', 'habitaciones_disponibles', 'disponible_para']);
        $data['propietario_id'] = $propietario->id;
        $data['servicios'] = $request->input('servicios', []);
        $data['latitud'] = 0; // Placeholder, can be updated with map integration
        $data['longitud'] = 0; // Placeholder, can be updated with map integration

        // Handle image uploads
        if ($request->hasFile('imagenes')) {
            $imagenes = [];
            foreach ($request->file('imagenes') as $imagen) {
                $imagenes[] = $imagen->store('apartamentos', 'public');
            }
            $data['imagenes'] = $imagenes;
        }

        Apartamento::create($data);

        return redirect()->route('propietario.apartamentos')->with('Exito', 'Apartamento creado correctamente');
    }

    public function editarApartamento($id) {
        $propietario = Session::get('propietario');
        if (!$propietario) {
            return redirect()->route('propietario.login');
        }

        $apartamento = Apartamento::where('id', $id)->where('propietario_id', $propietario->id)->firstOrFail();
        return view('propietarios.apartamentos.editar', compact('apartamento'));
    }

    public function updateApartamento(Request $request, $id) {
        $propietario = Session::get('propietario');
        if (!$propietario) {
            return redirect()->route('propietario.login');
        }

        $apartamento = Apartamento::where('id', $id)->where('propietario_id', $propietario->id)->firstOrFail();

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'direccion' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'habitaciones_disponibles' => 'required|integer|min:0',
            'disponible_para' => 'required|in:masculino,femenino,otro',
            'servicios' => 'nullable|array',
            'imagenes.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only(['titulo', 'descripcion', 'direccion', 'precio', 'habitaciones_disponibles', 'disponible_para']);
        $data['servicios'] = $request->input('servicios', []);

        // Handle new image uploads
        if ($request->hasFile('imagenes')) {
            $imagenes = $apartamento->imagenes ?? [];
            foreach ($request->file('imagenes') as $imagen) {
                $imagenes[] = $imagen->store('apartamentos', 'public');
            }
            $data['imagenes'] = $imagenes;
        }

        $apartamento->update($data);

        return redirect()->route('propietario.apartamentos')->with('Exito', 'Apartamento actualizado correctamente');
    }

    public function eliminarApartamento($id) {
        $propietario = Session::get('propietario');
        if (!$propietario) {
            return redirect()->route('propietario.login');
        }

        $apartamento = Apartamento::where('id', $id)->where('propietario_id', $propietario->id)->firstOrFail();
        
        // Delete associated images
        if ($apartamento->imagenes) {
            foreach ($apartamento->imagenes as $imagen) {
                Storage::disk('public')->delete($imagen);
            }
        }

        $apartamento->delete();

        return redirect()->route('propietario.apartamentos')->with('Exito', 'Apartamento eliminado correctamente');
    }
}
