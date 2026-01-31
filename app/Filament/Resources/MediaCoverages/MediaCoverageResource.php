<?php

namespace App\Filament\Resources\MediaCoverages;

use App\Filament\Resources\MediaCoverages\Pages\CreateMediaCoverage;
use App\Filament\Resources\MediaCoverages\Pages\EditMediaCoverage;
use App\Filament\Resources\MediaCoverages\Pages\ListMediaCoverages;
use App\Filament\Resources\MediaCoverages\Schemas\MediaCoverageForm;
use App\Filament\Resources\MediaCoverages\Tables\MediaCoveragesTable;
use App\Models\MediaCoverage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MediaCoverageResource extends Resource
{
    protected static ?string $model = MediaCoverage::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'Logo Liputan';

    protected static ?string $modelLabel = 'Logo Liputan';

    protected static ?string $pluralModelLabel = 'Logo Liputan';

    protected static string | UnitEnum | null $navigationGroup = 'Homepage';

    protected static ?int $navigationSort = 4;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return MediaCoverageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MediaCoveragesTable::configure($table);
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
            'index' => ListMediaCoverages::route('/'),
            'create' => CreateMediaCoverage::route('/create'),
            'edit' => EditMediaCoverage::route('/{record}/edit'),
        ];
    }
}
