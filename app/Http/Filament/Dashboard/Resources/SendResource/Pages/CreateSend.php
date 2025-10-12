<?php

namespace App\Filament\Dashboard\Resources\SendResource\Pages;

use App\Filament\Dashboard\Resources\SendResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use App\Models\Currency;
use App\Models\Wallet;
use App\Services\SendService;
use App\Morths\Transactionable\ReceiveActivity;
use App\Morths\Transactionable\SendActivity;
use Filament\Notifications\Notification;

class CreateSend extends CreateRecord
{
    protected static string $resource = SendResource::class;

    protected function beforeCreate(): void 
    {
      
        $me = auth()->user();
        $receiver = User::where('email', $this->data['receiver_email'])->first();
        $currency = Currency::where('id', $this->data['currency_id'])->first();
        $myWallet = Wallet::where('user_id', $me->id)->where('currency_id', $this->data['currency_id'])->first();
        $receiverWallet = Wallet::where('user_id', $receiver->id)->where('currency_id', $this->data['currency_id'])->first();

        $this->data['me'] = $me;
        $this->data['receiver'] = $receiver;
        $this->data['currency'] = $currency;
        $this->data['myWallet'] = $myWallet;
        $this->data['receiverWallet'] = $receiverWallet;

        $sendService = new SendService();

        $response = $sendService->sendMoney($this->data);

         
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

        
        $this->data['receive'] = $response['receive'];
        $this->data['send'] = $response['send'];
        $this->data['precision'] = $response['precision'];

        \App\Morths\Transactionable\ReceiveActivity::newActivity($this->data);
        SendActivity::newActivity($this->data);

        Notification::make()
            ->success()
            ->title("Amount transfered successfully !")
            ->body('')
            ->send();
        
        redirect($this->getResource()::getUrl('index'));
        
        $this->halt();
    
    }
}
