<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

use function Laravel\Prompts\alert;

class UserController extends Controller
{
    public function show()
    {
        $users = User::orderBy('created_at', 'desc')->get();
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

        $user = User::findOrFail($id);
        $user->tipo_usuario = $request->input('tipo_usuario');
        $user->save();
        return redirect()->route('gestion-usuarios');
    }

    public function destroy($id)
    {
        // Lógica para eliminar al usuario
        $user = User::find($id);
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();
        return redirect()->route('gestion-usuarios')->with('success', 'Usuario eliminado exitosamente');
    }
}
