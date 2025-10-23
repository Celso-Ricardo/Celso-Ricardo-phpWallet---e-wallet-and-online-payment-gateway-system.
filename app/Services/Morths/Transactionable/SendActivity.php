<?php

namespace App\Services\Morths\Transactionable;

class SendActivity
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    // $args['me'] is the currenct authenticated
    
    // $args['send'] is the send model related to this transaction type newActivity

    // $args['currency'] is the curerncy involved in this transaction type newActivity

    // $args['myWallet'] is the wallet from the authenticated user involved in this transaction type newActivity

    // $args['precision'] is the the decimal presision for the built in bcsub function ( 2 for Fiat, and 8 for Crypto ) 

    public static function newActivity(Array $args): void 
    {
        $args['me']->RecentActivity()->save($args['send']->Transactions()->create([
            'user_id' =>  $args['me']->id,
            'entity_id'   =>  $args['send']->id,
            'entity_name' =>  $args['receiver']->name,
            'transaction_state_id'  =>  1,
            'money_flow'    => '-',
            'thumb' =>  $args['receiver']->avatar,
            'currency_id' =>  $args['currency']->id,
            'currency_symbol' =>  $args['currency']->symbol,
            'currency'  =>  $args['currency']->code,
            'activity_title'    =>  'Money Sent',
            'gross' =>  $args['send']->gross,
            'fee'   =>  $args['send']->fee,
            'net'   =>  $args['send']->net,
            'balance' => bcsub( $args['myWallet']->amount , $args['send']->net, $args['precision'] ),
        ]));
    }
}
