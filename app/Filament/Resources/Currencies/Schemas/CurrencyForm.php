<?php

namespace App\Filament\Resources\Currencies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CurrencyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->default(null),
                TextInput::make('symbol')
                    ->default(null),
                TextInput::make('code')
                    ->default(null),
                Toggle::make('is_cripto')
                    ->required(),
                Toggle::make('is_crypto')
                    ->required(),
                Textarea::make('thumb')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
