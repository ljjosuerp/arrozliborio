<?php

namespace App\Filament\Resources\Paginas\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaginasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Página')
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->label('Última edición')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make()->label('Editar contenido'),
            ]);
    }
}
