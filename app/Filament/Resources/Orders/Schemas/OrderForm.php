<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\User;
use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Utilities\Get;

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

                Section::make('Order Items')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('product_id')
                                    ->label('Product')
                                    ->relationship('product', 'name')
                                    ->options(function (callable $get) {
                                        $selectedProductIds = collect($get('../../items'))
                                            ->pluck('product_id')
                                            ->filter()
                                            ->toArray();

                                        return \App\Models\Product::query()
                                            ->when($selectedProductIds, fn ($q) => $q->whereNotIn('id', $selectedProductIds))
                                            ->pluck('name', 'id');
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->distinct()
                                    ->required()
                                    ->columnSpan(4)
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $product = \App\Models\Product::find($state);
                                        $set('price', $product?->price ?? 0);
                                        $qty = (float) ($get('qty') ?? 1);
                                        $set('subtotal', $qty * ($product?->price ?? 0));
                                    }),

                                TextInput::make('qty')
                                    ->label('Quantity')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1)
                                    ->columnSpan(2)
                                    ->reactive()
                                    ->afterStateUpdated(fn ($state, $set, $get) =>
                                        $set('subtotal', (float) ($state ?? 0) * (float) ($get('price') ?? 0))
                                    )
                                    ->default(1),

                                TextInput::make('price')
                                    ->label('Price')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->columnSpan(3)
                                    ->disabled()
                                    ->dehydrated()
                                    ->required(),

                                TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->columnSpan(3)
                                    ->required()
                                    ->dehydrated(),
                            ])
                            ->columns(12)
                            ->columnSpanFull(), 
                        
                        Placeholder::make('total')
                            ->label('Total')
                            ->content(function (callable $get, callable $set) {
                                $items = $get('items') ?? [];

                                // Hitung total dari subtotal tiap item (aman dan ringkas)
                                $total = collect($items)->sum(fn ($item) => (float) ($item['subtotal'] ?? 0));

                                // Simpan ke state root supaya Hidden menerima nilainya
                                $set('total', $total);

                                return 'IDR ' . number_format($total, 0, ',', '.');
                            })
                            ->columnSpanFull(),

                        Hidden::make('total')
                            ->default(0)
                            ->reactive()     // penting supaya bisa menerima perubahan dari $set()
                            ->dehydrated()   // pastikan akan disimpan ke DB
                            ->afterStateHydrated(function (callable $set, callable $get) {
                                // ketika buka form edit, inisialisasi nilai total dari items yang sudah ada
                                $total = collect($get('items') ?? [])->sum(fn ($i) => (float) ($i['subtotal'] ?? 0));
                                $set('total', $total);
                            }),

                    ])->columnSpanFull(), // optional, tapi bisa bantu jika section di grid
            ]);
    }
}
