<?php

namespace App\Services\Morths\Transactionable;

class ExchangeAddToWalletActivity
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
            'entity_name' =>  $args['rate']->secondCurrency->name,
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '+',
            'currency_id' => $args['rate']->secondCurrency->id,
            'currency_symbol' => $args['rate']->secondCurrency->symbol,
            'currency'  =>  $args['rate']->secondCurrency->code,
            'thumb' => $args['rate']->secondCurrency->thumb,
            'activity_title'    =>  'Currency Exchange',
            'gross' => $args['exchange_result'],
            'fee'   =>  $args['exchange']->fee,
            'net'   => $args['exchange_result'],
            'balance'   =>  $args['second_wallet']->amount
        ]));

    }
}
