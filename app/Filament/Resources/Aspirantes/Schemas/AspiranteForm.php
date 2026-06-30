<?php

namespace App\Filament\Resources\Aspirantes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AspiranteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('telefono')
                    ->tel(),
                TextInput::make('cv_path'),
                TextInput::make('cv_nombre'),
            ]);
    }
}
