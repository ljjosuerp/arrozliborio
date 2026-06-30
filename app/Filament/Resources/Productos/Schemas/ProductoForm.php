<?php

namespace App\Filament\Resources\Productos\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre')
                    ->required(),
                Select::make('linea')
                    ->label('Línea')
                    ->options([
                        'arroz' => 'Arroz',
                        'frijol' => 'Frijoles',
                        'aceite' => 'Aceite',
                        'fit' => 'Liborio Fit',
                    ])
                    ->required()
                    ->default('arroz'),
                TextInput::make('presentacion')
                    ->label('Presentación')
                    ->placeholder('1.8 kg / 1 kg'),
                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->columnSpanFull(),
                FileUpload::make('imagen')
                    ->label('Foto del producto')
                    ->image()
                    ->disk('public')
                    ->directory('productos')
                    ->helperText('Si subís una foto, reemplaza al empaque estilizado en la web.')
                    ->columnSpanFull(),
                Select::make('pack_color')
                    ->label('Color de empaque (respaldo sin foto)')
                    ->options([
                        'red' => 'Rojo',
                        'blue' => 'Azul',
                        'celeste' => 'Celeste',
                        'wheat' => 'Trigo',
                    ])
                    ->required()
                    ->default('red'),
                Select::make('pack_kind')
                    ->label('Tipo de empaque')
                    ->options([
                        'bag' => 'Bolsa',
                        'bottle' => 'Botella',
                    ])
                    ->required()
                    ->default('bag'),
                TextInput::make('tag')
                    ->label('Etiqueta'),
                TextInput::make('tag_color')
                    ->label('Color de etiqueta'),
                Repeater::make('enlaces_compra')
                    ->label('Enlaces de compra online')
                    ->schema([
                        TextInput::make('tienda')
                            ->label('Tienda')
                            ->placeholder('Auto Mercado')
                            ->required(),
                        TextInput::make('url')
                            ->label('Enlace (URL)')
                            ->url()
                            ->required(),
                    ])
                    ->columns(2)
                    ->addActionLabel('Agregar tienda')
                    ->helperText('Si no agregás enlaces, el botón "Dónde comprar" usa Google Shopping.')
                    ->columnSpanFull(),
                TextInput::make('orden')
                    ->label('Orden')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('estado')
                    ->label('Activo')
                    ->default(true)
                    ->required(),
            ]);
    }
}
