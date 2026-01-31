<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Informasi Toko')
                        ->schema([
                            FileUpload::make('logo')
                                ->label('Logo Toko')
                                ->image()
                                ->disk('public')
                                ->directory('settings')
                                ->helperText('Upload logo toko Anda (format: jpg, png)'),
                            
                            TextInput::make('nama_toko')
                                ->label('Nama Toko')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Ruang Digital'),
                            
                            Textarea::make('deskripsi_toko')
                                ->label('Deskripsi Toko')
                                ->rows(3)
                                ->placeholder('Platform terpercaya untuk membeli produk digital berkualitas')
                                ->helperText('Deskripsikan toko Anda secara singkat'),
                            
                            TextInput::make('email_toko')
                                ->label('Email Toko')
                                ->email()
                                ->maxLength(255)
                                ->placeholder('info@ruangdigital.com'),
                            
                            TextInput::make('nomor_telepon_toko')
                                ->label('Nomor Telepon Toko')
                                ->tel()
                                ->maxLength(255)
                                ->placeholder('6285758952957')
                                ->helperText('Masukkan nomor telepon toko dengan kode negara'),
                        ]),

                    Step::make('Media Sosial')
                        ->schema([
                            TextInput::make('facebook')
                                ->label('Facebook')
                                ->url()
                                ->maxLength(255)
                                ->placeholder('https://facebook.com/ruangdigital'),
                            
                            TextInput::make('instagram')
                                ->label('Instagram')
                                ->url()
                                ->maxLength(255)
                                ->placeholder('https://instagram.com/ruangdigital'),
                            
                            TextInput::make('tiktok')
                                ->label('TikTok')
                                ->url()
                                ->maxLength(255)
                                ->placeholder('https://tiktok.com/@ruangdigital'),
                            
                            TextInput::make('youtube')
                                ->label('YouTube')
                                ->url()
                                ->maxLength(255)
                                ->placeholder('https://youtube.com/ruangdigital'),
                            
                            TextInput::make('sebelumnya')
                                ->label('Sebelumnya')
                                ->disabled()
                                ->dehydrated(false),
                        ]),

                    Step::make('Fitur Lanjutan')
                        ->schema([
                            Toggle::make('payment_gateway')
                                ->label('Payment Gateway')
                                ->default(false)
                                ->reactive()
                                ->helperText('Aktifkan untuk menggunakan sistem pembayaran otomatis'),
                            
                            TextInput::make('biaya_layanan_midtrans')
                                ->label('Biaya Layanan Midtrans')
                                ->numeric()
                                ->prefix('Rp')
                                ->default(10000)
                                ->visible(fn ($get) => $get('payment_gateway'))
                                ->helperText('Masukkan biaya layanan Midtrans'),
                            
                            Toggle::make('notifikasi_whatsapp')
                                ->label('Notifikasi WhatsApp')
                                ->default(false)
                                ->reactive()
                                ->helperText('Aktifkan untuk mengirim notifikasi WhatsApp Owner'),
                            
                            TextInput::make('nomor_whatsapp_owner')
                                ->label('Nomor WhatsApp Owner')
                                ->tel()
                                ->maxLength(255)
                                ->placeholder('6285761853324')
                                ->visible(fn ($get) => $get('notifikasi_whatsapp'))
                                ->helperText('Kosongkan jika notifikasi whatsapp tidak diaktifkan'),
                            
                            TextInput::make('sebelumnya')
                                ->label('Sebelumnya')
                                ->disabled()
                                ->dehydrated(false),
                        ]),
                ])
                ->columnSpanFull(),
            ]);
    }
}
