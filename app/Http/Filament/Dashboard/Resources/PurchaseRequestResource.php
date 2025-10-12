<?php

namespace App\Filament\Dashboard\Resources;

use App\Filament\Dashboard\Resources\PurchaseRequestResource\Pages;
use App\Filament\Dashboard\Resources\PurchaseRequestResource\RelationManagers;
use App\Models\PurchaseRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Notifications\Notification;

use Filament\Tables\Columns\TextColumn;

class PurchaseRequestResource extends Resource
{
    protected static ?string $model = PurchaseRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadge(): ?string
    {
        $value = static::$model::where('is_expired', 0)->where('user_id', auth()->user()->id)->count();
        return $value > 0 ? $value : null ; //
    }

    public static function getNavigationBadgeColor(): ?string
    {
        //return static::getModel()::count() > 10 ? 'success' : 'primary';
        return 'success';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->user()->id)->orderby('created_at', 'desc'))
            ->columns([
                TextColumn::make('order_id'),
                //TextColumn::make('created_at'),
                TextColumn::make('total'),
                TextColumn::make('ref'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make()
                //  ->visible(function(PurchaseRequest $record){
                //     return $record->status == '0' ? false: true;
                // }),
                Tables\Actions\Action::make('Pay')
                ->visible(function(PurchaseRequest $record){
                    return $record->is_expired == 1 ? false: true;
                })
                ->icon('heroicon-o-rectangle-stack')
                ->color('success')
                ->requiresConfirmation()
                ->action(function(PurchaseRequest $record){
                    $result = $record->pay();
                     if(array_key_exists('error', $result))
                        {
                            Notification::make()
                            ->danger()
                            ->color('danger')
                            ->title($result['errorTitle'])
                            ->body($result['errorMessage'])
                            ->send();
                        // Todo
                        // halt();
                        }
                    
                })
                ->after(function(){
                    Notification::make()
                    //->duration(5000)
                    ->success()
                    ->title('This payment was approved')
                    ->body('The payment was proccessed sucessfully, please return to the shop page to check the order status !')
                    ->Send();
                })
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
            'index' => Pages\ListPurchaseRequests::route('/'),
            'create' => Pages\CreatePurchaseRequest::route('/create'),
            //'edit' => Pages\EditPurchaseRequest::route('/{record}/edit'),
        ];
    }
}
