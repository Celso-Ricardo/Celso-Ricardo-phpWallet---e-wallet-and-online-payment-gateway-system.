<?php

namespace App\Filament\Resources\CurrencyExchangeRates\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Placeholder;

class CurrencyExchangeRatesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('New rate')
                ->schema([ 
                    Select::make('first_currency_id')
                        ->required()
                        ->label('First Currency')
                        ->options(Currency::all()
                        ->pluck('name', 'id'))
                        ->searchable(),
                    Placeholder::make('Exchanges To'),
                    Select::make('second_currency_id')
                        ->required()
                        ->label('Second Currency')
                        ->options(Currency::all()
                        ->pluck('name', 'id'))
                        ->searchable(),
                    TextInput::make('exchanges_to_second_currency_value')
                        ->required()
                        ->helperText('use the format 10000.00 instead of 10.000.00 (only one coma/dot)')
                        ->label('At the rate'),
                   
                ]),
            ]);
    }
}
