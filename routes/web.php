<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ParteController;

// ── Rutas públicas (login, registro) ──────────────────────────
// Laravel genera estas rutas automáticamente con Breeze o con:
// Auth::routes();

// ── Rutas protegidas ───────────────────────────────────────────
Route::middleware(['auth', 'es.profesor'])->group(function () {

    // Ruta de inicio — redirige al listado de partes
    Route::get('/', function () {
        return redirect()->route('partes.index');
    });

    // Alumnos: solo consulta
    Route::get('/alumnos',           [AlumnoController::class, 'index'])->name('alumnos.index');
    Route::get('/alumnos/{alumno}',  [AlumnoController::class, 'show'])->name('alumnos.show');

    // Teachers: CRUD completo
    Route::resource('teachers', TeacherController::class);

    // Partes: CRUD + envío de email
    Route::resource('partes', ParteController::class);
    Route::post('/partes/{parte}/email', [ParteController::class, 'enviarEmail'])
         ->name('partes.email');
});

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ── Rutas de autenticación manuales ───────
Route::get('/login',  function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended(route('partes.index'));
    }

    return back()
        ->withErrors(['email' => 'Las credenciales no son correctas.'])
        ->onlyInput('email');

})->middleware('guest');

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout')->middleware('auth');