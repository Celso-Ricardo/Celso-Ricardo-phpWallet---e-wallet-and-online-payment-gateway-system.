<?php

namespace App\Services;
use App\Models\Receive;
use App\Models\Send;

class SendService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->fixedFee = 0;
        $this->perecentageFee = 0;
    }

     public function sendMoney(Array $args){

    	// if ($args['amount'] <= 0) {

        //     return response()->json([
        //         'error'=>true,
        //         'data' => null,
        //         'message' => 'The amount must be greater than zero'   	
        //     ]); 
        // }

      
        // $validator = Validator::make($request->all(), [
        //    	'amount'    =>  'required|numeric',
        //     'description'   =>  'required|string',
        //     'receiver_email' =>  'required|email|exists:users,email',
        //     'currency_id' => 'required|exists:currencies,id',
        //     //'transfer_method_id' => 'required|exists:transfer_methods,id'
        // ]);

        // if ($validator->fails()) {  
        //     return response()->json([
        //         'error' =>  true,
        //         'data'  => null,
        //         'message'=>$validator->errors()
        //     ]); 
        // }

        $me = $args['me']; //between:0,'. auth()->user()->currentWallet()->amount

        $receiver = $args['receiver'];

        if ($args['receiver_email'] == $me->email) {
        	return[
                'error' => true,
                'data'=> null,
                'errorTitle'    =>  'Same account exception !',
                'errorMessage' => 'It is not allowed sending money from and to the same account ',
            ];
        } 

        if ( $me->verified == 0 ) {
            return[
                'error' => true,
                'data'  =>  null,
                'errorTitle'    =>  'Unverified Account!',
                'errorMessage' => ' Your account email is not verified. please verify your email before sending money to friends '
             ];
        }

        if ( $me->account_status == 0 ) {
             return [
                'error' => true,
                'errorTitle'    =>  'Acount is paused for transaction inspection',
                'errorMessage' => ' Your account is under a withdrawal request review proccess. please wait for a few minutes and try again. ',
                'data'  => null,
             
            ];
        }

        $currency = $args['currency'];
        
        if ( $currency->is_crypto == 1 ){
            $precision = 8 ;
        } else {
            $precision = 2;
        }

        $send_fee = 0; //free to send money
        $receive_fee = bcadd(bcmul ( ( $this->perecentageFee / 100 ), $args['amount'], $precision) , $this->fixedFee , $precision ) ;

        if($currency->is_crypto == 1){
        	$receive_fee = bcmul ( ( $this->perecentageFee / 100 ), $args['amount'], $precision);
        }

        if ( ($args['amount'] - $receive_fee) < 0 ) {

	            return [
	                'error'=> true, 
                    'data' => null,
                    'errorTitle'    =>  'Unsufficient amount with fees',
                    'errorMessage' => 'The minimum amount to send is '. ( $args['amount'] + (float)abs($args['amount'] - $receive_fee) ). '  because of service fee ( '. $this->fixedFee  .' + ' .  $this->perecentageFee .  '% ) ',
                ]; 
        }

        $myWallet = $args['myWallet'];

        if(is_null($myWallet)){
        	return [
                'error' => true,
                'data'  => null,
                'errorTitle' => 'Unregistered wallet',
                'errorMessage' => $me->name . ' , you don\'t have a ' . $currency->name . ' wallet to send '. $args['amount'] . ' to '. $args['receiver_email'] . ' please setup a new '. $currency->name .' wallet and make a currency exchange ( without fees ), then transfer to your friend. ',
            ];
        }
 
        if ( $args['amount'] > $myWallet->amount ) {

            return response()->json([
                'error'=> true,
                "data"  => null,
                'errorTitle' => 'Unsufficient funds in wallet!' , 
                'errorMessage' => ' Non-sufficient funds. ',
                	
            ]); 
        }


         if ( $receiver->verified == 0 ) {

            return response()->json([
                'error' => true,
                'data'  =>  null, 
                'errorTitle'    => ' Trying to send to an unverified account!',
                'errorMessage' => ' The receiver account email is not verified. ',
            ]);
        }

        ///$receiverWallet = Wallet::where('user_id', $receiver->id)->where('currency_id', $request->currency_id)->where('transfer_method_id', $request->transfer_method_id)->first();

        $receiverWallet = $args['receiverWallet'];


        if(is_null($receiverWallet)){

            //$method = TransferMethod::where('id', $request->transfer_method_id)->first();

            return response()->json([
                'error' => true,
                'data'=> null,
                'errorTitle' => 'Error!',
                'errorMessage' => $receiver->name. ', doesn\'t have a registered '.  $currency->name . ' wallet to receive a transfer from your '.  $currency->name . ' wallet',
            ]);
        	
        }

        $receive = Receive::create([
            'user_id'   =>   $receiver->id,
            'from_id'        => $me->id,
            'transaction_state_id'  =>  1, // waiting confirmation
            'gross'    =>  $args['amount'],
            'currency_id' =>  $currency->id,
            'currency_symbol' =>  $currency->symbol,
            'fee'   =>  $receive_fee,
            'net'   =>  bcsub( $args['amount'] , $receive_fee, $precision ),
            'description'   =>  $args['description'],
        ]);

        $send = Send::create([
            'user_id'   =>  $me->id,
            'to_id'        =>  $receiver->id,
            'transaction_state_id'  =>  1, // waiting confirmation 
            'gross'    =>  $args['amount'],
            'currency_id' =>  $currency->id,
            'currency_symbol' =>  $currency->symbol,
            'fee'   =>  $send_fee,
            'net'   =>  bcsub( $args['amount'] , $send_fee, $precision ),
            'description'   =>  $args['description'],
            'receive_id'    =>  $receive->id
        ]);

        $receive->send_id = $send->id;
        $receive->save();

        $receive->send_id = $send->id;
        $receive->save();

        $myWallet->amount = bcsub( $myWallet->amount , $send->net, $precision ) ;
        $myWallet->save();

        $receiverWallet->amount =  bcadd( $receiverWallet->amount , $receive->net, $precision ) ;
        $receiverWallet->save();

        return [
            'receive' => $receive, 
            'send' => $send, 
            'precision' => $precision
        ];

        // $receiver->RecentActivity()->save($receive->Transactions()->create([
        //     'user_id' => $receive->user_id,
        //     'entity_id'   =>  $receive->id,
        //     'entity_name' =>  $me->name,
        //     'transaction_state_id'  =>  1,
        //     'money_flow'    => '+',
        //     'currency_id' =>  $currency->id,
        //     'thumb' =>  $me->avatar,
        //     'currency_symbol' =>  $currency->symbol,
        //     'activity_title'    =>  'Money Received',
        //     'gross' =>  $receive->gross,
        //     'fee'   =>  $receive->fee,
        //     'net'   =>  $receive->net,
        //     'balance' => $receiverWallet->amount ,
        // ]));

        // $transaction = $me->RecentActivity()->save($send->Transactions()->create([
        //     'user_id' =>  $me->id,
        //     'entity_id'   =>  $send->id,
        //     'entity_name' =>  $receiver->name,
        //     'transaction_state_id'  =>  1,
        //     'money_flow'    => '-',
        //     'thumb' =>  $receiver->avatar,
        //     'currency_id' =>  $currency->id,
        //     'currency_symbol' =>  $currency->symbol,
        //     'activity_title'    =>  'Money Sent',
        //     'gross' =>  $send->gross,
        //     'fee'   =>  $send->fee,
        //     'net'   =>  $send->net,
        //     'balance' => $myWallet->amount,
        // ]));

      
     
    }
}
