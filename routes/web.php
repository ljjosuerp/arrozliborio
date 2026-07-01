<?php

use App\Http\Controllers\AsistenteController;
use App\Http\Controllers\EmpleoController;
use App\Models\Compania;
use App\Models\Contacto;
use App\Models\Pagina;
use App\Models\Producto;
use App\Models\PuntoVenta;
use App\Models\Receta;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// ─── Inicio ───
Route::get('/', fn () => Inertia::render('Home'))->name('home');

// ─── Liborio Fit (contenido editable desde el admin) ───
Route::get('/liborio-fit', fn () => Inertia::render('Fit', [
    'contenido' => optional(Pagina::where('clave', 'fit')->first())->contenido,
]))->name('liborio-fit');

// ─── Páginas de marca (contenido estático con el DS) ───
Route::get('/conocenos', fn () => Inertia::render('Conocenos'))->name('conocenos');
Route::get('/sostenibilidad', fn () => Inertia::render('Sostenibilidad'))->name('sostenibilidad');
Route::get('/apartado-legal', fn () => Inertia::render('ApartadoLegal'))->name('apartado-legal');

// ─── Productos (data-driven, Fase 3) ───
Route::get('/productos', fn () => Inertia::render('Productos', [
    'productos' => Producto::where('estado', true)->orderBy('orden')->get(),
]))->name('productos');

// ─── Recetas (listado + detalle, Fase 3) ───
Route::get('/recetas', fn () => Inertia::render('Recetas/Index', [
    'recetas' => Receta::where('estado', true)->orderBy('nombre')->get(),
]))->name('recetas');

Route::get('/recetas/{receta}/{slug?}', fn (Receta $receta) => Inertia::render('Recetas/Show', [
    'receta' => $receta,
]))->name('recetas.show');

// ─── Hablemos: contacto + sede + dónde comprar (Fase 4 + 5) ───
Route::get('/hablemos', fn () => Inertia::render('Hablemos', [
    'sede' => Ubicacion::with('provincia')->orderBy('orden')->first(),
    'companias' => Compania::orderBy('nombre')->get(),
    'puntosVenta' => PuntoVenta::where('estado', true)
        ->whereNotNull('lat')
        ->get(['id', 'nombre', 'region', 'direccion', 'lat', 'lng', 'precision', 'productos']),
]))->name('hablemos');

Route::post('/hablemos', function (Request $request) {
    $data = $request->validate([
        'nombre' => ['required', 'string', 'max:120'],
        'email' => ['required', 'email', 'max:160'],
        'telefono' => ['nullable', 'string', 'max:40'],
        'asunto' => ['nullable', 'string', 'max:160'],
        'mensaje' => ['required', 'string', 'max:3000'],
    ]);

    $contacto = Contacto::create($data);

    // Aviso al correo de la empresa. replyTo = el cliente, para responderle directo.
    // En local con MAIL_MAILER=log se escribe en storage/logs/laravel.log (no envía).
    try {
        Mail::raw(
            "Nuevo mensaje de contacto:\n\nNombre: {$contacto->nombre}\nEmail: {$contacto->email}\n"
            ."Teléfono: {$contacto->telefono}\nAsunto: {$contacto->asunto}\n\n{$contacto->mensaje}",
            fn ($m) => $m->to(config('mail.contact_to'))
                ->replyTo($contacto->email, $contacto->nombre)
                ->subject('Contacto web: '.($contacto->asunto ?: 'Sin asunto'))
        );
    } catch (\Throwable $e) {
        // No bloquear el guardado si el mailer falla.
    }

    return back();
})->name('hablemos.store');

// ─── Portal de empleo (Fase 5) — postulación pública, sin login ───
Route::get('/trabaje-con-nosotros', [EmpleoController::class, 'index'])->name('empleo.index');
Route::get('/trabaje-con-nosotros/puesto/{puesto}', [EmpleoController::class, 'show'])->name('empleo.show');
Route::get('/trabaje-con-nosotros/puesto/{puesto}/aplicar', [EmpleoController::class, 'aplicarForm'])->name('empleo.aplicar.form');
Route::post('/trabaje-con-nosotros/puesto/{puesto}/aplicar', [EmpleoController::class, 'aplicar'])->name('empleo.aplicar');

// ─── Páginas públicas pendientes (placeholder branded) ───
$publicas = [
    'planta'                 => ['La planta', 'Fase 3'],
    'vivi-bien-con-liborio'  => ['Viví Bien con Liborio', 'Fase 3'],
    'eventos'                => ['Eventos', 'Fase 3'],
    'catalogos'              => ['Catálogos', 'Fase 3'],
];

foreach ($publicas as $slug => [$titulo, $fase]) {
    Route::get("/{$slug}", fn () => Inertia::render('Placeholder', [
        'titulo' => $titulo,
        'fase' => $fase,
    ]))->name($slug);
}

// ─── Asistente Liborio (chatbot con IA) ───
Route::post('/asistente', [AsistenteController::class, 'chat'])
    ->middleware('throttle:20,1')
    ->name('asistente.chat');

// ─── Descarga de CV (solo admin autenticado) ───
Route::get('/rrhh/cv/{aspirante}', [EmpleoController::class, 'descargarCv'])
    ->middleware('auth')
    ->name('cv.descargar');

// ─── Área autenticada (Jetstream) ───
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');
});
