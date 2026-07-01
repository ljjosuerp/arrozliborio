<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Diagnóstico del almacenamiento de CVs (bucket R2 / S3).
 * Correr en Laravel Cloud → Commands:  php artisan empleo:probar-cv
 * Escribe un archivo de prueba, lo lee, lo borra y reporta el error exacto si falla.
 */
class ProbarCvStorage extends Command
{
    protected $signature = 'empleo:probar-cv';

    protected $description = 'Prueba que el bucket de CVs esté bien configurado y accesible.';

    public function handle(): int
    {
        $disk = config('filesystems.cv_disk');
        $this->line('');
        $this->info("Disco de CVs (CV_DISK): {$disk}");

        if ($disk === 's3') {
            $key = (string) config('filesystems.disks.s3.key');
            $this->table(['Parámetro', 'Valor'], [
                ['bucket', config('filesystems.disks.s3.bucket') ?: '(vacío)'],
                ['region', config('filesystems.disks.s3.region') ?: '(vacío)'],
                ['endpoint', config('filesystems.disks.s3.endpoint') ?: '(vacío)'],
                ['use_path_style_endpoint', config('filesystems.disks.s3.use_path_style_endpoint') ? 'true' : 'false'],
                ['key (AWS_ACCESS_KEY_ID)', $key !== '' ? substr($key, 0, 4).'…('.strlen($key).' car.)' : '(vacío)'],
                ['secret', config('filesystems.disks.s3.secret') ? 'presente' : '(vacío)'],
            ]);
        }

        $ruta = 'cvs/_diagnostico_'.now()->format('YmdHis').'.txt';

        try {
            $this->line("→ Escribiendo archivo de prueba: {$ruta}");
            Storage::disk($disk)->put($ruta, 'prueba liborio '.now());

            $existe = Storage::disk($disk)->exists($ruta);
            $this->line('→ ¿Existe tras escribir?  '.($existe ? 'sí' : 'NO'));

            $contenido = Storage::disk($disk)->get($ruta);
            $this->line('→ Lectura OK ('.strlen((string) $contenido).' bytes)');

            Storage::disk($disk)->delete($ruta);
            $this->line('→ Borrado OK');

            $this->newLine();
            $this->info('✅ El almacenamiento de CVs funciona correctamente.');

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->newLine();
            $this->error('❌ Falló el almacenamiento. Error exacto:');
            $this->line(get_class($e).': '.$e->getMessage());

            return self::FAILURE;
        }
    }
}
