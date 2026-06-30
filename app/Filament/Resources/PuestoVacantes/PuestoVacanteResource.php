<?php

namespace App\Filament\Resources\PuestoVacantes;

use App\Filament\Resources\PuestoVacantes\Pages\CreatePuestoVacante;
use App\Filament\Resources\PuestoVacantes\Pages\EditPuestoVacante;
use App\Filament\Resources\PuestoVacantes\Pages\ListPuestoVacantes;
use App\Filament\Resources\PuestoVacantes\Schemas\PuestoVacanteForm;
use App\Filament\Resources\PuestoVacantes\Tables\PuestoVacantesTable;
use App\Models\PuestoVacante;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PuestoVacanteResource extends Resource
{
    protected static ?string $model = PuestoVacante::class;

    protected static ?string $navigationLabel = 'Puestos vacantes';

    protected static ?string $modelLabel = 'Puesto vacante';

    protected static ?string $pluralModelLabel = 'Puestos vacantes';

    protected static string|\UnitEnum|null $navigationGroup = 'Empleo';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PuestoVacanteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PuestoVacantesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPuestoVacantes::route('/'),
            'create' => CreatePuestoVacante::route('/create'),
            'edit' => EditPuestoVacante::route('/{record}/edit'),
        ];
    }
}
