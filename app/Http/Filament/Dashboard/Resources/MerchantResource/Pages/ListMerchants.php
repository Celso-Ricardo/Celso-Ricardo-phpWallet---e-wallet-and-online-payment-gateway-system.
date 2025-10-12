<?php

namespace App\Filament\Dashboard\Resources\MerchantResource\Pages;

use App\Filament\Dashboard\Resources\MerchantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMerchants extends ListRecords
{
    protected static string $resource = MerchantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add a website'),
        ];
    }
}
