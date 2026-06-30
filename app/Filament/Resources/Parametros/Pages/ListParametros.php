<?php

namespace App\Filament\Resources\Parametros\Pages;

use App\Filament\Resources\Parametros\ParametroResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListParametros extends ListRecords
{
    protected static string $resource = ParametroResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
