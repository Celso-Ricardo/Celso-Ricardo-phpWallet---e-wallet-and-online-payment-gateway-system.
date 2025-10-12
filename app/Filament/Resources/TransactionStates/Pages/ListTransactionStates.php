<?php

namespace App\Filament\Resources\TransactionStates\Pages;

use App\Filament\Resources\TransactionStates\TransactionStateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTransactionStates extends ListRecords
{
    protected static string $resource = TransactionStateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
