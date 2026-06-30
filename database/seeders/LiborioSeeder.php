<?php

namespace Database\Seeders;

use App\Models\Compania;
use App\Models\Parametro;
use App\Models\Producto;
use App\Models\Provincia;
use App\Models\PuestoVacante;
use App\Models\PuntoVenta;
use App\Models\Receta;
use App\Models\Responsabilidad;
use App\Models\Ubicacion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LiborioSeeder extends Seeder
{
    /**
     * Reconstruye todo el contenido del sitio desde los archivos en database/data/.
     * Así el sitio es idéntico en cualquier servidor (no depende del archivo SQLite).
     */
    public function run(): void
    {
        $data = fn ($name) => json_decode(file_get_contents(database_path("data/{$name}.json")), true) ?: [];

        // ─── Catálogo y contenido directo ───
        Producto::query()->delete();
        foreach ($data('productos') as $r) {
            Producto::create($r);
        }

        Receta::query()->delete();
        foreach ($data('recetas') as $r) {
            Receta::create($r);
        }

        Compania::query()->delete();
        foreach ($data('companias') as $r) {
            Compania::create($r);
        }

        Responsabilidad::query()->delete();
        foreach ($data('responsabilidades') as $r) {
            Responsabilidad::create($r);
        }

        Parametro::query()->delete();
        foreach ($data('parametros') as $r) {
            Parametro::create($r);
        }

        PuestoVacante::query()->delete();
        foreach ($data('puestos_vacantes') as $r) {
            PuestoVacante::create($r);
        }

        PuntoVenta::query()->delete();
        foreach ($data('puntos_venta') as $r) {
            PuntoVenta::create($r);
        }

        // ─── Provincias + Ubicaciones (resuelve la relación por nombre) ───
        Ubicacion::query()->delete();
        Provincia::query()->delete();
        $provincias = [];
        foreach ($data('provincias') as $r) {
            $provincias[$r['nombre']] = Provincia::create($r);
        }
        foreach ($data('ubicaciones') as $r) {
            $nombreProv = $r['provincia_nombre'] ?? null;
            unset($r['provincia_nombre']);
            $prov = $provincias[$nombreProv] ?? reset($provincias) ?: null;
            if ($prov) {
                Ubicacion::create(array_merge($r, ['provincia_id' => $prov->id]));
            }
        }

        // ─── Usuario administrador del panel ───
        // ⚠️ CAMBIÁ esta contraseña apenas entres a /admin en producción.
        User::updateOrCreate(
            ['email' => 'admin@arrozliborio.com'],
            [
                'name' => 'Admin Liborio',
                'password' => Hash::make('liborio2026'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
