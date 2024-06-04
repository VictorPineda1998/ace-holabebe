<?php

use App\Http\Controllers\ArchivosController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\ColposcopiasController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\RoutePath;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\ConsultasController;
use App\Http\Controllers\DiagnosticosController;
use App\Http\Controllers\NotasController;
use App\Http\Controllers\TriajesController;

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
    'auth:sanctum', config('jetstream.auth_session'), 'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/register', function () {
        return redirect()->route('dashboard');
    })->name('register');

    if (Features::enabled(Features::registration())) {
        Route::post(RoutePath::for('register', '/register'), [RegisteredUserController::class, 'store'])
            ->middleware(['role:Administrador']);
    }

    Route::group(['prefix' => 'calendario'], function () {
        Route::get('/', [CalendarioController::class, 'index'])->name('calendario');
        Route::post('{id}', [CalendarioController::class, 'store'])->name('calendario.store');
    });

    Route::group(['prefix' => 'gestion-usuarios', 'middleware' => ['role:Administrador']], function () {
        Route::get('/', [UserController::class, 'show'])->name('gestion-usuarios');
        Route::put('{id}', [UserController::class, 'update'])->name('usuarios.update');
        Route::delete('{id}', [UserController::class, 'destroy'])->name('usuarios.eliminar');
    });

    Route::group(['prefix' => 'pacientes', 'middleware' => ['role:Administrador,Enfermeria consultorios,Medico especialista,Medico general,Enfermeria hospitalizacion']], function () {
        Route::get('/', [PacientesController::class, 'index'])->name('pacientes');
        Route::get('{id}', [PacientesController::class, 'show'])->name('pacientes.show');
        Route::post('{id}', [PacientesController::class, 'store'])->name('pacientes.store');
        Route::put('{id}', [PacientesController::class, 'update'])->name('pacientes.update');
        Route::delete('{id}', [PacientesController::class, 'destroy'])->name('pacientes.eliminar');
    });

    Route::group(['prefix' => 'consultas'], function () {
        Route::get('{id} {lugar}', [ConsultasController::class, 'show'])
            ->middleware(['role:Administrador,Enfermeria consultorios,Medico especialista,Medico general,Enfermeria hospitalizacion'])->name('consultas.show');

        Route::post('{id}', [ConsultasController::class, 'store'])
            ->middleware(['role:Administrador,Enfermeria consultorios,Medico especialista'])->name('consultas.store');

        Route::put('{id} {estado} {p_id}', [ConsultasController::class, 'update'])
            ->middleware(['role:Administrador,Enfermeria consultorios,Medico especialista'])->name('consultas.update');

        Route::put('{id} {estado}', [ConsultasController::class, 'updateHoy'])
            ->middleware(['role:Administrador,Enfermeria consultorios,Medico especialista'])->name('consultas.updateHoy');

        Route::delete('{id}', [ConsultasController::class, 'destroy'])
            ->middleware(['role:Administrador,Enfermeria consultorios,Medico especialista'])->name('consultas.eliminar');

        Route::get('consultas_dia', [ConsultasController::class, 'consultas_dia'])
            ->middleware(['role:Administrador,Enfermeria consultorios,Medico especialista'])->name('consultas_dia');

        Route::get('consultas_espera', [ConsultasController::class, 'consultas_espera'])
            ->middleware(['role:Administrador,Enfermeria consultorios,Medico especialista'])->name('consultas_espera');
    });

    Route::group(['prefix' => '/', 'middleware' => ['role:Administrador,Enfermeria consultorios,Medico especialista,Medico general,Enfermeria hospitalizacion']], function () {
        Route::get('archivos {id}', [ArchivosController::class, 'index'])->name('archivos');
        Route::post('{id}', [ArchivosController::class, 'store'])->name('archivos.store');
        Route::put('{id} {paciente_id}', [ArchivosController::class, 'update'])->name('archivos.update');
        Route::delete('{id} {paciente_id}', [ArchivosController::class, 'destroy'])->name('archivos.eliminar');
    });

    Route::group(['prefix' => 'triajes'], function () {
        Route::get('{id} {lugar}', [TriajesController::class, 'show'])
            ->middleware(['role:Administrador,Enfermeria consultorios,Medico especialista,Medico general,Enfermeria hospitalizacion'])
            ->name('triajes.show');
        Route::post('{id}', [TriajesController::class, 'store'])
            ->middleware(['role:Administrador,Enfermeria consultorios,Medico especialista'])->name('triajes.store');
        Route::put('{id}', [TriajesController::class, 'update'])
            ->middleware(['role:Administrador,Enfermeria consultorios,Medico especialista'])->name('triajes.update');
    });

    Route::group(['prefix' => 'colposcopia'], function () {
        Route::get('{id} {lugar} {triaje_id}', [ColposcopiasController::class, 'show'])
            ->middleware(['role:Administrador,Enfermeria consultorios,Medico especialista,Medico general,Enfermeria hospitalizacion'])->name('colposcopia.show');
        Route::post('{id}', [ColposcopiasController::class, 'store'])
            ->middleware(['role:Administrador,Medico especialista'])->name('colposcopia.store');
        Route::put('{id}', [ColposcopiasController::class, 'update'])
            ->middleware(['role:Administrador,Medico especialista'])->name('colposcopia.update');
    });

    Route::group(['prefix' => 'diagnostico', 'middleware' => ['role:Administrador,Medico especialista,Medico general']], function () {
        Route::post('{id}', [DiagnosticosController::class, 'store'])->name('diagnostico.store');
        Route::put('{id}', [DiagnosticosController::class, 'update'])->name('diagnostico.update');
    });

    Route::group(['prefix' => 'nota', 'middleware' => ['role:Administrador,Enfermeria consultorios,Medico especialista,Medico general,Enfermeria hospitalizacion']], function () {
        Route::post('{id}', [NotasController::class, 'store'])->name('nota.store');
        Route::put('{id}', [NotasController::class, 'update'])->name('nota.update');
    });
});

if (DB::table('users')->count() === 0) {
    $enableViews = config('fortify.views', true);
    if (Features::enabled(Features::registration())) {
        if ($enableViews) {
            Route::get(RoutePath::for('register', '/register'), [RegisteredUserController::class, 'create'])->name('register');
        }
        Route::post(RoutePath::for('register', '/register'), [RegisteredUserController::class, 'store']);
    }
}
