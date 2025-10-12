<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\WithdrawalResource\Pages;
use App\Filament\Dashboard\Resources\WithdrawalResource\RelationManagers;
use App\Models\Withdrawal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


use Filament\Forms\Get;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\CheckBox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Group;
//  Table Components
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;


use App\Models\Wallet;

class WithdrawalResource extends Resource
{
    protected static ?string $model = Withdrawal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Group::make()->schema([
                        Select::make('wallet_id')
                            ->required()
                            ->label('Transfer Method')
                            ->options(Wallet::where('user_id', auth()->user()->id)->get()
                            ->pluck('account_identifier_mechanism_value', 'id'))
                            ->searchable(),
                        TextInput::make('gross')
                            ->label('amount')
                    ]),
                ])->columnSpan(2),
                
                // Section::make('Deposit Transactin Receipt')->schema([
                //     Placeholder::make('Image')
                //         ->content(function ($record): HtmlString {
                //             return new HtmlString("<img src= '" . Storage::url($record->transaction_receipt) . "')>");
                //     })
                // ])->columnSpan(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->user()->id)->orderby('created_at', 'desc'))
            ->columns([
                TextColumn::make('transferMethod.name'),
                TextColumn::make('wallet.wallet_identifier')->label('Wallet identifier'),
                TextColumn::make('currency.code'),
                TextColumn::make('gross'),
                TextColumn::make('fee'),
                TextColumn::make('net'),
                TextColumn::make('transactionState.name'),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                 ->visible(function(Withdrawal $record){
                    return $record->transaction_state_id == 1 ? false: true;
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWithdrawals::route('/'),
            'create' => Pages\CreateWithdrawal::route('/create'),
            'edit' => Pages\EditWithdrawal::route('/{record}/edit'),
        ];
    }
}
