<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Búsqueda
        if ($request->filled('search')) {
            $query->buscar($request->search);
        }

        // Filtro por rol
        if ($request->filled('rol')) {
            $query->porRol($request->rol);
        }

        // Filtro por estado
        if ($request->filled('activo')) {
            $query->where('activo', $request->activo === '1');
        }

        $users = $query->orderBy('name')->paginate(15);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telefono' => 'nullable|string|max:20',
            'cargo' => 'nullable|string|max:255',
            'rol' => 'required|in:admin,gestor,operador',
            'password' => 'required|string|min:8|confirmed',
            'activo' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['activo'] = $request->has('activo');

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'telefono' => 'nullable|string|max:20',
            'cargo' => 'nullable|string|max:255',
            'rol' => 'required|in:admin,gestor,operador',
            'password' => 'nullable|string|min:8|confirmed',
            'activo' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['activo'] = $request->has('activo');

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // No permitir eliminar el propio usuario
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }

    /**
     * Activar/desactivar usuario
     */
    public function toggleStatus(User $user)
    {
        // No permitir desactivar el propio usuario
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'No puedes desactivar tu propio usuario.');
        }

        $user->update(['activo' => !$user->activo]);

        $status = $user->activo ? 'activado' : 'desactivado';
        
        return redirect()->route('users.index')
            ->with('success', "Usuario {$status} exitosamente.");
    }
}
