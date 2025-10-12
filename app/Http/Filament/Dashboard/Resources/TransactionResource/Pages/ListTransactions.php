<?php

namespace App\Filament\Dashboard\Resources\TransactionResource\Pages;

use App\Filament\Dashboard\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
           // Actions\CreateAction::make(),
        ];
    }

    public function getTabs():array
    {
        return [
            'all' => Tab::make('All'),
            'deposit' => Tab::make('Deposit')
            ->modifyQueryUsing(function($query){
                return $query->where('transactionable_type', 'App\Models\Deposit');
            }),
            'withdraw' => Tab::make('Withdraw')
            ->modifyQueryUsing(function($query){
                return $query->where('transactionable_type', 'App\Models\Withdrawal');
            }),
            'exchange' => Tab::make('Exchange')
            ->modifyQueryUsing(function($query){
                return $query->where('transactionable_type', 'App\Models\Exchange');
            }),
            'received' => Tab::make('Received')
            ->modifyQueryUsing(function($query){
                return $query->where('transactionable_type', 'App\Models\Receive');
            }),
            'sent' => Tab::make('Sent')
            ->modifyQueryUsing(function($query){
                return $query->where('transactionable_type', 'App\Models\Send');
            }),
        ];
    }
}
