<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
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
                    
                    Step::make('Media')
                        ->schema([
                            FileUpload::make('image')
                                ->label('Gambar Utama')
                                ->image()
                                ->disk('public')
                                ->directory('products')
                                ->required()
                                ->columnSpanFull(),
                            FileUpload::make('gallery')
                                ->label('Galeri Foto')
                                ->image()
                                ->disk('public')
                                ->directory('products/gallery')
                                ->multiple()
                                ->reorderable()
                                ->maxFiles(10)
                                ->columnSpanFull()
                                ->helperText('Upload hingga 10 foto produk'),
                        ]),
                    
                    Step::make('Detail Produk')
                        ->schema([
                            Repeater::make('testimonials')
                                ->label('Testimoni Produk')
                                ->schema([
                                    TextInput::make('name')
                                        ->label('Nama')
                                        ->required(),
                                    TextInput::make('position')
                                        ->label('Jabatan/Perusahaan'),
                                    Textarea::make('content')
                                        ->label('Testimoni')
                                        ->required()
                                        ->rows(2),
                                    TextInput::make('rating')
                                        ->label('Rating')
                                        ->numeric()
                                        ->default(5)
                                        ->minValue(1)
                                        ->maxValue(5),
                                ])
                                ->columns(2)
                                ->collapsed()
                                ->columnSpanFull(),
                            
                            Repeater::make('faqs')
                                ->label('FAQ Produk')
                                ->schema([
                                    TextInput::make('question')
                                        ->label('Pertanyaan')
                                        ->required()
                                        ->columnSpanFull(),
                                    Textarea::make('answer')
                                        ->label('Jawaban')
                                        ->required()
                                        ->rows(3)
                                        ->columnSpanFull(),
                                ])
                                ->collapsed()
                                ->columnSpanFull(),
                            
                            Repeater::make('bonuses')
                                ->label('Bonus/Keuntungan')
                                ->schema([
                                    TextInput::make('title')
                                        ->label('Judul Bonus')
                                        ->required(),
                                    Textarea::make('description')
                                        ->label('Deskripsi')
                                        ->rows(2),
                                ])
                                ->columns(2)
                                ->collapsed()
                                ->columnSpanFull(),
                        ]),
                    
                    Step::make('Status')
                        ->schema([
                            Toggle::make('is_active')
                                ->label('Aktif')
                                ->default(true)
                                ->inline(false),
                            Toggle::make('is_popular')
                                ->label('Populer')
                                ->default(false)
                                ->inline(false)
                                ->helperText('Produk populer akan ditampilkan di section "Paling Laris"'),
                        ])->columns(2),
                ])->columnSpanFull(),
            ]);
    }
}
