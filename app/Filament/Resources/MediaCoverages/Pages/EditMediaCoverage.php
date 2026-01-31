<?php

namespace App\Filament\Resources\MediaCoverages\Pages;

use App\Filament\Resources\MediaCoverages\MediaCoverageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMediaCoverage extends EditRecord
{
    protected static string $resource = MediaCoverageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
