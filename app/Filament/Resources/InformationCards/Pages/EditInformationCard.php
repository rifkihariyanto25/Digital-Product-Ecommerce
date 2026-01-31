<?php

namespace App\Filament\Resources\InformationCards\Pages;

use App\Filament\Resources\InformationCards\InformationCardResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInformationCard extends EditRecord
{
    protected static string $resource = InformationCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
