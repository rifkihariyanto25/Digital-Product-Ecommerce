<?php

namespace App\Filament\Resources\MediaCoverages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MediaCoverageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('logo')
                    ->label('Logo Media')
                    ->image()
                    ->directory('media-coverages')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('name')
                    ->label('Nama Media')
                    ->required()
                    ->maxLength(255),
                TextInput::make('url')
                    ->label('URL Media')
                    ->url()
                    ->placeholder('https://example.com')
                    ->maxLength(255),
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
