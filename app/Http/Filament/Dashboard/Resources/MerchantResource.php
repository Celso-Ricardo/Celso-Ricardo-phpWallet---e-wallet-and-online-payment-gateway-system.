<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\MerchantResource\Pages;
use App\Filament\Dashboard\Resources\MerchantResource\RelationManagers;
use App\Models\Merchant;
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

class MerchantResource extends Resource
{
    protected static ?string $model = Merchant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->rules('required|unique:merchants,name'),
                Select::make('currency_id')
                    ->required()
                    ->label('Currency')
                    ->options(Currency::all()
                    ->pluck('name', 'id'))
                    ->searchable(),
                TextInput::make('site_url')
                    ->helperText('https:// xxxx.com/xxxx/xxxx')
                    ->rules('required|unique:merchants,site_url')
                    ->url(),
                TextInput::make('ipn_url')
                    ->helperText('https:// xxxx.com/xxxx/xxxx')
                    ->rules('required|unique:merchants,ipn_url')
                    ->url(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->user()->id)->orderby('created_at', 'desc'))
            ->columns([
                TextColumn::make('created_at'),
                TextColumn::make('name'),
                TextColumn::make('site_url'),
                TextColumn::make('ipn_url'),
                TextColumn::make('merchant_key'),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListMerchants::route('/'),
            'create' => Pages\CreateMerchant::route('/create'),
            //'edit' => Pages\EditMerchant::route('/{record}/edit'),
        ];
    }
}
