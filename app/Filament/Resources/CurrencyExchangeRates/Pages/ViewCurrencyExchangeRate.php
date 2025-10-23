<?php

namespace App\Filament\Resources\CurrencyExchangeRates\Pages;

use App\Filament\Resources\CurrencyExchangeRates\CurrencyExchangeRateResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCurrencyExchangeRate extends ViewRecord
{
    protected static string $resource = CurrencyExchangeRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
