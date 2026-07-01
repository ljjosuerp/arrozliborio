<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Contenido editable de páginas (CMS). Cada página = una fila con su contenido en JSON.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paginas', function (Blueprint $t) {
            $t->id();
            $t->string('clave')->unique();   // fit, conocenos, ...
            $t->string('nombre');
            $t->json('contenido')->nullable();
            $t->timestamps();
        });

        // Contenido inicial de la página Liborio Fit (para que sea editable de inmediato).
        DB::table('paginas')->insert([
            'clave' => 'fit',
            'nombre' => 'Liborio Fit',
            'contenido' => json_encode([
                'hero' => [
                    'eyebrow' => 'Vamos al grano',
                    'titulo' => 'Nuevo año, vida saludable',
                    'texto' => 'Elegí vivir sano este año con Liborio Fit. Un grano de salud en cada plato, para que vos y tu familia disfruten de lo mejor de nuestra tierra.',
                    'cta' => 'Dónde comprar',
                ],
                'beneficios_eyebrow' => 'Salud en tu mesa',
                'beneficios_titulo' => 'Libre de preocupaciones',
                'beneficios' => [
                    ['icono' => 'corazon', 'titulo' => 'Sin colesterol', 'texto' => 'Cuidá tu corazón en cada plato.'],
                    ['icono' => 'gota', 'titulo' => 'Bajo en sodio', 'texto' => 'Sabor pleno, menos sal.'],
                    ['icono' => 'trigo', 'titulo' => 'Libre de gluten', 'texto' => 'Apto para toda la familia.'],
                    ['icono' => 'chispa', 'titulo' => '99% menos grasa', 'texto' => 'Liviano y lleno de energía.'],
                ],
                'nota' => '75% más fibra significa que tu digestión te lo va a agradecer. *Comparativa con el arroz blanco.',
                'newsletter' => [
                    'titulo' => 'Recetas Fit, directo a tu correo',
                    'texto' => 'Explorá las posibilidades con Liborio Fit. Sumate y recibí ideas saludables cada semana.',
                ],
            ], JSON_UNESCAPED_UNICODE),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('paginas');
    }
};
