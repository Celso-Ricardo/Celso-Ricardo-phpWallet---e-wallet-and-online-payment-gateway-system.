<?php

namespace App\Filament\Resources\Deposits\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DepositInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('transaction_state_id')
                    ->numeric(),
                TextEntry::make('deposit_method_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('gross')
                    ->numeric(),
                TextEntry::make('fee')
                    ->numeric(),
                TextEntry::make('net')
                    ->numeric(),
                TextEntry::make('transaction_receipt')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('json_data')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('currency_id')
                    ->numeric(),
                TextEntry::make('currency_symbol')
                    ->placeholder('-'),
                TextEntry::make('wallet_id')
                    ->numeric(),
                TextEntry::make('message')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('transfer_method_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('unique_transaction_id')
                    ->placeholder('-'),
                TextEntry::make('date_eposh'),
            ]);
    }
}
