<?php

namespace App\Services\Morths\Transactionable;

use App\Models\Transaction;
use App\Models\Deposit;

class DepositActivity
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function appendNewActivity(Array $args)
    {
    
        $img = '';
        foreach($args['transaction_receipt'] as $key => $value){
            $img = $value;
        }
        
       $act = $args['auth']->RecentActivity()->save($args['deposit']->Transactions()->create([
                'user_id' =>  $args['auth']->id,
                'entity_id'   =>   $args['auth']->id,
                'entity_name' =>    $args['transferMethod']->name,
                'transaction_state_id'  =>  3,
                'money_flow'    => '+',
                'activity_title'    =>  'Deposit',
                'currency'  => $args['currency']->code,
                'balance'   =>   $args['wallet']->amount,
                'currency_id'   => $args['deposit']->currency_id,
                'currency_symbol'   =>  $args['deposit']->currency_symbol,
                'thumb' =>  $img,
                'gross' =>  0,
                'fee'   =>  0,
                'net'   =>  0
            ])
        );
     
    }

    public function removeActivity(Deposit $deposit)
    {
        $transaction = Transaction::where('transactionable_type', 'App\Models\Deposit')->where('transactionable_id', $deposit->id)->first();
        $transaction->delete(); 
    }
}
