<?php

namespace App\Filament\Resources\Aspirantes;

use App\Filament\Resources\Aspirantes\Pages\CreateAspirante;
use App\Filament\Resources\Aspirantes\Pages\EditAspirante;
use App\Filament\Resources\Aspirantes\Pages\ListAspirantes;
use App\Filament\Resources\Aspirantes\Schemas\AspiranteForm;
use App\Filament\Resources\Aspirantes\Tables\AspirantesTable;
use App\Models\Aspirante;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AspiranteResource extends Resource
{
    protected static ?string $model = Aspirante::class;

    protected static ?string $navigationLabel = 'Aspirantes';

    protected static ?string $modelLabel = 'Aspirante';

    protected static ?string $pluralModelLabel = 'Aspirantes';

    protected static string|\UnitEnum|null $navigationGroup = 'Empleo';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return AspiranteForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AspirantesTable::configure($table);
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
            'index' => ListAspirantes::route('/'),
            'create' => CreateAspirante::route('/create'),
            'edit' => EditAspirante::route('/{record}/edit'),
        ];
    }
}
