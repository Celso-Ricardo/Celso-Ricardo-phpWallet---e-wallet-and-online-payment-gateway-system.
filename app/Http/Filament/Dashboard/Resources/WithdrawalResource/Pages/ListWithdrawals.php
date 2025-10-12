<?php

namespace App\Filament\Dashboard\Resources\WithdrawalResource\Pages;

use App\Filament\Dashboard\Resources\WithdrawalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWithdrawals extends ListRecords
{
    protected static string $resource = WithdrawalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Request a withdrawal'),
        ];
    }
}
