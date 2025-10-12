<?php

namespace App\Filament\Resources\TransactionStates\Pages;

use App\Filament\Resources\TransactionStates\TransactionStateResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTransactionState extends ViewRecord
{
    protected static string $resource = TransactionStateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
