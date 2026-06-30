<?php

namespace App\Filament\Resources\Companias\Pages;

use App\Filament\Resources\Companias\CompaniaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCompanias extends ListRecords
{
    protected static string $resource = CompaniaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
