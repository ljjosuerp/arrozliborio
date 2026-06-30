<?php

namespace App\Filament\Resources\Responsabilidads\Pages;

use App\Filament\Resources\Responsabilidads\ResponsabilidadResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditResponsabilidad extends EditRecord
{
    protected static string $resource = ResponsabilidadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
