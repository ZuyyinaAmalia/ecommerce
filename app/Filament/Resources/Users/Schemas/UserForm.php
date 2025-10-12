<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord; 
use Filament\Resources\Pages\Page;      
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    -> maxLength(255)
                    -> unique(ignoreRecord: true)
                    ->required(),
                Select::make('role')
                    ->label('Role')
                    ->options([
                        'admin' => 'Admin',
                        'pengguna' => 'Pengguna',
                    ])
                    ->default('pengguna')
                    ->required(),
                DateTimePicker::make('email_verified_at')
                    ->label('Email Verified at'),
                TextInput::make('password')
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (Page $livewire) : bool => $livewire instanceof CreateRecord),
            ]);
    }
}
