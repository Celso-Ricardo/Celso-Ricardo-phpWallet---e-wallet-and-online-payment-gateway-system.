<?php

namespace App\Services;
use App\Models\Sale;
use App\Models\Purchase;

class PurchaseRequestService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function processPurchase( Array $args)
    {
        
        $purchaseRequest = $args['purchaseRequest'];

        if($purchaseRequest->is_expired == 1)
        {
            return[
                'error'=> true,
                'data'  =>  null,
                'errorTitle'    =>'Unauthorized !',
                'errorMessage'   => 'Purchase request already expired!',
        	];
        }
        
        $merchant = $args['merchant'];

        if($merchant == null)
        {
        	return[
                'error'=> true,
                'data'  =>  null,
                'errorTitle'    =>'Unauthorized !',
                'errorMessage'   => 'Merchant Notfound.',
        	];
        }

        $user = $args['user'];

        if($user->id  == $merchant->User->id )
        {
            return[
                'error'=> true,
                'data'  =>  null,
                'errorTitle'    =>'Unauthorized !',
                'errorMessage'   => 'You are logging into the account of the seller for this purchase. Please change your login information and try again.',
        	];
        }
 
        if ( $purchaseRequest->Currency->is_crypto == 1 ){
            $precision = 8 ;
        } else {
            $precision = 2;
        }

        $auth_wallet = $args['auth_wallet'];

        $user_wallet = $args['user_wallet'];

        if(is_null($auth_wallet)){
            return[
                'error'=> true,
                'data'  =>  null,
                'errorTitle'    =>'Unauthorized !',
                'errorMessage'   =>  __('Your account doesn\'t have a') .' ' . $purchaseRequest->currency->name . ' '.__('wallet') . ' ' . __('add a') . $purchaseRequest->currency->name . ' '.__('wallet to your account first') . '',
            ];
        }

             
        if ($user->account_status == 0 ) {
            return[
                'error'=> true,
                'data'  =>  null,
                'errorTitle'    =>'Unauthorized !',
                'errorMessage'   =>  __('Your account is under a withdrawal request review proccess. please wait for a few minutes and try again'),
            ];
        }

       
        if(  $auth_wallet->amount < $purchaseRequest->data->total ){
            return[
                'error'=> true,
                'data'  =>  null,
                'errorTitle'    =>'Unauthorized !',
                'errorMessage'   =>  __('You have insufficient funds in your ') .$purchaseRequest->currency->name. __(' wallet to proceed with this purchase.'),
            ];
        }

        $purchase_fee = 0; //free buy with your phpWallet credit
        
        //$sale_fee = bcadd( bcmul(''.( setting('merchant.merchant_percentage_fee')/100), ''.session()->get('PurchaseRequestTotal'), $precision) , setting('merchant.merchant_fixed_fee'), $precision ) ; 
        
        //Overriding the above calc
        $sale_fee = 0 ;

        if( $purchaseRequest->currency->is_crypto == 1 ){
            //$sale_fee = bcmul(''.( setting('merchant.merchant_percentage_fee')/100), ''.session()->get('PurchaseRequestTotal'), $precision) ; 
            $sale_fee = 0 ;
        }

        $minimum = bcadd($purchaseRequest->data->total, $sale_fee, $precision);

        if (bcsub($purchaseRequest->data->total, $sale_fee, $precision ) <= 0 ) {
            return[
                'error'=> true,
                'data'  =>  null,
                'errorTitle'    =>'Unauthorized !',
                'errorMessage'   =>  __('We only support invoices with a total greater than ').$minimum.$purchaseRequest->currency->symbol,
            ];
        }
       
        $sale = Sale::create([
          'user_id' =>  $merchant->User->id,
          'merchant_id' =>  $merchant->id, 
          'purchase_id' =>  null,
          'transaction_state_id'  =>  1,
          'gross' =>  (float)$purchaseRequest->data->total,
          'fee' =>  $sale_fee, 
          'net' =>  bcsub( $purchaseRequest->data->total , $sale_fee, $precision ),
          'currency_id' =>  $purchaseRequest->currency->id,
          'currency_symbol' =>  $purchaseRequest->currency->symbol,
          'json_data' =>  json_encode($purchaseRequest->data),
        ]);

        $purchase = Purchase::create([
          'user_id' => $user->id,
          'merchant_id' =>  $merchant->id, 
          'sale_id' =>  $sale->id,
          'transaction_state_id'  =>  1,
          'currency_id' =>  $purchaseRequest->currency->id,
          'currency_symbol' =>  $purchaseRequest->currency->symbol,
          'gross' =>  (float)$purchaseRequest->data->total,
          'fee' =>  $purchase_fee,
          'net' =>  bcsub( $purchaseRequest->data->total , $purchase_fee, $precision ),
          'json_data' =>  json_encode($purchaseRequest->data),
        ]);

        $sale->purchase_id = $purchase->id;
        $sale->save();

        $auth_wallet->amount = bcsub($auth_wallet->amount ,$purchase->net, $precision );
        $auth_wallet->save();

        $user_wallet->amount = bcadd($user_wallet->amount , $sale->net, $precision );
        $user_wallet->save();

        $purchaseRequest->is_expired = 1;
        $purchaseRequest->payment_status = 'completed';
        $purchaseRequest->save();

        //dd('Send IPN Notification is missing');

        //send IPN notification
        try {
            $response = Http::post($merchant->ipn_url, [ 'data' => $purchaseRequest, 'body' => 'This is test from somewhere as body', ]); 
        } catch (\Throwable $th) {
            //throw $th;
        }

       
        return [
            'sale' =>  $sale,
            'purchase'  =>  $purchase,
            'merchant'  =>  $merchant,
            'purchaseRequest'   =>  $purchaseRequest,
            'user'  =>  $user,
            'auth_wallet' => $auth_wallet,
            'user_wallet'   => $user_wallet,
        ];
    }
}
