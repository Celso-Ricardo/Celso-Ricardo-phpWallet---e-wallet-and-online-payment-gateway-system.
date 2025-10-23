<?php

namespace App\Services;
use App\Models\Withdrawal;

class WithdrawalService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function requestWithdrawal(Array $args)
    {
        // $validator = Validator::make($request->all(), [
        //     'wallet_id' => 'required|integer|exists:wallets,id',
        //     'amount'   =>  'required|numeric',
        // ]);
    
        // if ($validator->fails()) {  
        //     return response()->json([
        //         'error' => true,
        //         'data'  =>  null,
        //         'message'=>$validator->errors()->first()
        //     ]); 
        // } 
        
        $wallet = $args['wallet'];
       

        $currency =  $args['currency'];
        
        $transferMethod = $args['transferMethod'];
       
        if($wallet->amount < $args['gross']){

             return [
                'error' => true,
                'data'  =>  null,
                'errorTitle'    =>  'Insufficient funds',
                'errorMessage'=>'your balance is not enough to withdraw '. $args['gross'] .' '. $args['currency']->code 
            ]; 
        }


        if ( $wallet->is_crypto == 1 ){
            $precision = 8 ;
        } else {
            $precision = 2;
        }


        if ($args['auth']->account_status == 0 ) {
            return [
                'error' =>  true,
                'body'  => null,
                'errorTitle'  =>  'Withdrawal error!',
                'errorMessage' =>' Your account is under a withdrawal request review proccess. Please wait until your request is complete in a few minutes to continue with your activities. '
                ]
            ;
        }


        $withdraw_fee = bcadd( bcmul ( ( $transferMethod->withdraw_percentage_fee / 100 ), $args['gross'], $precision) , $transferMethod->withdraw_fixed_fee, $precision ) ;
    
        $withdraw_net = bcsub($args['gross'], $withdraw_fee, $precision );
    	
        $withdrawal = Withdrawal::create([
            'user_id'   =>  $args['auth']->id,
            'transaction_state_id'  =>  3,
            'transfer_method_id'    =>  $transferMethod->id,
            'platform_id'  =>  $wallet->account_identifier_mechanism_value,
            'send_to_platform_name' =>  $transferMethod->name,
            'gross' =>  $args['gross'],
            'fee'   =>  $withdraw_fee,
            'currency_id'   =>  $transferMethod->currency_id,
            'currency_symbol'   =>  $transferMethod->currency->symbol,
            'wallet_id' => $wallet->id,
            'net'   =>   $withdraw_net,
        ]);

        return $withdrawal;

    }

    public function makeWithdrawal(Array $args)
	{

		if($args['auth']->role_id != 1 ){
			 return [
                'error'=> true,
                'data'  =>  null,
                'errorTitle'    =>'Permission error!',
                'errorMessage'   => 'Permission denied, only company staff can perform this action!',
        	];
		}

		// $validator = Validator::make($request->all(), [
        //    	'withdraw_id' => 'required|exists:withdrawals,id',
        // ]);  

        // if ($validator->fails()) {  
        //     return response()->json([
        //         'error' => true,
        //         'body'  =>  null,
        //         'message'   => $validator->errors()->first()
        //     ]); 
        // }


		//$withdrawal = Withdrawal::with('transferMethod')->findOrFail($request->withdraw_id);
        //$transferMethod = TransferMethod::findOrFail($withdrawal->transfer_method_id);


        if ($args['withdrawal']->transaction_state_id != 3 and $args['withdrawal']->transaction_state_id != 2 ) {
           return[
                'error' => true,
                'body'  =>  null,
                'errorTitle' => 'Withdrawal Error!',
                'errorMessage'   => 'Woops Something went wrong, the withdrawal is already processed',
            ]; 
        }

        //$user = User::findOrFail($withdrawal->user_id);

        //$wallet = Wallet::findOrFail($withdrawal->wallet_id);

        if ( $args['wallet']->is_crypto == 1 ){
            $precision = 8 ;
        } else {
            $precision = 2;
        }


        if ($args['wallet']->amount < $args['withdrawal']->gross) {

        	 return [
                'error' => true,
                'body'  =>  null,
                'errorTitle'  => 'Withdrawal error!',
                'errorMessage'   => 'User doesen\'t have enought funds to withdraw '.$args['gross'].' '. $args['currency']->code . ' from his wallet '  , 
            ]; 
        }

        $args['wallet']->amount = bcsub($args['wallet']->amount ,$args['withdrawal']->gross, $precision);

        $transaction = $args['transaction']; // Transaction::where('user_id', $user->id)->where('transactionable_type', 'App\Models\Withdrawal')->where('transactionable_id', $withdrawal->id)->first();
        $transaction->transaction_state_id = 1;
        $transaction->balance = $args['wallet']->amount;
        $transaction->updated_at = \Carbon\Carbon::now();
        $transaction->save();

        $args['withdrawal']->transaction_state_id = 1;

        $args['withdrawal']->save();
        $args['user']->account_status = 1;
        $args['wallet']->save();
        $args['user']->save();

        //Send Notification to User
        //Mail::send(new withdrawalCompletedUserNotificationEmail($withdrawal, $user));
        
        //return redirect(url('/').'/admin/dashboard/withdrawals/'.$withdrawal->id);

        // return response()->json([
        //     'error' =>  false,
        //     'data'  =>  $withdrawal,
        //     'message'   =>  'Withdraw Completed Successfully',
        // ], 200);

	}
}
