<?php

namespace App\Filament\Resources\Products\Schemas;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name') // ambil dari relasi
                    ->searchable()
                    ->preload()
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                FileUpload::make('image')
                    ->image(),
            ]);
    }
}
