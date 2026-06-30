<?php

namespace App\Filament\Resources\Carrusels\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CarruselForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),
                Textarea::make('descripcion')
                    ->columnSpanFull(),
                TextInput::make('link'),
                TextInput::make('imagen_lg'),
                TextInput::make('imagen_md'),
                TextInput::make('imagen_xs'),
                TextInput::make('orden')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('estado')
                    ->required(),
            ]);
    }
}
