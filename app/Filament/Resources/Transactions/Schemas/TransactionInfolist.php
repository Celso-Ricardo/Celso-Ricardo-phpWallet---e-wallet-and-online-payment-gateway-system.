<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TransactionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('request_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('transactionable_id')
                    ->numeric(),
                TextEntry::make('transactionable_type'),
                TextEntry::make('entity_id')
                    ->numeric(),
                TextEntry::make('entity_name'),
                TextEntry::make('transaction_state_id')
                    ->numeric(),
                TextEntry::make('currency'),
                TextEntry::make('activity_title'),
                TextEntry::make('money_flow'),
                TextEntry::make('gross')
                    ->numeric(),
                TextEntry::make('fee')
                    ->numeric(),
                TextEntry::make('net')
                    ->numeric(),
                TextEntry::make('balance')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('json_data')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('currency_symbol')
                    ->placeholder('-'),
                TextEntry::make('thumb'),
                TextEntry::make('currency_id')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
