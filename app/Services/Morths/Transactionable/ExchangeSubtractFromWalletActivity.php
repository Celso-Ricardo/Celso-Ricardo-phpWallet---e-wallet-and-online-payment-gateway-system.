<?php

namespace App\Services\Morths\Transactionable;

class ExchangeSubtractFromWalletActivity
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
        
        $args['user']->RecentActivity()->save($args['exchange']->Transactions()->create([
            'user_id' => $args['user']->id,
            'entity_id'   =>  $args['exchange']->id,
            'entity_name' =>  $args['rate']->firstCurrency->name,
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '-',
            'currency_id' => $args['rate']->firstCurrency->id,
            'currency_symbol' => $args['rate']->firstCurrency->symbol,
            'currency'  =>  $args['rate']->firstCurrency->code,
            'activity_title'    =>  'Currency Exchange',
            'thumb' => $args['rate']->firstCurrency->thumb,
            'gross' =>  $args['exchange']->gross,
            'fee'   =>  $args['exchange']->fee,
            'net'   =>  $args['exchange']->net,
            'balance'   =>  $args['main_wallet']->amount
        ]));
    }
}
