<?php

namespace App\Filament\Resources\QnaSections\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class QnaSectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('question')
                    ->label('Question')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Bagaimana cara melakukan pembelian produk digital?'),
                
                Textarea::make('answer')
                    ->label('Answer')
                    ->required()
                    ->rows(5)
                    ->placeholder('Untuk melakukan pembelian, pilih produk yang diinginkan...'),
            ]);
    }
}
