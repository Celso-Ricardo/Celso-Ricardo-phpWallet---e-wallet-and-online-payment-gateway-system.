<?php

namespace App\Filament\Dashboard\Resources\SendResource\Pages;

use App\Filament\Dashboard\Resources\SendResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSends extends ListRecords
{
    protected static string $resource = SendResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Send money'),
        ];
    }
}
