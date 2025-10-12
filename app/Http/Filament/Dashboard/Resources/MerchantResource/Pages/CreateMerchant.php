<?php

namespace App\Filament\Dashboard\Resources\MerchantResource\Pages;

use App\Filament\Dashboard\Resources\MerchantResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Currency;
use App\Models\Merchant;
use App\Models\Wallet;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth; 

class CreateMerchant extends CreateRecord
{
    protected static string $resource = MerchantResource::class;

    protected function beforeCreate(): void 
    {
     
        $currency = Currency::where('id', $this->data['currency_id'])->first();
        
        if($currency->is_crypto == 1)
        {
	       
            Notification::make()
            ->danger()
            ->color('danger')
            ->title('Error')
            ->body('This feature is only supported for Fiat Currency.')
            ->send();
            
            // redirect($this->getResource()::getUrl('index'));

            $this->halt();
        }

        $auth_wallet = Wallet::where('currency_id', $this->data['currency_id'])->where('user_id', Auth::user()->id)->first();

        if(is_null($auth_wallet))
        {
	       
            Notification::make()
            ->danger()
            ->color('danger')
            ->title('Error')
            ->body('Please create your '. $currency->name . ' wallet first, and then llink your merchant store to it !')
            ->send();
            
            // redirect($this->getResource()::getUrl('index'));

            $this->halt();
        }

    	$merchant = new Merchant();
    	$merchant->user_id = Auth::user()->id;
    	$merchant->name = $this->data['name'];
        $merchant->currency_id = $this->data['currency_id'];
    	$merchant->site_url = $this->data['site_url'];
        $merchant->ipn_url =  $this->data['ipn_url'];
    	$merchant->success_link = 'add your success link here';
    	$merchant->fail_link = 'add your fail link here';
    	$merchant->merchant_key = Auth::user()->createToken(bcrypt(env('APP_KEY').now().Auth::user()->id))->plainTextToken ;
    	$merchant->save();

        Notification::make()
            ->danger()
            ->color('success')
            ->title('Saved')
            ->body('Merchant Created Successfully')
            ->send();
            
        redirect($this->getResource()::getUrl('index'));

        $this->halt();
    } 
}
