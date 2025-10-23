<?php

namespace App\Services\Morths\Transactionable;
use App\Models\Withdrawal;
use App\Models\Transaction;

class WithdrawalActivity
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
        $args['auth']->RecentActivity()->save($args['withdrawal']->Transactions()->create([
            'user_id' => $args['auth']->id,
            'entity_id'   =>  $args['auth']->id,
            'entity_name' =>  $args['transferMethod']->name,
            'transaction_state_id'  =>  3, // completed
            'money_flow'    => '-',
            'activity_title'    =>  'Withdrawal',
            'balance'   =>   $args['wallet']->amount,
            'thumb' =>  $args['transferMethod']->thumbnail ?? '' ,
            'gross' =>  $args['withdrawal']->gross,
            'fee'   =>  $args['withdrawal']->fee,
            'net'   =>  $args['withdrawal']->net,
            'currency_id'   =>  $args['withdrawal']->currency_id,
            'currency_symbol'   =>  $args['withdrawal']->currency_symbol,
            'currency'  =>  $args['currency']->code,
        ]));
    }
    
    public function removeActivity(Withdrawal $withdrawal)
    {
        $transaction = Transaction::where('transactionable_type', 'App\Models\Withdrawal')->where('transactionable_id', $withdrawal->id)->first();
        $transaction->delete(); 
    }
}
