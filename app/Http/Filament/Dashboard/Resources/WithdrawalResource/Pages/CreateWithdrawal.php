<?php

namespace App\Filament\Dashboard\Resources\WithdrawalResource\Pages;

use App\Filament\Dashboard\Resources\WithdrawalResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use App\Services\WithdrawalService;
use App\Morths\Transactionable\WithdrawalActivity;
use Illuminate\Support\Facades\Auth; 
use App\Models\Wallet; 
use App\Models\TransferMethod; 
use App\Models\Currency;

use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;



class CreateWithdrawal extends CreateRecord
{
    protected static string $resource = WithdrawalResource::class;

    protected function beforeCreate(): void
    {
        $wallet = Wallet::where('id', $this->data['wallet_id'])->first();
        $currency =  Currency::where('id', $wallet->currency_id)->first();
        $transferMethod = TransferMethod::where('id', $wallet->transfer_method_id)->first();
        $withdrawalService = new WithdrawalService();
        $withdrawalActivity = new WithdrawalActivity();

        $this->data['wallet'] = $wallet;
        $this->data['currency'] = $currency;
        $this->data['transferMethod'] = $transferMethod;
        $this->data['auth'] =  Auth::user();

        $withdrawal = $withdrawalService->requestWithdrawal($this->data);
        
        if(is_array($withdrawal))
        {
            Notification::make()
            ->danger()
            ->color('danger')
            ->title($withdrawal['errorTitle'])
            ->body($withdrawal['errorMessage'])
            ->send();

            redirect($this->getResource()::getUrl('index'));

            $this->halt();
        }

        $this->data['withdrawal'] = $withdrawal;
        $withdrawalActivity->appendNewActivity($this->data);

        Notification::make()
            ->success()
            ->title("Withdraw Request Success !")
            ->body('Pending Review and processing !')
            ->send();

        redirect($this->getResource()::getUrl('index'));

        $this->halt();

    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
