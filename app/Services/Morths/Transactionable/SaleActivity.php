<?php

namespace App\Services\Morths\Transactionable;

class SaleActivity
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
          $args['merchant']->User->RecentActivity()->save($args['sale']->Transactions()->create([
            'user_id' => $args['sale']->user_id,
            'entity_id'   =>  $args['merchant']->id,
            'entity_name' =>  $args['merchant']->name,
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '+',
            'currency_id' =>  $args['purchaseRequest']->currency->id,
            'currency_symbol' =>  $args['purchaseRequest']->currency->symbol,
            'thumb' =>  $args['purchase']->User->avatar(),
            'activity_title'    =>  'Sale',
            'gross' =>  $args['sale']->gross,
            'fee'   =>  $args['sale']->fee,
            'net'   =>  $args['sale']->net,
            'request_id'  =>  $args['purchaseRequest']->id,
            'json_data' =>  json_encode($args['purchaseRequest']->data),
            'balance'   =>  $args['user_wallet']->amount,
        ]));
    }
}
