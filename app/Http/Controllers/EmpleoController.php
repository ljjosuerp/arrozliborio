<?php

namespace App\Http\Controllers;

use App\Models\Aplicacion;
use App\Models\Aspirante;
use App\Models\PuestoVacante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            // Disco privado (no accesible por URL) — se descarga solo desde el admin.
            $aspirante->cv_path = $file->store('cvs', 'local');
            $aspirante->cv_nombre = $file->getClientOriginalName();
        }
        $aspirante->save();

        Aplicacion::create([
            'aspirante_id' => $aspirante->id,
            'puesto_vacante_id' => $puesto->id,
            'mensaje' => $data['mensaje'] ?? null,
            'estado' => 'recibida',
        ]);

        return redirect()->route('empleo.show', $puesto->id)->with('aplicado', true);
    }
}
