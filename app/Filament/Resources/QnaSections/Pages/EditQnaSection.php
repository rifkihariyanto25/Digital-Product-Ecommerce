<?php

namespace App\Filament\Resources\QnaSections\Pages;

use App\Filament\Resources\QnaSections\QnaSectionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQnaSection extends EditRecord
{
    protected static string $resource = QnaSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
