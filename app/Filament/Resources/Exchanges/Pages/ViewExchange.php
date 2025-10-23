<?php

namespace App\Filament\Resources\Exchanges\Pages;

use App\Filament\Resources\Exchanges\ExchangeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewExchange extends ViewRecord
{
    protected static string $resource = ExchangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
