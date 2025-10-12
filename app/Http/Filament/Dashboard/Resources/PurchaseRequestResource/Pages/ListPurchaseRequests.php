<?php

namespace App\Filament\Dashboard\Resources\PurchaseRequestResource\Pages;

use App\Filament\Dashboard\Resources\PurchaseRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseRequests extends ListRecords
{
    protected static string $resource = PurchaseRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
           // Actions\CreateAction::make()
           // ->color('success')
           // ->icon('heroicon-o-rectangle-stack')
           // ->label('New'),
        ];
    }
}
