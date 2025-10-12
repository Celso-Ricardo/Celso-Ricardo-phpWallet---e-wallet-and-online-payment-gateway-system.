<?php

namespace App\Filament\Resources\TransferMethods\Pages;

use App\Filament\Resources\TransferMethods\TransferMethodResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTransferMethod extends EditRecord
{
    protected static string $resource = TransferMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
