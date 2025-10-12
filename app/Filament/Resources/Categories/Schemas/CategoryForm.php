<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('categories')
                    ->visibility('public')
                    ->multiple(false)
                    ->preserveFilenames() // ✅ AGAR FILENAME TIDAK DI-RANDOM
                    ->imagePreviewHeight(150) // ✅ TINGGI PREVIEW
                    ->panelAspectRatio('3:2') // ✅ RASIO PREVIEW
                    ->panelLayout('integrated') // ✅ LAYOUT PREVIEW
                    ->uploadingMessage('Uploading...') // ✅ PESAN SAAT UPLOAD
                    ->downloadable() // ✅ BISA DOWNLOAD GAMBAR
                    ->openable() // ✅ BISA BUKA GAMBAR DI TAB BARU
                    ->default(fn($state) => $state)
                    ->saveUploadedFileUsing(function ($file, $livewire) {
                        return $file->store('categories', 'public'); // return string path
                    })
                    ->getUploadedFileNameForStorageUsing(function ($file) {
                        return $file->getClientOriginalName();
                    }),
            ]);
    }
}
