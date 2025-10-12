<?php

namespace App\Filament\Resources\Withdrawals\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class WithdrawalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('transaction_state_id')
                    ->required()
                    ->numeric(),
                TextInput::make('gross')
                    ->required()
                    ->numeric(),
                TextInput::make('fee')
                    ->required()
                    ->numeric(),
                TextInput::make('net')
                    ->required()
                    ->numeric(),
                Textarea::make('platform_id')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('json_data')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('currency_symbol')
                    ->default(null),
                TextInput::make('wallet_id')
                    ->required()
                    ->numeric(),
                TextInput::make('send_to_platform_name')
                    ->default(null),
                TextInput::make('currency_id')
                    ->required()
                    ->numeric(),
                TextInput::make('transfer_method_id')
                    ->numeric()
                    ->default(null),
                Textarea::make('unique_transaction_id')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
