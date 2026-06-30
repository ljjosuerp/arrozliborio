<?php

namespace App\Filament\Resources\PuntoVentas\Pages;

use App\Filament\Resources\PuntoVentas\PuntoVentaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPuntoVenta extends EditRecord
{
    protected static string $resource = PuntoVentaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
