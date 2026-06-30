<?php

namespace App\Filament\Resources\Carrusels;

use App\Filament\Resources\Carrusels\Pages\CreateCarrusel;
use App\Filament\Resources\Carrusels\Pages\EditCarrusel;
use App\Filament\Resources\Carrusels\Pages\ListCarrusels;
use App\Filament\Resources\Carrusels\Schemas\CarruselForm;
use App\Filament\Resources\Carrusels\Tables\CarruselsTable;
use App\Models\Carrusel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CarruselResource extends Resource
{
    protected static ?string $model = Carrusel::class;

    protected static ?string $navigationLabel = 'Carruseles';

    protected static ?string $modelLabel = 'Carrusel';

    protected static ?string $pluralModelLabel = 'Carruseles';

    protected static string|\UnitEnum|null $navigationGroup = 'Contenido';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return CarruselForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CarruselsTable::configure($table);
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
            'index' => ListCarrusels::route('/'),
            'create' => CreateCarrusel::route('/create'),
            'edit' => EditCarrusel::route('/{record}/edit'),
        ];
    }
}
