<?php

namespace App\Filament\Resources\Paginas\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PaginaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Encabezado')
                    ->description('La parte de arriba de la página.')
                    ->schema([
                        TextInput::make('contenido.hero.eyebrow')->label('Etiqueta superior'),
                        TextInput::make('contenido.hero.titulo')->label('Título')->required(),
                        Textarea::make('contenido.hero.texto')->label('Texto')->rows(3)->columnSpanFull(),
                        TextInput::make('contenido.hero.cta')->label('Texto del botón'),
                    ])
                    ->columns(2),

                Section::make('Beneficios')
                    ->description('Las tarjetas de beneficios. Podés agregar, quitar y reordenar.')
                    ->schema([
                        TextInput::make('contenido.beneficios_eyebrow')->label('Etiqueta superior'),
                        TextInput::make('contenido.beneficios_titulo')->label('Título de la sección'),
                        Repeater::make('contenido.beneficios')
                            ->label('Tarjetas de beneficio')
                            ->schema([
                                Select::make('icono')
                                    ->label('Ícono')
                                    ->options([
                                        'corazon' => '❤️ Corazón (salud)',
                                        'gota' => '💧 Gota (sodio)',
                                        'trigo' => '🌾 Trigo (gluten)',
                                        'chispa' => '✨ Chispa (energía)',
                                        'hoja' => '🍃 Hoja (natural)',
                                        'escudo' => '🛡️ Escudo (protección)',
                                    ])
                                    ->default('chispa')
                                    ->required(),
                                TextInput::make('titulo')->label('Título')->required(),
                                TextInput::make('texto')->label('Descripción'),
                            ])
                            ->columns(3)
                            ->addActionLabel('Agregar beneficio')
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['titulo'] ?? 'Beneficio')
                            ->columnSpanFull(),
                        Textarea::make('contenido.nota')->label('Nota al pie')->rows(2)->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Suscripción de recetas')
                    ->schema([
                        TextInput::make('contenido.newsletter.titulo')->label('Título'),
                        Textarea::make('contenido.newsletter.texto')->label('Texto')->rows(2),
                    ])
                    ->columns(1),
            ]);
    }
}
