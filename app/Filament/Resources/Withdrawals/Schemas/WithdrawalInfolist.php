<?php

namespace App\Filament\Resources\Withdrawals\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class WithdrawalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('transaction_state_id')
                    ->numeric(),
                TextEntry::make('gross')
                    ->numeric(),
                TextEntry::make('fee')
                    ->numeric(),
                TextEntry::make('net')
                    ->numeric(),
                TextEntry::make('platform_id')
                    ->columnSpanFull(),
                TextEntry::make('json_data')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('currency_symbol')
                    ->placeholder('-'),
                TextEntry::make('wallet_id')
                    ->numeric(),
                TextEntry::make('send_to_platform_name')
                    ->placeholder('-'),
                TextEntry::make('currency_id')
                    ->numeric(),
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
                    ->placeholder('-')
                    ->columnSpanFull(),
            ]);
    }
}
