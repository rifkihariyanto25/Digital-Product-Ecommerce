<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Components\Textarea;
use Filament\Schemas\Components\Select;
use Filament\Schemas\Components\Section;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Customer')
                    ->schema([
                        TextInput::make('order_number')
                            ->label('Order Number')
                            ->default(fn () => 'ORD-' . strtoupper(uniqid()))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        
                        TextInput::make('customer_name')
                            ->label('Nama Customer')
                            ->required()
                            ->maxLength(255),
                        
                        TextInput::make('customer_email')
                            ->label('Email Customer')
                            ->email()
                            ->maxLength(255),
                        
                        TextInput::make('customer_phone')
                            ->label('No. Telepon')
                            ->tel()
                            ->maxLength(255),
                        
                        Textarea::make('customer_address')
                            ->label('Alamat Customer')
                            ->rows(3),
                    ])
                    ->columns(2),

                Section::make('Detail Harga')
                    ->schema([
                        TextInput::make('harga_produk')
                            ->label('Harga Produk')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->default(0),
                        
                        TextInput::make('diskon_produk')
                            ->label('Diskon Produk')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0),
                        
                        TextInput::make('layanan_midtrans')
                            ->label('Layanan Midtrans')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0),
                        
                        TextInput::make('diskon_voucher')
                            ->label('Diskon Voucher')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0),
                        
                        TextInput::make('total_amount')
                            ->label('Total Amount')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->default(0),
                    ])
                    ->columns(2),

                Section::make('Pembayaran & Status')
                    ->schema([
                        Select::make('payment_method')
                            ->label('Pembayaran')
                            ->options([
                                'manual' => 'Manual',
                                'midtrans' => 'Midtrans',
                            ])
                            ->required()
                            ->default('manual'),
                        
                        Select::make('status_pesanan')
                            ->label('Status Pesanan')
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->default('pending'),
                        
                        Select::make('status_pembayaran')
                            ->label('Status Pembayaran')
                            ->options([
                                'unpaid' => 'Belum Bayar',
                                'paid' => 'Sudah Bayar',
                                'refunded' => 'Refund',
                            ])
                            ->required()
                            ->default('unpaid'),
                        
                        Textarea::make('notes')
                            ->label('Catatan')
                            ->rows(3),
                    ])
                    ->columns(2),
            ]);
    }
}

