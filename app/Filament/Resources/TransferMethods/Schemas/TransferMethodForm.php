<?php

namespace App\Filament\Resources\TransferMethods\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TransferMethodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('currency_id')
                    ->required()
                    ->numeric(),
                Textarea::make('name')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('account_identifier_mechanism')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('how_to_deposit')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('how_to_withdraw')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('days_to_process_transfer')
                    ->required()
                    ->numeric()
                    ->default(1),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('deposit_percentage_fee')
                    ->numeric()
                    ->default(0.0),
                TextInput::make('deposit_fixed_fee')
                    ->numeric()
                    ->default(0.0),
                TextInput::make('withdraw_percentage_fee')
                    ->numeric()
                    ->default(0.0),
                TextInput::make('withdraw_fixed_fee')
                    ->numeric()
                    ->default(0.0),
                Textarea::make('thumbnail')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('merchant_fixed_fee')
                    ->numeric()
                    ->default(0.0),
                TextInput::make('merchant_percentage_fee')
                    ->numeric()
                    ->default(0.0),
                Textarea::make('mobile_thumbnail')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('is_hidden'),
                Toggle::make('is_system'),
            ]);
    }
}
