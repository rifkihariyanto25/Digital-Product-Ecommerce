<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('avatar')
                    ->label('Foto')
                    ->image()
                    ->disk('public')
                    ->directory('testimonials')
                    ->avatar()
                    ->columnSpanFull(),
                TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                TextInput::make('position')
                    ->label('Jabatan')
                    ->maxLength(255),
                TextInput::make('company')
                    ->label('Perusahaan')
                    ->maxLength(255),
                Textarea::make('content')
                    ->label('Testimoni')
                    ->required()
                    ->rows(4)
                    ->columnSpanFull(),
                TextInput::make('rating')
                    ->label('Rating')
                    ->numeric()
                    ->default(5)
                    ->minValue(1)
                    ->maxValue(5)
                    ->suffix('⭐'),
                TextInput::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0)
                    ->minValue(0),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true)
                    ->required(),
            ]);
    }
}
