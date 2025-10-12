<?php

namespace App\Filament\Dashboard\Resources\TransactionResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Transaction;
//  Table Components
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class TransactionsOverviewWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    
    public function table(Table $table): Table
    {
        return $table
        ->query(
            Transaction::query()
        )
        ->columns([
            TextColumn::make('currency'),
            TextColumn::make('transactionable_type')
                ->label('Type'),
            TextColumn::make('transactionstate.name')
            ->label('Status')
            ->badge()
            ->color(function($record){
                return $record->status->getColor();
            }),
            TextColumn::make('gross'),
            TextColumn::make('created_at'),
        ]);
    }
}
