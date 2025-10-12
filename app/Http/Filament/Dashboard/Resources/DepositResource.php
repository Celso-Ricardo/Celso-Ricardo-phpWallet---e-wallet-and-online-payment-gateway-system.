<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\DepositResource\Pages;
use App\Filament\Dashboard\Resources\DepositResource\RelationManagers;
use App\Models\Deposit;
use App\Models\Wallet;
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
//  Table Components
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class DepositResource extends Resource
{
    protected static ?string $model = Deposit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Section::make()
                ->schema([
                    Group::make()->schema([
                        Select::make('wallet_id')
                            ->required()
                            ->label('Transfer Method')
                            ->options(Wallet::where('user_id', auth()->user()->id)->get()
                            ->pluck('account_identifier_mechanism_value', 'id'))
                            ->searchable(),
                        MarkdownEditor::make('message')
                            ->required()
                            ->label("Message to Reviewer"),
                    ]),
                ])
            ->columnSpan(1),
            Section::make()
                ->schema([
                    TextInput::make('unique_transaction_id')->required(),
                    FileUpload::make('transaction_receipt')->disk('public')->directory('deposits')->required(),
                ])
            ->columnSpan(1),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->user()->id)->orderby('created_at', 'desc'))
            ->columns([
                TextColumn::make('created_at'),
                TextColumn::make('net'),
                TextColumn::make('currency.code'),
                TextColumn::make('transferMethod.name'),
                TextColumn::make('transactionstate.name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                 ->visible(function(Deposit $record){
                    return $record->transaction_state_id == 1 ? false: true;
                }),
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
            'index' => Pages\ListDeposits::route('/'),
            'create' => Pages\CreateDeposit::route('/create'),
            'edit' => Pages\EditDeposit::route('/{record}/edit'),
        ];
    }
}
