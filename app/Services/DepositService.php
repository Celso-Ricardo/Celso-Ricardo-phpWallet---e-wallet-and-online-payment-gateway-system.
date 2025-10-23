<?php

namespace App\Services;

use App\Models\Deposit; 
use App\Models\Transaction; 

class DepositService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
       
    }

    public static function requestDeposit(Array $args): Deposit
    {
   
        $img = '';
        foreach($args['transaction_receipt'] as $key => $value){
            $img = $value;
        }
  	
  		$deposit = Deposit::Create([
            'wallet_id' =>   $args['wallet']->id,
            'user_id'	=>	$args['auth']->id,
            'currency_id'   => $args['currency']->id, 
            'currency_symbol'   =>  $args['currency']->symbol,
    		'transaction_state_id'	=>	3,
    		'gross'	=>	0,
    		'fee'	=>	0,
    		'net'	=>	0,
            'message'   =>  $args['message'],
    		'transaction_receipt'	=>$img,
            'transfer_method_id' => $args['wallet']->transfer_method_id,
            'unique_transaction_id' => $args['unique_transaction_id'],
            'date_eposh'    => $this->randInt(9),
    		'json_data'	=>	'{"deposit_screenshot":"path"}'
    	]);

        return $deposit;
    }

    public static function makeDeposit(Array $args) : array{

		if($args['auth']->role_id != 1 ){
			 return[
                'error'=> true,
                'data'  =>  null,
                'errorTitle'    =>'Permission error!',
                'errorMessage'   => 'Permission denied, only company staff can perform this action!',
        	];
		}
		
		// $validator = Validator::make($request->all(), [
        //    	'deposit_id' => 'required|exists:deposits,id',
	    //     'amount' => 'required|numeric',
        // ]);  

        // if ($validator->fails()) {  
        //     return response()->json([
        //         'error' => true,
        //         'body'  =>  null,
        //         'message'   => $validator->errors()->first()
        //     ]); 
        // }

        //$deposit = Deposit::with('transferMethod')->where('id', $request->deposit_id)->first();

        if($args['deposit']->transaction_state_id == 1 )
        {
        	return [
                'error' => true,
                'body'  =>  null,
                'errorTitle' => 'Deposit error !', 
                'errorMessage'   => 'Woops Something went wrong, the deposit request is already processed',
            ]; 
        }

        if ($args['deposit'] == Null )  
        {
        	return[
                'error' => true,
                'body'  =>  null,
                'errorTitle' => 'Deposit error!',
                'errorMessage'   => 'Woops Something went wrong, we couldn\'t find the deposit request'
            ]; 
    	}

        //$user = User::findOrFail($deposit->user_id);

        //$wallet = Wallet::where('user_id', $user->id)->where('currency_id', $deposit->currency_id)->first();
        
        //$transferMethod = TransferMethod::findOrFail($deposit->transfer_method_id);

        if ( $args['wallet']->is_crypto == 1 ){

            $precision = 8 ;
        } else {
            $precision = 2;
        }


        //$deposit_fee = bcadd( bcmul ( ( $transferMethod->deposit_percentage_fee / 100 ), $request->amount, $precision) , $transferMethod->deposit_fixed_fee, $precision ) ;
        
        $deposit_fee = 0;
        
        $deposit_net = bcsub($args['gross'], $deposit_fee, $precision);

        $args['wallet']->amount = bcadd($args['wallet']->amount, $deposit_net, $precision);

    	$args['wallet']->save();

        $transaction = $args['transaction']; //Transaction::where('user_id', $args['user']->id)->where('transactionable_type', 'App\Models\Deposit')->where('transactionable_id', $args['deposit']->id)->first();
        $transaction->transaction_state_id = 1;
        $transaction->balance = $args['wallet']->amount;
        $transaction->net = $deposit_net;
        $transaction->fee = $deposit_fee;
        $transaction->updated_at = \Carbon\Carbon::now();
        $transaction->gross = $args['gross'];
        $transaction->save();

    	$args['deposit']->gross = $args['gross'];
    	$args['deposit']->fee = $deposit_fee;
    	$args['deposit']->net = $deposit_net;
    	$args['deposit']->transaction_state_id = 1;

    	$args['deposit']->save();

    	// return response()->json([
        //     'error' =>  false,
        //     'data'  =>  $deposit,
        //     'message'   =>  'Deposit Completed Successfully',
        // ], 200);

        return [];

	}

    private function randInt($digits){

        return rand(pow(10, $digits-1), pow(10, $digits)-1);

    }
}
