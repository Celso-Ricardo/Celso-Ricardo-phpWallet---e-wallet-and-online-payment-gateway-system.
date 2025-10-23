<?php

namespace App\Filament\Resources\Exchanges\Pages;

use App\Filament\Resources\Exchanges\ExchangeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListExchanges extends ListRecords
{
    protected static string $resource = ExchangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
