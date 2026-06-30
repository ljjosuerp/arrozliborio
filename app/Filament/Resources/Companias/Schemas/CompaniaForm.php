<?php

namespace App\Filament\Resources\Companias\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CompaniaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),
            ]);
    }
}
