<?php

namespace App\Filament\Dashboard\Resources\DepositResource\Pages;

use App\Filament\Dashboard\Resources\DepositResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Services\DepositService;
use App\Morths\Transactionable\DepositActivity;
use Illuminate\Support\Facades\Auth; 
use App\Models\Wallet; 
use App\Models\TransferMethod; 
use App\Models\Currency;

use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;



class CreateDeposit extends CreateRecord
{
   

    protected static string $resource = DepositResource::class;
    
    protected function beforeCreate(): void
    {
        $wallet = Wallet::where('id', $this->data['wallet_id'])->first();

        $currency =  Currency::where('id', $wallet->currency_id)->first();

        $transferMethod = TransferMethod::where('id', $wallet->transfer_method_id)->first();

        $depositService = new DepositService();
        $depositActivity = new DepositActivity();

        $this->data['wallet'] = $wallet;
        $this->data['currency'] = $currency;
        $this->data['transferMethod'] = $transferMethod;
        $this->data['auth'] =  Auth::user();
        $deposit = $depositService->requestDeposit($this->data);

        if(is_array($deposit))
        {
            Notification::make()
            ->danger()
            ->color('danger')
            ->title($deposit['errorTitle'])
            ->body($deposit['errorMessage'])
            ->send();
            
            redirect($this->getResource()::getUrl('index'));

            $this->halt();
        }

        $this->data['deposit'] = $deposit;
        $depositActivity->appendNewActivity($this->data);

        
        Notification::make()
            ->success()
            ->title("Deposit Request success !")
            ->body('Pending Review !')
            ->send();
        
        redirect($this->getResource()::getUrl('index'));
        
        $this->halt();
        

    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
