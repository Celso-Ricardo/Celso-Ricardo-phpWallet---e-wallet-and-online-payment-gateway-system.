<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Wallet;

// Uses for pay method;
use Illuminate\Support\Facades\Auth; 
use App\Morths\Transactionable\SaleActivity;
use App\Morths\Transactionable\PurchaseActivity;
use App\Services\PurchaseRequestService;

class PurchaseRequest extends Model
{
    protected $table = 'requests';

    protected $fillable = ['merchant_key','payment_status','order_id','ref','data', 'is_expired', 'currency_code', 'currency_id', 'total', 'user_id']; // 'payeer_phone_number',

    public function getDataAttribute($value){
    	return json_decode($value);
    }

    public function getTotalAttribute($value){
    	return json_decode($value);
    }

    public function Transaction(){
        return $this->hasOne(Transaction::class, 'request_id');
    }

    public function Currency(){
        return $this->belongsTo(Currency::class);
    }

    public function Merchant()
    {
        return $this->hasOne(Merchant::class, 'merchant_key', 'merchant_key');
    }

    public function Pay(): array
    {
        $auth_wallet = Wallet::where('user_id', $this->user_id)->where('currency_id', $this->currency->id)->first();
        $user_wallet = Wallet::where('user_id', $this->merchant->user_id)->where('currency_id', $this->currency_id)->first();

        if(is_null($auth_wallet))
        {
            return[
                'error'=> true,
                'data'  =>  null,
                'errorTitle'    =>'Wallet not found !',
                'errorMessage'   => 'Please, setup your ' . $this->currency->name  . ', then add or exchange funds to your wallet and then process this payment.',
        	];
        }

        $args = [
            'purchaseRequest' => $this,
            'user'  => Auth::user(),
            'merchant'  => $this->merchant,
            'auth_wallet' => $auth_wallet,
            'user_wallet' => $user_wallet,
        ];


        
        $newArgs = PurchaseRequestService::processPurchase($args);


         
        if(array_key_exists('error', $newArgs))
        {
            return $newArgs;
        }

        SaleActivity::newActivity($newArgs);
        PurchaseActivity::newActivity($newArgs);

        return [];
    }

}