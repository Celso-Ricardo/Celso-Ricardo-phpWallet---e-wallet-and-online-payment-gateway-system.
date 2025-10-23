<?php

namespace App\Filament\Resources\Exchanges\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ExchangeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('first_currency_id')
                    ->numeric(),
                TextEntry::make('second_currency_id')
                    ->numeric(),
                TextEntry::make('gross')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('fee')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('net')
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
