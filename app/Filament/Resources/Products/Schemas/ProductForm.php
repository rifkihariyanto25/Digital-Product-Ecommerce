<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Informasi Dasar')
                        ->schema([
                            Select::make('category_id')
                                ->label('Kategori')
                                ->relationship('category', 'name')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->createOptionForm([
                                    TextInput::make('name')
                                        ->label('Nama Kategori')
                                        ->required(),
                                ]),
                            TextInput::make('name')
                                ->label('Nama Produk')
                                ->required()
                                ->maxLength(255),
                            Textarea::make('description')
                                ->label('Deskripsi')
                                ->rows(4)
                                ->columnSpanFull(),
                        ])->columns(2),
                    
                    Step::make('Harga')
                        ->schema([
                            TextInput::make('price')
                                ->label('Harga Normal')
                                ->required()
                                ->numeric()
                                ->prefix('Rp')
                                ->default(0),
                            TextInput::make('discount_price')
                                ->label('Harga Diskon')
                                ->numeric()
                                ->prefix('Rp')
                                ->lt('price'),
                        ])->columns(2),
                    
                    Step::make('Media & Status')
                        ->schema([
                            FileUpload::make('image')
                                ->label('Gambar')
                                ->image()
                                ->directory('products')
                                ->columnSpanFull(),
                            Toggle::make('is_active')
                                ->label('Aktif')
                                ->default(true)
                                ->inline(false),
                            Toggle::make('is_popular')
                                ->label('Populer')
                                ->default(false)
                                ->inline(false),
                        ])->columns(2),
                ])->columnSpanFull(),
            ]);
    }
}
