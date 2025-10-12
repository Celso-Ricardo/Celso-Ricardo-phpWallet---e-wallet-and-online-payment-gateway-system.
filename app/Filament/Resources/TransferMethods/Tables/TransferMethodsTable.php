<?php

namespace App\Filament\Resources\TransferMethods\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransferMethodsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('currency_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('days_to_process_transfer')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deposit_percentage_fee')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('deposit_fixed_fee')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('withdraw_percentage_fee')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('withdraw_fixed_fee')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('merchant_fixed_fee')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('merchant_percentage_fee')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_hidden')
                    ->boolean(),
                IconColumn::make('is_system')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
