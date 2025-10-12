<?php

namespace App\Filament\Resources\TransferMethods\Pages;

use App\Filament\Resources\TransferMethods\TransferMethodResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTransferMethod extends ViewRecord
{
    protected static string $resource = TransferMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
