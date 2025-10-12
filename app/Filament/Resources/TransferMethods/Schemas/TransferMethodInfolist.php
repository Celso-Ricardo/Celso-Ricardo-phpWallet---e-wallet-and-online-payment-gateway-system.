<?php

namespace App\Filament\Resources\TransferMethods\Schemas;

use App\Models\TransferMethod;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TransferMethodInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('currency_id')
                    ->numeric(),
                TextEntry::make('name')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('account_identifier_mechanism')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('how_to_deposit')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('how_to_withdraw')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('days_to_process_transfer')
                    ->numeric(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (TransferMethod $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deposit_percentage_fee')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('deposit_fixed_fee')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('withdraw_percentage_fee')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('withdraw_fixed_fee')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('thumbnail')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('merchant_fixed_fee')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('merchant_percentage_fee')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('mobile_thumbnail')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_hidden')
                    ->boolean()
                    ->placeholder('-'),
                IconEntry::make('is_system')
                    ->boolean()
                    ->placeholder('-'),
            ]);
    }
}
