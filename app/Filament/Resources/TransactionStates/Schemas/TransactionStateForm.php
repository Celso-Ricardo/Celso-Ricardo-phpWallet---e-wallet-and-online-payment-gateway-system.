<?php

namespace App\Filament\Resources\TransactionStates\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TransactionStateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('json_data')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
