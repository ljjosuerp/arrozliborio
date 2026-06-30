<?php

namespace App\Filament\Resources\Parametros\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ParametroForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('clave')
                    ->required(),
                Textarea::make('valor')
                    ->columnSpanFull(),
                TextInput::make('url')
                    ->url(),
            ]);
    }
}
