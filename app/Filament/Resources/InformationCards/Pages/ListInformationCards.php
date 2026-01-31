<?php

namespace App\Filament\Resources\InformationCards\Pages;

use App\Filament\Resources\InformationCards\InformationCardResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInformationCards extends ListRecords
{
    protected static string $resource = InformationCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
