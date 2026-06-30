<?php

namespace App\Filament\Resources\PuestoVacantes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PuestoVacanteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('titulo')
                    ->required(),
                Textarea::make('descripcion')
                    ->columnSpanFull(),
                Textarea::make('requisitos')
                    ->columnSpanFull(),
                TextInput::make('ubicacion'),
                TextInput::make('slug')
                    ->required(),
                Toggle::make('estado')
                    ->required(),
            ]);
    }
}
