<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
        return redirect()->route('gestion-usuarios')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy($id)
    {
        // Lógica para eliminar al usuario
        $user = User::find($id);
        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $user->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return redirect()->route('gestion-usuarios')->with('success', 'Usuario eliminado exitosamente');
    }
}
