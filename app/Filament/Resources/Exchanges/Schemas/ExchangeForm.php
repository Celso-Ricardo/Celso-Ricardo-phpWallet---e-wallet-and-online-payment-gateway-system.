<?php

namespace App\Filament\Resources\Exchanges\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExchangeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('first_currency_id')
                    ->required()
                    ->numeric(),
                TextInput::make('second_currency_id')
                    ->required()
                    ->numeric(),
                TextInput::make('gross')
                    ->numeric()
                    ->default(null),
                TextInput::make('fee')
                    ->numeric()
                    ->default(null),
                TextInput::make('net')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
