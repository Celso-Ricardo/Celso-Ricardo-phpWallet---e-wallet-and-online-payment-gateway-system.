<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\ExchangeResource\Pages;
use App\Filament\Dashboard\Resources\ExchangeResource\RelationManagers;
use App\Models\Exchange;
use App\Models\CurrencyExchangeRate;
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
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
//  Table Components
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class ExchangeResource extends Resource
{
    protected static ?string $model = Exchange::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // public static function getNavigationBadge(): ?string
    // {
    //     return (string) static::$model::count(); //where('status', 'new')->
    // }

    // public static function getNavigationBadgeColor(): ?string
    // {
    //     return static::getModel()::count() > 10 ? 'success' : 'primary';
    // }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')->schema([
                    Select::make('first_currency_id')
                        ->live()
                        ->required()
                        ->label('First Currency')
                        ->options(function(){
                            return CurrencyExchangeRate::with(['firstCurrency'])->get()
                            ->pluck('firstCurrency.name', 'firstCurrency.id');
                        })
                    ->searchable(),
                    TextInput::make('amount')
                        ->live()
                        ->label('Amount to exchange')
                        ->required(),
                    Select::make('second_currency_id')
                        ->live()
                        ->hidden(
                            function (Get $get): bool {
                               return $get('first_currency_id') == null ? true : false;
                            }
                        )
                        ->required()
                        ->label('Second Currency')
                        ->options(
                            function (Get $get) {
                                return CurrencyExchangeRate::with(['secondCurrency'])->where('first_currency_id', $get('first_currency_id'))->get()
                                    ->pluck('secondCurrency.name', 'secondCurrency.id');
                            }
                        )
                        ->searchable(),
                ])->columns(3),

                Section::make('')
                    ->hidden( 
                        function (Get $get): bool {
                            if( $get('first_currency_id') != null && $get('second_currency_id') != null && $get('amount') != null)
                               return false;
                            return true;
                        })
                    ->schema([
                        Placeholder::make('rate')
                            ->label('Exchange Rate')
                            ->content( function (Get $get) : string {
                                $rate = CurrencyExchangeRate::query()->with(['firstCurrency', 'secondCurrency'])->where('first_currency_id', $get('first_currency_id'))->where('second_currency_id', $get('second_currency_id'))->first();
                                return ' 1 '.  $rate->firstCurrency->code . ' exchanges to ' . $rate->exchanges_to_second_currency_value . ' '.  $rate->secondCurrency->code.' ';
                            })
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->user()->id)->orderby('created_at', 'desc'))
            ->columns([
                TextColumn::make('created_at'),
                TextColumn::make('gross')->label('Swapped'),
                TextColumn::make('firstCurrency.name')->label('From'),
                TextColumn::make('secondCurrency.name')->label('To'),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                   // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListExchanges::route('/'),
            'create' => Pages\CreateExchange::route('/create'),
            //'edit' => Pages\EditExchange::route('/{record}/edit'),
        ];
    }
}
