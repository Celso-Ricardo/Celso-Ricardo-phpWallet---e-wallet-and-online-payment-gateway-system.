<?php

namespace App\Filament\Resources\Currencies\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CurrencyInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->placeholder('-'),
                TextEntry::make('symbol')
                    ->placeholder('-'),
                TextEntry::make('code')
                    ->placeholder('-'),
                IconEntry::make('is_cripto')
                    ->boolean(),
                IconEntry::make('is_crypto')
                    ->boolean(),
                TextEntry::make('thumb')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
