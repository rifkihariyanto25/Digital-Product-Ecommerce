<?php

namespace App\Filament\Resources\Settings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular(),
                
                TextColumn::make('nama_toko')
                    ->label('Nama Toko')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('nomor_telepon_toko')
                    ->label('Payment Gateway')
                    ->formatStateUsing(fn ($record) => 
                        $record->payment_gateway ? 'Aktif' : 'Tidak Aktif'
                    ),
                
                IconColumn::make('payment_gateway')
                    ->label('Payment Gateway')
                    ->boolean(),
                
                IconColumn::make('notifikasi_whatsapp')
                    ->label('Notifikasi WhatsApp')
                    ->boolean(),
            ])
            ->filters([
                //
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
