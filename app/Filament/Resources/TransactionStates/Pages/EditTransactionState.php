<?php

namespace App\Filament\Resources\TransactionStates\Pages;

use App\Filament\Resources\TransactionStates\TransactionStateResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTransactionState extends EditRecord
{
    protected static string $resource = TransactionStateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
