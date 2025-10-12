<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Schema;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
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
                    ->columnSpanFull(),
            ]);
    }
}
