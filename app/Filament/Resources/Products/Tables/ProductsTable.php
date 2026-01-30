<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Gambar')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->description(fn ($record) => $record->category->name)
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Harga Normal')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('discount_price')
                    ->label('Harga Diskon')
                    ->money('IDR')
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Aktif'),
                ToggleColumn::make('is_popular')
                    ->label('Populer'),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                Filter::make('has_discount')
                    ->label('Diskon')
                    ->query(fn (Builder $query) => $query->whereNotNull('discount_price')),
                Filter::make('is_popular')
                    ->label('Populer')
                    ->query(fn (Builder $query) => $query->where('is_popular', true)),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
