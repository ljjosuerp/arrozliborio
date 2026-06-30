<?php

namespace App\Filament\Resources\Aplicacions\Pages;

use App\Filament\Resources\Aplicacions\AplicacionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAplicacion extends EditRecord
{
    protected static string $resource = AplicacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
