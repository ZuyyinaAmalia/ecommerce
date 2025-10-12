<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('price')
                    ->money(),
                TextEntry::make('stock')
                    ->numeric(),
                TextEntry::make('category_id')
                    ->numeric(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
                ImageEntry::make('image')
                    ->label('')
                            ->disk('public')
                            ->visibility('public')
                            ->height(200)
                            ->width(200)
                            ->extraImgAttributes([
                                'class' => 'rounded-lg shadow-md'
                            ])
                            ->stacked() // Untuk multiple images
                            ->limit(5) // Limit yang ditampilkan
                            ->columnSpanFull(),
            ]);
    }
}
