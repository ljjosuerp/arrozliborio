<?php

namespace Tests\Feature;

use App\Filament\Resources\Aplicacions\Pages\EditAplicacion;
use App\Filament\Resources\Aplicacions\Pages\ListAplicacions;
use App\Filament\Resources\Aspirantes\Pages\EditAspirante;
use App\Models\Aplicacion;
use App\Models\Aspirante;
use App\Models\PuestoVacante;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class AdminEmpleoTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    private function postulacion(): Aplicacion
    {
        $puesto = PuestoVacante::create([
            'titulo' => 'Operario de planta',
            'slug' => 'operario-de-planta',
            'estado' => true,
        ]);

        $aspirante = Aspirante::create([
            'nombre' => 'Luis Josué Rodríguez',
            'email' => 'luis@correo.cr',
            'telefono' => '87075124',
        ]);

        return Aplicacion::create([
            'aspirante_id' => $aspirante->id,
            'puesto_vacante_id' => $puesto->id,
            'mensaje' => 'Tengo experiencia en agroindustria.',
            'estado' => 'recibida',
        ]);
    }

    public function test_lista_de_postulaciones_muestra_nombre_correo_y_puesto(): void
    {
        $this->postulacion();

        Livewire::actingAs($this->admin())
            ->test(ListAplicacions::class)
            ->assertOk()
            ->assertSee('Luis Josué Rodríguez')
            ->assertSee('luis@correo.cr')
            ->assertSee('Operario de planta');
    }

    public function test_ver_postulacion_muestra_correo_mensaje_y_estado(): void
    {
        $aplicacion = $this->postulacion();

        Livewire::actingAs($this->admin())
            ->test(EditAplicacion::class, ['record' => $aplicacion->getKey()])
            ->assertOk()
            ->assertSee('luis@correo.cr')
            ->assertSee('Tengo experiencia en agroindustria.')
            ->assertSee('Operario de planta');
    }

    public function test_descargar_cv_por_la_ruta_dedicada(): void
    {
        config(['filesystems.cv_disk' => 'local']);
        Storage::disk('local')->put('cvs/prueba.pdf', '%PDF-1.4 contenido de prueba');

        $aspirante = $this->postulacion()->aspirante;
        $aspirante->update(['cv_path' => 'cvs/prueba.pdf', 'cv_nombre' => 'CV-Luis.pdf']);

        // Un visitante sin sesión no puede descargar.
        $this->get(route('cv.descargar', $aspirante))->assertRedirect();

        // Un usuario no-admin queda bloqueado.
        $this->actingAs(User::factory()->create(['is_admin' => false]))
            ->get(route('cv.descargar', $aspirante))
            ->assertForbidden();

        // El admin descarga el archivo.
        $this->actingAs($this->admin())
            ->get(route('cv.descargar', $aspirante))
            ->assertOk()
            ->assertDownload('CV-Luis.pdf');
    }

    public function test_editar_aspirante_carga_sin_pedir_usuario_obligatorio(): void
    {
        $aspirante = $this->postulacion()->aspirante;

        Livewire::actingAs($this->admin())
            ->test(EditAspirante::class, ['record' => $aspirante->getKey()])
            ->assertOk()
            // El correo se edita en un input (valor enlazado por Livewire, no texto plano).
            ->assertFormSet([
                'nombre' => 'Luis Josué Rodríguez',
                'email' => 'luis@correo.cr',
            ]);
    }
}
