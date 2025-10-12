<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Order Information')->schema([
                    Select::make('user_id')
                        ->label('Customer')
                        ->options(User::pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    Select::make('payment_method')
                        ->options ([
                            'cod' => 'Cash on Delivery',
                            'stripe' => 'Stripe',
                        ])
                        ->required(),
                    TextInput::make('total')
                        ->label('Total Amount')
                        ->numeric()
                        ->prefix('Rp')
                        ->required(),
                    Textarea::make('address_text')
                        ->label('Delivery Address')
                        ->rows(3)
                        ->required(),
                    ToggleButtons::make('status')
                        ->inline()
                        ->default('new')
                        ->required()
                        ->options ([
                            'new' => 'New',
                            'processing' => 'Processing',
                            'shipped' => 'Shipped',
                            'delivered' => 'Delivered',
                            'cancelled' => 'Cancelled'
                        ])
                        ->colors ([
                            'new' => 'info',
                            'processing' => 'warning',
                            'shipped' => 'success',
                            'delivered' => 'success',
                            'cancelled' => 'danger'
                        ])
                        ->icons([
                            'new' => 'heroicon-m-sparkles',
                            'processing' => 'heroicon-m-arrow-path',
                            'shipped' => 'heroicon-m-truck',
                            'delivered' => 'heroicon-m-check-badge',
                            'cancelled' => 'heroicon-m-x-circle'
                        ]),
                ])->columnSpanFull(),
            ]);
    }
}
