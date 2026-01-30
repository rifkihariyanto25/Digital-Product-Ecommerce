<?php

namespace App\Filament\Resources\TermsConditions\Pages;

use App\Filament\Resources\TermsConditions\TermsConditionResource;
use App\Models\TermsCondition;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTermsCondition extends EditRecord
{
    protected static string $resource = TermsConditionResource::class;

    public function mount(int | string $record = 1): void
    {
        // Always use record ID 1, create if doesn't exist
        $record = TermsCondition::firstOrCreate(['id' => 1])->id;
        
        parent::mount($record);
    }

    protected function getHeaderActions(): array
    {
        return [
            // Remove delete action for single record
        ];
    }
}
