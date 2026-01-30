<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_name')
                    ->label('Info Customer')
                    ->description(fn ($record) => $record->customer_email)
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('order_number')
                    ->label('Order Number')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('harga_produk')
                    ->label('Harga Produk')
                    ->money('IDR')
                    ->sortable(),
                
                TextColumn::make('diskon_produk')
                    ->label('Diskon Produk')
                    ->money('IDR')
                    ->sortable(),
                
                TextColumn::make('layanan_midtrans')
                    ->label('Layanan Midtrans')
                    ->money('IDR')
                    ->sortable(),
                
                TextColumn::make('diskon_voucher')
                    ->label('Diskon Voucher')
                    ->money('IDR')
                    ->sortable(),
                
                TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->money('IDR')
                    ->sortable(),
                
                BadgeColumn::make('payment_method')
                    ->label('Pembayaran')
                    ->colors([
                        'primary' => 'manual',
                        'success' => 'midtrans',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                
                BadgeColumn::make('status_pesanan')
                    ->label('Status Pesanan')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'processing',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                
                BadgeColumn::make('status_pembayaran')
                    ->label('Status Pembayaran')
                    ->colors([
                        'warning' => 'unpaid',
                        'success' => 'paid',
                        'danger' => 'refunded',
                    ])
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'unpaid' => 'Belum Bayar',
                        'paid' => 'Sudah Bayar',
                        'refunded' => 'Refund',
                        default => $state,
                    }),
            ])
            ->filters([
                SelectFilter::make('payment_method')
                    ->label('Pembayaran')
                    ->options([
                        'manual' => 'Manual',
                        'midtrans' => 'Midtrans',
                    ]),
                
                SelectFilter::make('status_pesanan')
                    ->label('Status Pesanan')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                
                SelectFilter::make('status_pembayaran')
                    ->label('Status Pembayaran')
                    ->options([
                        'unpaid' => 'Belum Bayar',
                        'paid' => 'Sudah Bayar',
                        'refunded' => 'Refund',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
