<?php

namespace App\Filament\Resources\QnaSections;

use App\Filament\Resources\QnaSections\Pages\CreateQnaSection;
use App\Filament\Resources\QnaSections\Pages\EditQnaSection;
use App\Filament\Resources\QnaSections\Pages\ListQnaSections;
use App\Filament\Resources\QnaSections\Schemas\QnaSectionForm;
use App\Filament\Resources\QnaSections\Tables\QnaSectionsTable;
use App\Models\QnaSection;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class QnaSectionResource extends Resource
{
    protected static ?string $model = QnaSection::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static string | UnitEnum | null $navigationGroup = 'Management Website';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return QnaSectionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QnaSectionsTable::configure($table);
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
            'index' => ListQnaSections::route('/'),
        ];
    }
}
