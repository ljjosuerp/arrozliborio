<?php

namespace App\Filament\Resources\Aplicacions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AplicacionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('aspirante_id')
                    ->relationship('aspirante', 'id')
                    ->required(),
                TextInput::make('puesto_vacante_id')
                    ->required()
                    ->numeric(),
                Textarea::make('mensaje')
                    ->columnSpanFull(),
                TextInput::make('estado')
                    ->required()
                    ->default('recibida'),
            ]);
    }
}
