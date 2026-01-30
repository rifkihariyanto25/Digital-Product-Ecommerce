<?php

namespace App\Filament\Resources\TermsConditions\Pages;

use App\Filament\Resources\TermsConditions\TermsConditionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTermsConditions extends ListRecords
{
    protected static string $resource = TermsConditionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
