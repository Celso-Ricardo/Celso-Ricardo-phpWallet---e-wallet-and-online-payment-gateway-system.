<?php

namespace App\Filament\Resources\CurrencyExchangeRates;

use App\Filament\Resources\CurrencyExchangeRates\Pages\CreateCurrencyExchangeRates;
use App\Filament\Resources\CurrencyExchangeRates\Pages\EditCurrencyExchangeRates;
use App\Filament\Resources\CurrencyExchangeRates\Pages\ListCurrencyExchangeRates;
use App\Filament\Resources\CurrencyExchangeRates\Pages\ViewCurrencyExchangeRates;
use App\Filament\Resources\CurrencyExchangeRates\Schemas\CurrencyExchangeRatesForm;
use App\Filament\Resources\CurrencyExchangeRates\Schemas\CurrencyExchangeRatesInfolist;
use App\Filament\Resources\CurrencyExchangeRates\Tables\CurrencyExchangeRatesTable;
use App\Models\CurrencyExchangeRate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CurrencyExchangeRatesResource extends Resource
{
    protected static ?string $model = CurrencyExchangeRate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'ExchangeRates';

    public static function form(Schema $schema): Schema
    {
        return CurrencyExchangeRatesForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CurrencyExchangeRatesInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CurrencyExchangeRatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCurrencyExchangeRates::route('/'),
            'create' => CreateCurrencyExchangeRates::route('/create'),
            'view' => ViewCurrencyExchangeRates::route('/{record}'),
            'edit' => EditCurrencyExchangeRates::route('/{record}/edit'),
        ];
    }
}
