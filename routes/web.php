<?php

use App\Http\Controllers\ArchivosController;
use App\Http\Controllers\ColposcopiasController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\RoutePath;
use Illuminate\Support\Facades\DB;


use App\Http\Controllers\UserController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\ConsultasController;
use App\Http\Controllers\TriajesController;
use App\Http\Controllers\ConsultasDeHoyController;
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

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',
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

    Route::group(['prefix' => 'gestion-usuarios', 'middleware' => ['role:Administrador']], function () {
        Route::get('/', [UserController::class, 'show'])->name('gestion-usuarios');
        Route::put('{id}', [UserController::class, 'update'])->name('usuarios.update');
        Route::delete('{id}', [UserController::class, 'destroy'])->name('usuarios.eliminar');
    });

    Route::group(['prefix' => 'pacientes', 'middleware' => ['role:Administrador,Enfermeria consultorios,Medico especialista']], function () {
        Route::get('/', [PacientesController::class, 'index'])->name('pacientes');
        Route::get('{id}', [PacientesController::class, 'show'])->name('pacientes.show');
        Route::post('{id}', [PacientesController::class, 'store'])->name('pacientes.store');
        Route::put('{id}', [PacientesController::class, 'update'])->name('pacientes.update');
        Route::delete('{id}', [PacientesController::class, 'destroy'])->name('pacientes.eliminar');
    });

    Route::group(['prefix' => 'consultas', 'middleware' => ['role:Administrador,Enfermeria consultorios,Medico especialista']], function () {
        Route::get('{id} {lugar}', [ConsultasController::class, 'show'])->name('consultas.show');
        Route::post('{id}', [ConsultasController::class, 'store'])->name('consultas.store');
        Route::put('{id} {estado} {p_id}', [ConsultasController::class, 'update'])->name('consultas.update');
        Route::put('{id} {estado}', [ConsultasController::class, 'updateHoy'])->name('consultas.updateHoy');
        Route::delete('{id}', [ConsultasController::class, 'destroy'])->name('cosultas.eliminar');
        
        Route::get('consultas_dia', [ConsultasController::class, 'consultas_dia'])->name('consultas_dia');
        Route::get('consultas_espera', [ConsultasController::class, 'consultas_espera'])->name('consultas_espera');
    });

    Route::group(['prefix' => '/', 'middleware' => ['role:Administrador,Enfermeria consultorios,Medico especialista']], function () {
        Route::get('archivos {id}', [ArchivosController::class, 'index'])->name('archivos');
        Route::post('{id}', [ArchivosController::class, 'store'])->name('archivos.store');
        Route::put('{id} {paciente_id}', [ArchivosController::class, 'update'])->name('archivos.update');
        Route::delete('{id} {paciente_id}', [ArchivosController::class, 'destroy'])->name('archivos.eliminar');
    });

    Route::group(['prefix' => 'triajes', 'middleware' => ['role:Administrador,Enfermeria consultorios,Medico especialista']], function () {
        // Route::get('/', [TriajesController::class, 'index'])->name('triajes');
        Route::get('{id} {lugar}', [TriajesController::class, 'show'])->name('triajes.show');
        Route::post('{id}', [TriajesController::class, 'store'])->name('triajes.store');
        Route::put('{id}', [TriajesController::class, 'update'])->name('triajes.update');
        // Route::delete('{id}', [TriajesController::class, 'destroy'])->name('triajes.eliminar');
    });

    Route::group(['prefix' => 'colposcopia', 'middleware' => ['role:Administrador,Enfermeria consultorios,Medico especialista']], function () {
        // Route::get('/', [ColposcopiasController::class, 'index'])->name('colposcopia');
        Route::get('{id} {lugar} {triaje_id}', [ColposcopiasController::class, 'show'])->name('colposcopia.show');
        Route::post('{id}', [ColposcopiasController::class, 'store'])->name('colposcopia.store');
        Route::put('{id}', [ColposcopiasController::class, 'update'])->name('colposcopia.update');
        // Route::delete('{id}', [ColposcopiasController::class, 'destroy'])->name('colposcopia.eliminar');
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
