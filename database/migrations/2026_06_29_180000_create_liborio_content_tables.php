<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tablas de contenido del rebuild de arrozliborio.com (blueprint §4).
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $t) {
            $t->id();
            $t->string('nombre');
            $t->string('linea')->default('arroz');        // arroz | frijol | aceite | fit
            $t->string('presentacion')->nullable();        // "1.8 kg / 1 kg", "700 g", ...
            $t->text('descripcion')->nullable();
            $t->string('pack_color')->default('red');      // red | blue | celeste | wheat
            $t->string('pack_kind')->default('bag');       // bag | bottle
            $t->string('tag')->nullable();
            $t->string('tag_color')->nullable();
            $t->string('imagen')->nullable();
            $t->unsignedInteger('orden')->default(0);
            $t->boolean('estado')->default(true);
            $t->timestamps();
        });

        Schema::create('recetas', function (Blueprint $t) {
            $t->id();
            $t->string('nombre');
            $t->string('tipo')->nullable();
            $t->text('ingredientes')->nullable();
            $t->text('instrucciones')->nullable();
            $t->string('porciones')->nullable();
            $t->string('preparacion')->nullable();
            $t->string('dificultad')->nullable();
            $t->string('imagen')->nullable();
            $t->string('slug');
            $t->boolean('estado')->default(true);
            $t->timestamps();
        });

        Schema::create('carruseles', function (Blueprint $t) {
            $t->id();
            $t->string('nombre');
            $t->text('descripcion')->nullable();
            $t->string('link')->nullable();
            $t->string('imagen_lg')->nullable();
            $t->string('imagen_md')->nullable();
            $t->string('imagen_xs')->nullable();
            $t->unsignedInteger('orden')->default(0);
            $t->boolean('estado')->default(true);
            $t->timestamps();
        });

        Schema::create('companias', function (Blueprint $t) {
            $t->id();
            $t->string('nombre');
            $t->timestamps();
        });

        Schema::create('provincias', function (Blueprint $t) {
            $t->id();
            $t->string('nombre');
            $t->timestamps();
        });

        Schema::create('ubicaciones', function (Blueprint $t) {
            $t->id();
            $t->foreignId('provincia_id')->constrained('provincias')->cascadeOnDelete();
            $t->string('nombre');
            $t->text('descripcion')->nullable();
            $t->string('periodo_dias')->nullable();
            $t->string('periodo_horas')->nullable();
            $t->string('telefono')->nullable();
            $t->string('email')->nullable();
            $t->string('waze')->nullable();
            $t->string('google_maps')->nullable();
            $t->text('iframe_map')->nullable();
            $t->unsignedInteger('orden')->default(0);
            $t->timestamps();
        });

        Schema::create('catalogos', function (Blueprint $t) {
            $t->id();
            $t->string('nombre');
            $t->string('slug');
            $t->string('imagen')->nullable();
            $t->string('archivo')->nullable();             // PDF
            $t->unsignedInteger('orden')->default(0);
            $t->boolean('estado')->default(true);
            $t->timestamps();
        });

        Schema::create('eventos', function (Blueprint $t) {
            $t->id();
            $t->string('nombre');
            $t->text('descripcion')->nullable();
            $t->date('fecha')->nullable();
            $t->string('imagen')->nullable();
            $t->string('slug');
            $t->boolean('estado')->default(true);
            $t->timestamps();
        });

        Schema::create('responsabilidades', function (Blueprint $t) {
            $t->id();
            $t->string('titulo');
            $t->text('descripcion')->nullable();
            $t->string('imagen')->nullable();
            $t->unsignedInteger('orden')->default(0);
            $t->boolean('estado')->default(true);
            $t->timestamps();
        });

        Schema::create('contactos', function (Blueprint $t) {
            $t->id();
            $t->string('nombre');
            $t->string('email');
            $t->string('telefono')->nullable();
            $t->string('asunto')->nullable();
            $t->text('mensaje');
            $t->timestamps();
        });

        Schema::create('puestos_vacantes', function (Blueprint $t) {
            $t->id();
            $t->string('titulo');
            $t->text('descripcion')->nullable();
            $t->text('requisitos')->nullable();
            $t->string('ubicacion')->nullable();
            $t->string('slug');
            $t->boolean('estado')->default(true);
            $t->timestamps();
        });

        Schema::create('parametros', function (Blueprint $t) {
            $t->id();
            $t->string('clave')->unique();
            $t->text('valor')->nullable();
            $t->string('url')->nullable();
            $t->timestamps();
        });

        Schema::create('promociones', function (Blueprint $t) {
            $t->id();
            $t->string('nombre');
            $t->text('descripcion')->nullable();
            $t->string('imagen')->nullable();
            $t->unsignedInteger('orden')->default(0);
            $t->boolean('estado')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach ([
            'promociones', 'parametros', 'puestos_vacantes', 'contactos',
            'responsabilidades', 'eventos', 'catalogos', 'ubicaciones',
            'provincias', 'companias', 'carruseles', 'recetas', 'productos',
        ] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
