<?php

namespace App\Filament\Resources\TermsConditions;

use App\Filament\Resources\TermsConditions\Pages\CreateTermsCondition;
use App\Filament\Resources\TermsConditions\Pages\EditTermsCondition;
use App\Filament\Resources\TermsConditions\Pages\ListTermsConditions;
use App\Filament\Resources\TermsConditions\Schemas\TermsConditionForm;
use App\Filament\Resources\TermsConditions\Tables\TermsConditionsTable;
use App\Models\TermsCondition;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TermsConditionResource extends Resource
{
    protected static ?string $model = TermsCondition::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected static string | UnitEnum | null $navigationGroup = 'Management Website';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return TermsConditionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TermsConditionsTable::configure($table);
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
            'index' => EditTermsCondition::route('/'),
        ];
    }
}
