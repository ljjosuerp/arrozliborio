<?php

namespace App\Filament\Resources\Aspirantes\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AspiranteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos del postulante')
                    ->description('La ficha de la persona. Sus mensajes y a qué puestos aplicó están en "Postulaciones".')
                    ->schema([
                        TextInput::make('nombre')
                            ->label('Nombre')
                            ->required(),
                        TextInput::make('email')
                            ->label('Correo')
                            ->email()
                            ->required(),
                        TextInput::make('telefono')
                            ->label('Teléfono')
                            ->tel(),
                    ])
                    ->columns(3),

                Section::make('Currículum')
                    ->schema([
                        Placeholder::make('cv_estado')
                            ->label('Archivo adjunto')
                            ->content(fn ($record) => $record?->cv_nombre ?: 'Sin CV adjunto'),
                        Placeholder::make('cv_ayuda')
                            ->hiddenLabel()
                            ->content('Para abrirlo, usá el botón "Descargar CV" en la lista de aspirantes.'),
                    ])
                    ->columns(2),
            ]);
    }
}
