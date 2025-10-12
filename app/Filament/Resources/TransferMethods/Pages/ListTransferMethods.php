<?php

namespace App\Filament\Resources\TransferMethods\Pages;

use App\Filament\Resources\TransferMethods\TransferMethodResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTransferMethods extends ListRecords
{
    protected static string $resource = TransferMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
