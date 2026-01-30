<?php

namespace App\Filament\Resources\QnaSections\Pages;

use App\Filament\Resources\QnaSections\QnaSectionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListQnaSections extends ListRecords
{
    protected static string $resource = QnaSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
