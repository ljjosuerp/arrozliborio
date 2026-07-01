<?php

namespace App\Filament\Resources\Aplicacions\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AplicacionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Postulante')
                    ->schema([
                        Placeholder::make('p_nombre')
                            ->label('Nombre')
                            ->content(fn ($record) => $record?->aspirante?->nombre ?? '—'),
                        Placeholder::make('p_email')
                            ->label('Correo')
                            ->content(fn ($record) => $record?->aspirante?->email ?? '—'),
                        Placeholder::make('p_tel')
                            ->label('Teléfono')
                            ->content(fn ($record) => $record?->aspirante?->telefono ?: '—'),
                        Placeholder::make('p_cv')
                            ->label('CV')
                            ->content(fn ($record) => $record?->aspirante?->cv_nombre ?: 'Sin CV adjunto'),
                    ])
                    ->columns(2),

                Section::make('Puesto')
                    ->schema([
                        Placeholder::make('p_puesto')
                            ->label('Vacante')
                            ->content(fn ($record) => $record?->puesto?->titulo ?? '—'),
                        Placeholder::make('p_fecha')
                            ->label('Fecha de postulación')
                            ->content(fn ($record) => $record?->created_at?->format('d/m/Y H:i') ?? '—'),
                    ])
                    ->columns(2),

                Section::make('Mensaje del postulante')
                    ->schema([
                        Placeholder::make('p_mensaje')
                            ->label('')
                            ->content(fn ($record) => $record?->mensaje ?: '(Sin mensaje)'),
                    ]),

                Section::make('Gestión')
                    ->description('Cambiá el estado a medida que avanza el proceso.')
                    ->schema([
                        Select::make('estado')
                            ->label('Estado')
                            ->options([
                                'recibida' => 'Recibida',
                                'en_revision' => 'En revisión',
                                'contactado' => 'Contactado',
                                'descartado' => 'Descartado',
                            ])
                            ->default('recibida')
                            ->required(),
                    ]),
            ]);
    }
}
