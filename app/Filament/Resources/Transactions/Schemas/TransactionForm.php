<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('request_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('transactionable_id')
                    ->required()
                    ->numeric(),
                TextInput::make('transactionable_type')
                    ->required(),
                TextInput::make('entity_id')
                    ->required()
                    ->numeric(),
                TextInput::make('entity_name')
                    ->required(),
                TextInput::make('transaction_state_id')
                    ->required()
                    ->numeric(),
                TextInput::make('currency')
                    ->required()
                    ->default('USD'),
                TextInput::make('activity_title')
                    ->required(),
                TextInput::make('money_flow')
                    ->required(),
                TextInput::make('gross')
                    ->required()
                    ->numeric(),
                TextInput::make('fee')
                    ->required()
                    ->numeric(),
                TextInput::make('net')
                    ->required()
                    ->numeric(),
                TextInput::make('balance')
                    ->numeric()
                    ->default(null),
                Textarea::make('json_data')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('currency_symbol')
                    ->default(null),
                TextInput::make('thumb')
                    ->required()
                    ->default('users/default.png'),
                TextInput::make('currency_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
