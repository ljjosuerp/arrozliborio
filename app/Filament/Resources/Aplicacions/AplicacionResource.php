<?php

namespace App\Filament\Resources\Aplicacions;

use App\Filament\Resources\Aplicacions\Pages\CreateAplicacion;
use App\Filament\Resources\Aplicacions\Pages\EditAplicacion;
use App\Filament\Resources\Aplicacions\Pages\ListAplicacions;
use App\Filament\Resources\Aplicacions\Schemas\AplicacionForm;
use App\Filament\Resources\Aplicacions\Tables\AplicacionsTable;
use App\Models\Aplicacion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AplicacionResource extends Resource
{
    protected static ?string $model = Aplicacion::class;

    protected static ?string $navigationLabel = 'Aplicaciones';

    protected static ?string $modelLabel = 'Aplicación';

    protected static ?string $pluralModelLabel = 'Aplicaciones';

    protected static string|\UnitEnum|null $navigationGroup = 'Empleo';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AplicacionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AplicacionsTable::configure($table);
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
            'index' => ListAplicacions::route('/'),
            'create' => CreateAplicacion::route('/create'),
            'edit' => EditAplicacion::route('/{record}/edit'),
        ];
    }
}
