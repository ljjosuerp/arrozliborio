<?php

namespace App\Filament\Resources\PuestoVacantes\Pages;

use App\Filament\Resources\PuestoVacantes\PuestoVacanteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPuestoVacante extends EditRecord
{
    protected static string $resource = PuestoVacanteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
