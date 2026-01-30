<?php

namespace App\Filament\Resources\TermsConditions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;

class TermsConditionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
                
                RichEditor::make('content')
                    ->label('Konten')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'h2',
                        'h3',
                        'bulletList',
                        'orderedList',
                        'redo',
                        'undo',
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
