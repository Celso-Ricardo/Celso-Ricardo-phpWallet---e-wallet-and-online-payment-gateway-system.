<?php

namespace App\Filament\Dashboard\Resources\WalletResource\Pages;

use App\Filament\Dashboard\Resources\WalletResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Dashboard\Resources\WalletResource\Widgets\WalletBalance;

class ListWallets extends ListRecords
{
    protected static string $resource = WalletResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create a new wallet'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return[
            WalletBalance::class,
        ];
    }
}
