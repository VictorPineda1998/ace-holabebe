<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\RoutePath;


use App\Http\Controllers\UserController;
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

   
    Route::group(['prefix' => 'gestion-usuarios'], function () {
        Route::get('/', [UserController::class, 'show'])->name('gestion-usuarios');
        Route::put('{id}', [UserController::class, 'update'])->name('usuarios.update');
        Route::delete('{id}', [UserController::class, 'destroy'])->name('usuarios.eliminar');
    });
    
});
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
