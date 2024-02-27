<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function show()
    {
        $users = User::all();
        return view('gestion-usuarios', compact('users'));
    }

    // public function edit($id)
    // {
    //     // Lógica para cargar datos del usuario para la edición
    //     $user = User::find($id);
    //     return view('gestion-usuarios', compact('user'));
    // }

    public function update(Request $request, $id)
    {
        // Lógica para actualizar los datos del usuario
        $user = User::find($id);
        $user->update($request->tipo_usuario);
        return redirect()->route('gestion-usuarios')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy($id)
    {
        // Lógica para eliminar al usuario
        $user = User::find($id);
        $user->delete();
        return redirect()->route('gestion-usuarios')->with('success', 'Usuario eliminado exitosamente');
    }
}
