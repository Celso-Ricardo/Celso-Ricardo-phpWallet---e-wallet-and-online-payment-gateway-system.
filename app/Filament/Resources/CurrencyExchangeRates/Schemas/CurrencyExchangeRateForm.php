<?php

namespace App\Filament\Resources\CurrencyExchangeRates\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CurrencyExchangeRateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_currency_id')
                    ->required()
                    ->numeric(),
                TextInput::make('second_currency_id')
                    ->required()
                    ->numeric(),
                TextInput::make('exchanges_to_second_currency_value')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
