<?php

namespace App\Filament\Resources\PuestoVacantes\Pages;

use App\Filament\Resources\PuestoVacantes\PuestoVacanteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPuestoVacantes extends ListRecords
{
    protected static string $resource = PuestoVacanteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
