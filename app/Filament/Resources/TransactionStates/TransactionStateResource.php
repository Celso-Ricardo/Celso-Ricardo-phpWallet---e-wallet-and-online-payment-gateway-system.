<?php

namespace App\Filament\Resources\TransactionStates;

use App\Filament\Resources\TransactionStates\Pages\CreateTransactionState;
use App\Filament\Resources\TransactionStates\Pages\EditTransactionState;
use App\Filament\Resources\TransactionStates\Pages\ListTransactionStates;
use App\Filament\Resources\TransactionStates\Pages\ViewTransactionState;
use App\Filament\Resources\TransactionStates\Schemas\TransactionStateForm;
use App\Filament\Resources\TransactionStates\Schemas\TransactionStateInfolist;
use App\Filament\Resources\TransactionStates\Tables\TransactionStatesTable;
use App\Models\TransactionState;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TransactionStateResource extends Resource
{
    protected static ?string $model = TransactionState::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TransactionStateForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TransactionStateInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransactionStatesTable::configure($table);
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
            'index' => ListTransactionStates::route('/'),
            'create' => CreateTransactionState::route('/create'),
            'view' => ViewTransactionState::route('/{record}'),
            'edit' => EditTransactionState::route('/{record}/edit'),
        ];
    }
}
