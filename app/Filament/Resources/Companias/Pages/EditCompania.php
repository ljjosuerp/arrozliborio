<?php

namespace App\Filament\Resources\Companias\Pages;

use App\Filament\Resources\Companias\CompaniaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCompania extends EditRecord
{
    protected static string $resource = CompaniaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
