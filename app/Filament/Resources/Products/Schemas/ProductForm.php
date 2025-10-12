<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Schemas\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema // ✅ GUNAKAN Schema
    {
        return $schema
            ->components([
                Section::make('Product Information')->schema([
                    TextInput::make('name')
                        ->required()
                        ->columnSpanFull()
                        ->maxLength(255),
                    Textarea::make('description')
                        ->columnSpanFull(),
                ])->columns(2),

                Section::make()->schema([
                    TextInput::make('stock')
                        ->required()
                        ->numeric()
                        ->default(0),
                    TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->prefix('IDR'),
                    Select::make('category_id')
                        ->label('Category')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload(),
                ]),

                Section::make()->schema([
                    FileUpload::make('image')
                    ->image()
                    ->multiple()
                    ->maxFiles(5)
                    ->disk('public')
                    ->directory('products')
                    ->visibility('public')
                    ->reorderable()
                    ->preserveFilenames() 
                    ->required()
                    ->columnSpanFull(),
                ])->columnSpanFull(),

                Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }
}