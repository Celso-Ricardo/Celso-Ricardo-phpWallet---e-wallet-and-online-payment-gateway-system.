<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\SendResource\Pages;
use App\Filament\Dashboard\Resources\SendResource\RelationManagers;
use App\Models\Send;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Currency;

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

class SendResource extends Resource
{
    protected static ?string $model = Send::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Select::make('currency_id')
                        ->required()
                        ->label('Currency')
                        ->options(Currency::all()
                        ->pluck('name', 'id'))
                        ->searchable(),

                    TextInput::make('receiver_email')
                        ->rules('required|exists:users,email')
                        ->label('User email')
                        ->email()
                        ->required(),
                    
                    TextInput::make('amount')
                        ->label('Amount to send')
                        ->rules('required|numeric|min:0.00009')
                ])->columns(3),
                Section::make()->schema([
                    TextInput::make('description')
                    ->required()
                    ->columnSpanFull()
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->user()->id)->orderby('created_at', 'desc'))
            ->columns([
                TextColumn::make('currency.name'),
                TextColumn::make('to.name'),
                TextColumn::make('transactionstate.name'),
                TextColumn::make('gross'),
                TextColumn::make('fee'),
                TextColumn::make('net'),
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
            'index' => Pages\ListSends::route('/'),
            'create' => Pages\CreateSend::route('/create'),
            //'edit' => Pages\EditSend::route('/{record}/edit'),
        ];
    }
}
