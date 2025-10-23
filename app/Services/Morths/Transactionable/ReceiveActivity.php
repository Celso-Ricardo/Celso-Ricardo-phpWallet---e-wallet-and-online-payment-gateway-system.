<?php

namespace App\Services\Morths\Transactionable;

class ReceiveActivity
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function newActivity(Array $args)
    {
         $args['receiver']->RecentActivity()->save($args['receive']->Transactions()->create([
            'user_id' => $args['receive']->user_id,
            'entity_id'   =>  $args['receive']->id,
            'entity_name' =>  $args['me']->name,
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '+',
            'currency_id' =>  $args['currency']->id,
            'thumb' =>  $args['me']->avatar,
            'currency_symbol' =>  $args['currency']->symbol,
            'currency'  =>  $args['currency']->code,
            'activity_title'    =>  'Money Received',
            'gross' =>  $args['receive']->gross,
            'fee'   =>  $args['receive']->fee,
            'net'   =>  $args['receive']->net,
            'balance' =>  bcadd( $args['receiverWallet']->amount , $args['receive']->net, $args['precision'] ),
        ]));
    }
}
