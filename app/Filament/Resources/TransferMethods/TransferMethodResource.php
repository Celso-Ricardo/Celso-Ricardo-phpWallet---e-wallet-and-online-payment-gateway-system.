<?php

namespace App\Filament\Resources\TransferMethods;

use App\Filament\Resources\TransferMethods\Pages\CreateTransferMethod;
use App\Filament\Resources\TransferMethods\Pages\EditTransferMethod;
use App\Filament\Resources\TransferMethods\Pages\ListTransferMethods;
use App\Filament\Resources\TransferMethods\Pages\ViewTransferMethod;
use App\Filament\Resources\TransferMethods\Schemas\TransferMethodForm;
use App\Filament\Resources\TransferMethods\Schemas\TransferMethodInfolist;
use App\Filament\Resources\TransferMethods\Tables\TransferMethodsTable;
use App\Models\TransferMethod;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TransferMethodResource extends Resource
{
    protected static ?string $model = TransferMethod::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'TransferMethods';

    public static function form(Schema $schema): Schema
    {
        return TransferMethodForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TransferMethodInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransferMethodsTable::configure($table);
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
            'index' => ListTransferMethods::route('/'),
            'create' => CreateTransferMethod::route('/create'),
            'view' => ViewTransferMethod::route('/{record}'),
            'edit' => EditTransferMethod::route('/{record}/edit'),
        ];
    }
}
