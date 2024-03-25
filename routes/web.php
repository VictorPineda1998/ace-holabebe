<?php


use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\RoutePath;
use Illuminate\Support\Facades\DB;


use App\Http\Controllers\UserController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\ConsultasController;
use App\Http\Controllers\TriajesController;
use App\Models\Consulta;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/register', function () {
        return redirect()->route('dashboard');
    })->name('register');

    if (Features::enabled(Features::registration())) {

        Route::post(RoutePath::for('register', '/register'), [RegisteredUserController::class, 'store']);
    }

    Route::group(['prefix' => 'gestion-usuarios'], function () {
        Route::get('/', [UserController::class, 'show'])->name('gestion-usuarios');
        Route::put('{id}', [UserController::class, 'update'])->name('usuarios.update');
        Route::delete('{id}', [UserController::class, 'destroy'])->name('usuarios.eliminar');
    });

    Route::group(['prefix' => 'pacientes'], function () {
        Route::get('/', [PacientesController::class, 'index'])->name('pacientes');
        Route::get('{id}', [PacientesController::class, 'show'])->name('pacientes.show');
        Route::post('{id}', [PacientesController::class, 'store'])->name('pacientes.store');
        Route::put('{id}', [PacientesController::class, 'update'])->name('pacientes.update');
        Route::delete('{id}', [PacientesController::class, 'destroy'])->name('pacientes.eliminar');
    });

    Route::group(['prefix' => 'consultas'], function () {
        Route::get('{id} {lugar}', [ConsultasController::class, 'show'])->name('consultas.show');
        Route::post('{id}', [ConsultasController::class, 'store'])->name('consultas.store');
        Route::put('{id} {estado} {p_id}', [ConsultasController::class, 'update'])->name('consultas.update');
        Route::put('{id} {estado}', [ConsultasController::class, 'updateHoy'])->name('consultas.updateHoy');
        Route::delete('{id}', [ConsultasController::class, 'destroy'])->name('cosultas.eliminar');
    });

    Route::get('/consultas-dia', function () {
        $consultas = Consulta::where('fecha', now()->toDateString())
            ->where(function ($query) {
                $query->where('estado', 'Sin confirmar')
                    ->orWhere('estado', 'Confirmada');
            })->get();
        return view('lista-consultas-dia', compact('consultas'));
    })->name('consultas_dia');

    Route::get('/sala-espera', function () {
        $consultas = Consulta::where('fecha', now()->toDateString())
            ->Where('estado', 'Confirmada')->get();
        return view('lista-consultas-espera', compact('consultas'));
    })->name('consultas_espera');

    Route::group(['prefix' => 'triajes'], function () {
        Route::get('/', [TriajesController::class, 'index'])->name('triajes');
        Route::get('{id} {lugar}', [TriajesController::class, 'show'])->name('triajes.show');
        Route::post('{id}', [TriajesController::class, 'store'])->name('triajes.store');
        Route::put('{id}', [TriajesController::class, 'update'])->name('triajes.update');
        Route::delete('{id}', [TriajesController::class, 'destroy'])->name('triajes.eliminar');
    });
});

if (DB::table('users')->count() === 0) {
    $enableViews = config('fortify.views', true);
    if (Features::enabled(Features::registration())) {
        if ($enableViews) {
            Route::get(RoutePath::for('register', '/register'), [RegisteredUserController::class, 'create'])
                // ->middleware(['guest:'.config('fortify.guard')])
                ->name('register');
        }
        Route::post(RoutePath::for('register', '/register'), [RegisteredUserController::class, 'store']);
        // ->middleware(['guest:'.config('fortify.guard')]);
    }
}
