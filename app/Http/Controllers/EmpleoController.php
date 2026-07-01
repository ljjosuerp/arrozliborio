<?php

namespace App\Http\Controllers;

use App\Models\Aplicacion;
use App\Models\Aspirante;
use App\Models\PuestoVacante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class EmpleoController extends Controller
{
    // Listado público de vacantes.
    public function index()
    {
        return Inertia::render('Empleo/Index', [
            'vacantes' => PuestoVacante::where('estado', true)->latest()->get(),
        ]);
    }

    // Detalle de una vacante.
    public function show(PuestoVacante $puesto)
    {
        return Inertia::render('Empleo/Show', [
            'puesto' => $puesto,
            'autenticado' => Auth::check(),
        ]);
    }

    // Formulario de aplicación (requiere login).
    public function aplicarForm(PuestoVacante $puesto)
    {
        $user = Auth::user();
        $aspirante = Aspirante::where('user_id', $user->id)->first();

        return Inertia::render('Empleo/Aplicar', [
            'puesto' => $puesto,
            'perfil' => [
                'nombre' => $aspirante->nombre ?? $user->name,
                'telefono' => $aspirante->telefono ?? '',
                'cv_nombre' => $aspirante->cv_nombre ?? null,
            ],
        ]);
    }

    // Procesa la aplicación: guarda perfil de aspirante, CV y la aplicación.
    public function aplicar(Request $request, PuestoVacante $puesto)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'telefono' => ['nullable', 'string', 'max:40'],
            'mensaje' => ['nullable', 'string', 'max:2000'],
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:4096'],
        ]);

        $user = Auth::user();
        $aspirante = Aspirante::firstOrNew(['user_id' => $user->id]);
        $aspirante->nombre = $data['nombre'];
        $aspirante->telefono = $data['telefono'] ?? null;

        $cvDisk = config('filesystems.cv_disk');
        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            // Disco privado (local en dev, bucket S3 en producción) — nunca público.
            // Si el almacenamiento falla, no bloqueamos la postulación (se guarda sin CV).
            try {
                $aspirante->cv_path = $file->store('cvs', $cvDisk);
                $aspirante->cv_nombre = $file->getClientOriginalName();
            } catch (\Throwable $e) {
                report($e);
            }
        }
        $aspirante->save();

        Aplicacion::create([
            'aspirante_id' => $aspirante->id,
            'puesto_vacante_id' => $puesto->id,
            'mensaje' => $data['mensaje'] ?? null,
            'estado' => 'recibida',
        ]);

        // Aviso a Recursos Humanos con el CV adjunto. replyTo = el postulante.
        try {
            Mail::raw(
                "Nueva postulación:\n\nPuesto: {$puesto->titulo}\nNombre: {$aspirante->nombre}\n"
                ."Correo: {$user->email}\nTeléfono: {$aspirante->telefono}\n\nMensaje:\n"
                .($data['mensaje'] ?? '(sin mensaje)'),
                function ($m) use ($aspirante, $user, $puesto, $cvDisk) {
                    $m->to(config('mail.empleo_to'))
                        ->replyTo($user->email, $aspirante->nombre)
                        ->subject('Postulación: '.$puesto->titulo.' — '.$aspirante->nombre);
                    if ($aspirante->cv_path && Storage::disk($cvDisk)->exists($aspirante->cv_path)) {
                        $m->attachData(
                            Storage::disk($cvDisk)->get($aspirante->cv_path),
                            $aspirante->cv_nombre ?: 'CV.pdf'
                        );
                    }
                }
            );
        } catch (\Throwable $e) {
            // No bloquear la postulación si el mailer falla.
        }

        return redirect()->route('empleo.show', $puesto->id)->with('aplicado', true);
    }
}
