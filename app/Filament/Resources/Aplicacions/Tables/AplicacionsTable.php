<?php

namespace App\Filament\Resources\Aplicacions\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AplicacionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                TextColumn::make('aspirante.nombre')
                    ->label('Postulante')
                    ->searchable(),
                TextColumn::make('aspirante.email')
                    ->label('Correo')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('puesto.titulo')
                    ->label('Puesto')
                    ->searchable(),
                TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'recibida' => 'Recibida',
                        'en_revision' => 'En revisión',
                        'contactado' => 'Contactado',
                        'descartado' => 'Descartado',
                        default => $state,
                    })
                    ->color(fn (?string $state) => match ($state) {
                        'recibida' => 'gray',
                        'en_revision' => 'warning',
                        'contactado' => 'success',
                        'descartado' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                // Descarga vía ruta dedicada (se abre directo, sin pasar por Livewire).
                Action::make('descargarCv')
                    ->label('CV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->visible(fn ($record) => filled($record->aspirante?->cv_path))
                    ->url(fn ($record) => route('cv.descargar', $record->aspirante), shouldOpenInNewTab: true),
                EditAction::make()->label('Ver / gestionar'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
