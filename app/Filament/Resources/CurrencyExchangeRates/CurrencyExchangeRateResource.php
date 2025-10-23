<?php

namespace App\Filament\Resources\CurrencyExchangeRates;

use App\Filament\Resources\CurrencyExchangeRates\Pages\CreateCurrencyExchangeRate;
use App\Filament\Resources\CurrencyExchangeRates\Pages\EditCurrencyExchangeRate;
use App\Filament\Resources\CurrencyExchangeRates\Pages\ListCurrencyExchangeRates;
use App\Filament\Resources\CurrencyExchangeRates\Pages\ViewCurrencyExchangeRate;
use App\Filament\Resources\CurrencyExchangeRates\Schemas\CurrencyExchangeRateForm;
use App\Filament\Resources\CurrencyExchangeRates\Schemas\CurrencyExchangeRateInfolist;
use App\Filament\Resources\CurrencyExchangeRates\Tables\CurrencyExchangeRatesTable;
use App\Models\CurrencyExchangeRate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CurrencyExchangeRateResource extends Resource
{
    protected static ?string $model = CurrencyExchangeRate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Currency Exchange Rates';

    public static function form(Schema $schema): Schema
    {
        return CurrencyExchangeRateForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CurrencyExchangeRateInfolist::configure($schema);
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
            'create' => CreateCurrencyExchangeRate::route('/create'),
            'view' => ViewCurrencyExchangeRate::route('/{record}'),
            'edit' => EditCurrencyExchangeRate::route('/{record}/edit'),
        ];
    }
}
