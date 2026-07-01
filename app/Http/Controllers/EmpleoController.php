<?php

namespace App\Http\Controllers;

use App\Models\Aplicacion;
use App\Models\Aspirante;
use App\Models\PuestoVacante;
use Illuminate\Http\Request;
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
        ]);
    }

    // Formulario de aplicación (público, sin login).
    public function aplicarForm(PuestoVacante $puesto)
    {
        return Inertia::render('Empleo/Aplicar', [
            'puesto' => $puesto,
        ]);
    }

    // Procesa la aplicación: guarda al aspirante, su CV y la aplicación.
    public function aplicar(Request $request, PuestoVacante $puesto)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'telefono' => ['nullable', 'string', 'max:40'],
            'mensaje' => ['nullable', 'string', 'max:2000'],
            'cv' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:4096'],
        ]);

        // Reusa el aspirante si ya postuló con ese correo; si no, crea uno nuevo.
        $aspirante = Aspirante::firstOrNew(['email' => $data['email']]);
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
                // No bloqueamos la postulación, pero dejamos rastro claro del fallo del bucket.
                \Log::error('Falló al guardar el CV en el disco "'.$cvDisk.'": '.$e->getMessage(), [
                    'archivo' => $file->getClientOriginalName(),
                    'excepcion' => get_class($e),
                ]);
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
                ."Correo: {$aspirante->email}\nTeléfono: {$aspirante->telefono}\n\nMensaje:\n"
                .($data['mensaje'] ?? '(sin mensaje)'),
                function ($m) use ($aspirante, $puesto, $cvDisk) {
                    $m->to(config('mail.empleo_to'))
                        ->replyTo($aspirante->email, $aspirante->nombre)
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

    // Descarga del CV desde el disco privado. Solo administradores autenticados.
    // Ruta dedicada (fuera de Filament) para que la descarga sea directa y estable.
    public function descargarCv(Aspirante $aspirante)
    {
        abort_unless(optional(auth()->user())->is_admin, 403);
        abort_unless($aspirante->cv_path, 404, 'Esta persona no tiene un CV adjunto.');

        $disk = Storage::disk(config('filesystems.cv_disk'));
        abort_unless($disk->exists($aspirante->cv_path), 404, 'El archivo del CV no se encontró en el almacenamiento.');

        return $disk->download($aspirante->cv_path, $aspirante->cv_nombre ?: 'CV.pdf');
    }
}
