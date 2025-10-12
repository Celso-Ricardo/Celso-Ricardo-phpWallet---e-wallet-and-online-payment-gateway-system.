<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\WalletResource\Pages;
use App\Filament\Dashboard\Resources\WalletResource\RelationManagers;
use App\Models\Wallet;
use App\Models\Currency;
use App\Models\TransferMethod;
use App\Filament\Dashboard\Resources\WalletResource\Widgets\WalletBalance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

use Filament\Forms\Get;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\CheckBox;
use Filament\Forms\Components\Select;
//  Table Components
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class WalletResource extends Resource
{
    protected static ?string $model = Wallet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('currency_id')
                    ->required()
                    ->label('Currency')
                    ->options(Currency::all()
                    ->pluck('name', 'id'))
                    ->searchable()
                    ->live(),
                TextInput::make('wallet_identifier')
                    ->hidden(
                        function (Get $get){ 
                            $label = TransferMethod::query()
                                ->where('currency_id', $get('currency_id'))
                                ->pluck('account_identifier_mechanism');
                    
                            if(count($label) == 0){
                                 return true;
                            }
                            return false;
                        }
                    )
                    ->label(
                        //static fn (Get $get): string => $get('currency_id') === 'something' ? 'label 1' : 'label 2'
                        function (Get $get){ 
                            $label = TransferMethod::query()
                        ->where('currency_id', $get('currency_id'))
                        ->pluck('account_identifier_mechanism');
                        
                            if(count($label) == 0){
                                return 'Wallet Identifier';
                            }
                            if(count($label) == 2){
                                return $label[1];
                            }
                        }
                    )
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->user()->id))
            ->columns([
                TextColumn::make('currency.code'),
                TextColumn::make('transferMethod.name'),
                TextColumn::make('wallet_identifier'),
                // IconColumn::make('is_crypto')
                //     ->boolean()
                //     ->trueColor('info')
                //     ->falseColor('warning'),
                TextColumn::make('amount'),//->normalizeZeros(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getWidgets(): array
    {
        return [
            WalletBalance::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWallets::route('/'),
            'create' => Pages\CreateWallet::route('/create'),
            //'edit' => Pages\EditWallet::route('/{record}/edit'),
        ];
    }
}
