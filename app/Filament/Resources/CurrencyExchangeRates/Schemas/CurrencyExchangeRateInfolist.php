<?php

namespace App\Filament\Resources\CurrencyExchangeRates\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CurrencyExchangeRateInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('first_currency_id')
                    ->numeric(),
                TextEntry::make('second_currency_id')
                    ->numeric(),
                TextEntry::make('exchanges_to_second_currency_value')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
