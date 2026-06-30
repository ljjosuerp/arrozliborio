<?php

namespace App\Filament\Resources\Responsabilidads\Pages;

use App\Filament\Resources\Responsabilidads\ResponsabilidadResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListResponsabilidads extends ListRecords
{
    protected static string $resource = ResponsabilidadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
