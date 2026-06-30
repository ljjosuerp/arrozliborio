<?php

namespace App\Filament\Resources\Recetas\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class RecetaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),
                TextInput::make('tipo')
                    ->label('Producto que usa')
                    ->placeholder('Arroz Liborio 99%')
                    ->helperText('Aparece como etiqueta y en "Hecho con…".'),
                FileUpload::make('imagen')
                    ->label('Foto del plato')
                    ->image()
                    ->disk('public')
                    ->directory('recetas')
                    ->helperText('Foto apetitosa del platillo terminado.')
                    ->columnSpanFull(),
                Textarea::make('ingredientes')
                    ->label('Ingredientes')
                    ->rows(6)
                    ->helperText('Lista en HTML (<ul><li>…</li></ul>) — un ingrediente por <li>.')
                    ->columnSpanFull(),
                Textarea::make('instrucciones')
                    ->label('Preparación')
                    ->rows(8)
                    ->helperText('Un paso por línea. Las líneas que empiecen con 💡 o 👉 se muestran como tip.')
                    ->columnSpanFull(),
                TextInput::make('porciones')
                    ->label('Porciones'),
                TextInput::make('preparacion')
                    ->label('Tiempo de preparación')
                    ->placeholder('35 minutos'),
                TextInput::make('dificultad')
                    ->label('Dificultad')
                    ->placeholder('Baja'),
                TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required(),
                Toggle::make('estado')
                    ->label('Activa')
                    ->default(true)
                    ->required(),
            ]);
    }
}
