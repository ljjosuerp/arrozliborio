<?php

namespace App\Filament\Resources\PuntoVentas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PuntoVentaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('region'),
                TextInput::make('direccion'),
                TextInput::make('lat')
                    ->numeric(),
                TextInput::make('lng')
                    ->numeric(),
                TextInput::make('precision')
                    ->required()
                    ->default('aproximada'),
                Textarea::make('productos')
                    ->columnSpanFull(),
                Toggle::make('estado')
                    ->required(),
            ]);
    }
}
