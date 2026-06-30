<?php

namespace App\Filament\Resources\Companias;

use App\Filament\Resources\Companias\Pages\CreateCompania;
use App\Filament\Resources\Companias\Pages\EditCompania;
use App\Filament\Resources\Companias\Pages\ListCompanias;
use App\Filament\Resources\Companias\Schemas\CompaniaForm;
use App\Filament\Resources\Companias\Tables\CompaniasTable;
use App\Models\Compania;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CompaniaResource extends Resource
{
    protected static ?string $model = Compania::class;

    protected static ?string $navigationLabel = 'Compañías';

    protected static ?string $modelLabel = 'Compañía';

    protected static ?string $pluralModelLabel = 'Compañías';

    protected static string|\UnitEnum|null $navigationGroup = 'Comercial';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return CompaniaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompaniasTable::configure($table);
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
            'index' => ListCompanias::route('/'),
            'create' => CreateCompania::route('/create'),
            'edit' => EditCompania::route('/{record}/edit'),
        ];
    }
}
