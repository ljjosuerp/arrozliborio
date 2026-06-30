<?php

namespace App\Filament\Resources\Parametros;

use App\Filament\Resources\Parametros\Pages\CreateParametro;
use App\Filament\Resources\Parametros\Pages\EditParametro;
use App\Filament\Resources\Parametros\Pages\ListParametros;
use App\Filament\Resources\Parametros\Schemas\ParametroForm;
use App\Filament\Resources\Parametros\Tables\ParametrosTable;
use App\Models\Parametro;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ParametroResource extends Resource
{
    protected static ?string $model = Parametro::class;

    protected static ?string $navigationLabel = 'Parámetros';

    protected static ?string $modelLabel = 'Parámetro';

    protected static ?string $pluralModelLabel = 'Parámetros';

    protected static string|\UnitEnum|null $navigationGroup = 'Sistema';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ParametroForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ParametrosTable::configure($table);
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
            'index' => ListParametros::route('/'),
            'create' => CreateParametro::route('/create'),
            'edit' => EditParametro::route('/{record}/edit'),
        ];
    }
}
