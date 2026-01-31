<?php

namespace App\Filament\Resources\InformationCards;

use App\Filament\Resources\InformationCards\Pages\CreateInformationCard;
use App\Filament\Resources\InformationCards\Pages\EditInformationCard;
use App\Filament\Resources\InformationCards\Pages\ListInformationCards;
use App\Filament\Resources\InformationCards\Schemas\InformationCardForm;
use App\Filament\Resources\InformationCards\Tables\InformationCardsTable;
use App\Models\InformationCard;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class InformationCardResource extends Resource
{
    protected static ?string $model = InformationCard::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Informasi Card';

    protected static ?string $modelLabel = 'Informasi Card';

    protected static ?string $pluralModelLabel = 'Informasi Card';

    protected static string | UnitEnum | null $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return InformationCardForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InformationCardsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInformationCards::route('/'),
            'create' => CreateInformationCard::route('/create'),
            'edit' => EditInformationCard::route('/{record}/edit'),
        ];
    }
}
