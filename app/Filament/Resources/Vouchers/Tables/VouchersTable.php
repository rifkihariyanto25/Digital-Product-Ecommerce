<?php

namespace App\Filament\Resources\Vouchers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;

class VouchersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_voucher')
                    ->label('Kode Voucher')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                
                TextColumn::make('nama_voucher')
                    ->label('Nama Voucher')
                    ->searchable()
                    ->sortable(),
                
                BadgeColumn::make('tipe')
                    ->label('Tipe')
                    ->colors([
                        'success' => 'persentase',
                        'info' => 'nominal',
                    ])
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
                
                TextColumn::make('nilai')
                    ->label('Nilai')
                    ->formatStateUsing(fn ($record) => 
                        $record->tipe === 'persentase' 
                            ? $record->nilai . '%' 
                            : 'Rp ' . number_format($record->nilai, 0, ',', '.')
                    )
                    ->sortable(),
                
                TextColumn::make('batas_penggunaan')
                    ->label('Batas/Penggunaan')
                    ->formatStateUsing(fn ($record) => 
                        $record->jumlah_terpakai . '/' . $record->batas_penggunaan
                    )
                    ->sortable(),
                
                TextColumn::make('berlaku_dari')
                    ->label('Berlaku Dari')
                    ->date('d-m-Y')
                    ->sortable(),
                
                TextColumn::make('berlaku_sampai')
                    ->label('Berlaku Sampai')
                    ->date('d-m-Y')
                    ->sortable(),
                
                ToggleColumn::make('is_active')
                    ->label('Is active'),
            ])
            ->filters([
                SelectFilter::make('tipe')
                    ->label('Tipe')
                    ->options([
                        'persentase' => 'Persentase',
                        'nominal' => 'Nominal',
                    ]),
                
                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        true => 'Active',
                        false => 'Inactive',
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
