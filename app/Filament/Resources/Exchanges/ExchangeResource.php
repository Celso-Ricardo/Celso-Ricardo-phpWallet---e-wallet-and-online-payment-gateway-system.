<?php

namespace App\Filament\Resources\Exchanges;

use App\Filament\Resources\Exchanges\Pages\CreateExchange;
use App\Filament\Resources\Exchanges\Pages\EditExchange;
use App\Filament\Resources\Exchanges\Pages\ListExchanges;
use App\Filament\Resources\Exchanges\Pages\ViewExchange;
use App\Filament\Resources\Exchanges\Schemas\ExchangeForm;
use App\Filament\Resources\Exchanges\Schemas\ExchangeInfolist;
use App\Filament\Resources\Exchanges\Tables\ExchangesTable;
use App\Models\Exchange;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExchangeResource extends Resource
{
    protected static ?string $model = Exchange::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Exchange Rates';

    public static function form(Schema $schema): Schema
    {
        return ExchangeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExchangeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExchangesTable::configure($table);
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
            'index' => ListExchanges::route('/'),
            'create' => CreateExchange::route('/create'),
            'view' => ViewExchange::route('/{record}'),
            'edit' => EditExchange::route('/{record}/edit'),
        ];
    }
}
