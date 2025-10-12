<?php

namespace App\Filament\Resources\Deposits\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DepositForm
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
                TextInput::make('deposit_method_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('gross')
                    ->required()
                    ->numeric(),
                TextInput::make('fee')
                    ->required()
                    ->numeric(),
                TextInput::make('net')
                    ->required()
                    ->numeric(),
                Textarea::make('transaction_receipt')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('json_data')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('currency_id')
                    ->required()
                    ->numeric(),
                TextInput::make('currency_symbol')
                    ->default(null),
                TextInput::make('wallet_id')
                    ->required()
                    ->numeric(),
                Textarea::make('message')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('transfer_method_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('unique_transaction_id')
                    ->default(null),
                TextInput::make('date_eposh')
                    ->required()
                    ->default('CURRENT_TIMESTAMP'),
            ]);
    }
}
