<?php

namespace App\Filament\Dashboard\Resources\WalletResource\Pages;

use App\Filament\Dashboard\Resources\WalletResource;
use Filament\Actions;
use App\Models\TransferMethod;
use App\Models\Wallet;
use App\Models\Currency;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class CreateWallet extends CreateRecord
{
    protected static string $resource = WalletResource::class;

    protected function beforeCreate(): void
    {
        //check if wallet exists

        $currency = Currency::where('id', $this->data['currency_id'])->first();
        
        if($this->data['wallet_identifier'] == null){
            Notification::make()
                ->warning()
                ->title("$currency->name")
                ->body('Please, Contact Admin to setup a Transfer  Method for '. $currency->name)
                ->persistent()
                ->send();

            $this->halt();
        }

        $transferMethod = TransferMethod::where('currency_id', $this->data['currency_id'])->where('is_system', 0)->first();
        $wallet = Wallet::where('user_id',auth()->user()->id)->where('currency_id', $this->data['currency_id'])->first();
       
        if($wallet != null){
            Notification::make()
                ->warning()
                ->title("$transferMethod->name")
                ->body('Your wallet is already running !')
                ->actions([
                Action::make('Add Funds')
                    ->button()
                    ->url('/dashboard/deposits/create', shouldOpenInNewTab: false),
                ])
                ->persistent()
                ->send();
            $this->halt();
        } 

        $this->data['user_id'] = auth()->user()->id;
        $this->data['is_crypto'] = $currency->is_crypto;
        $this->data['transfer_method_id'] = $transferMethod->id;
        $this->data['account_identifier_mechanism_value'] = $transferMethod->name;
        
        Wallet::Create($this->data);

        Notification::make()
            ->success()
            ->title("$transferMethod->name")
            ->body('Your wallet is created, add some funds !')
            ->actions([
                Action::make('Add Funds')
                    ->button()
                    ->url('/dashboard/deposits/create', shouldOpenInNewTab: false),
            ])
            ->persistent()
            ->send();
        $this->halt();
        
    }
}
