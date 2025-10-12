<?php

namespace App\Filament\Dashboard\Resources\ExchangeResource\Pages;

use App\Filament\Dashboard\Resources\ExchangeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\CurrencyExchangeRate;
use App\Services\ExchangeService;
use App\Morths\Transactionable\ExchangeAddToWalletActivity;
use App\Morths\Transactionable\ExchangeSubtractFromWalletActivity;
use Filament\Notifications\Notification;

class CreateExchange extends CreateRecord
{
    protected static string $resource = ExchangeResource::class;

    protected function beforeCreate():void
    {
        $currencyExchangeRate = CurrencyExchangeRate::with(['firstCurrency','secondCurrency'])->where('first_currency_id', $this->data['first_currency_id'])->where('second_currency_id', $this->data['second_currency_id'])->first();
        $this->data['rate'] = $currencyExchangeRate;
        $this->data['user'] = auth()->user();
        $exchangeService = new ExchangeService();
        $response = $exchangeService->exchange($this->data);
       
        if(array_key_exists('error', $response))
        {
            Notification::make()
            ->danger()
            ->color('danger')
            ->title($response['errorTitle'])
            ->body($response['errorMessage'])
            ->send();
            
            redirect($this->getResource()::getUrl('index'));

            $this->halt();
        }

        $this->data['exchange'] = $response['exchange'];
        $this->data['main_wallet'] = $response['main_wallet'];
        $this->data['second_wallet'] = $response['second_wallet'];
        $this->data['exchange_result'] = $response['exchange_result'];

        ExchangeAddToWalletActivity::newActivity($this->data);
        ExchangeSubtractFromWalletActivity::newActivity($this->data);

        Notification::make()
            ->success()
            ->title("Currencies exchanged successfully !")
            ->body('')
            ->send();
        
        redirect($this->getResource()::getUrl('index'));
        
        $this->halt();

    }
}
