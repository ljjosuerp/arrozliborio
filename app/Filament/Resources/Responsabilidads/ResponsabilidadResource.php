<?php

namespace App\Filament\Resources\Responsabilidads;

use App\Filament\Resources\Responsabilidads\Pages\CreateResponsabilidad;
use App\Filament\Resources\Responsabilidads\Pages\EditResponsabilidad;
use App\Filament\Resources\Responsabilidads\Pages\ListResponsabilidads;
use App\Filament\Resources\Responsabilidads\Schemas\ResponsabilidadForm;
use App\Filament\Resources\Responsabilidads\Tables\ResponsabilidadsTable;
use App\Models\Responsabilidad;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ResponsabilidadResource extends Resource
{
    protected static ?string $model = Responsabilidad::class;

    protected static ?string $navigationLabel = 'Responsabilidades';

    protected static ?string $modelLabel = 'Responsabilidad';

    protected static ?string $pluralModelLabel = 'Responsabilidades';

    protected static string|\UnitEnum|null $navigationGroup = 'Contenido';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ResponsabilidadForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ResponsabilidadsTable::configure($table);
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
            'index' => ListResponsabilidads::route('/'),
            'create' => CreateResponsabilidad::route('/create'),
            'edit' => EditResponsabilidad::route('/{record}/edit'),
        ];
    }
}
