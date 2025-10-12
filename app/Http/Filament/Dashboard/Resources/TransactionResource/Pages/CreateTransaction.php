<?php

namespace App\Filament\Dashboard\Resources\TransactionResource\Pages;

use App\Filament\Dashboard\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;
}
