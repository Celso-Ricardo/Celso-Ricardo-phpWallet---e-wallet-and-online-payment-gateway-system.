<?php

namespace App\Services\Morths\Transactionable;

class PurchaseActivity
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
        
        $args['user']->RecentActivity()->save($args['purchase']->Transactions()->create([
            'user_id' => $args['user']->id,
            'entity_id'   =>  $args['merchant']->id,
            'entity_name' =>  $args['merchant']->name,
            'transaction_state_id'  =>  1, // waiting confirmation
            'money_flow'    => '-',
            'activity_title'    =>  'Purchase',
            'currency_id' =>  $args['purchaseRequest']->currency->id,
            'thumb' =>  $args['merchant']->logo,
            'currency_symbol' =>  $args['purchaseRequest']->currency->symbol,
            'gross' =>  $args['purchase']->gross,
            'fee'   =>  $args['purchase']->fee,
            'net'   =>  $args['purchase']->net,
            'request_id'  =>  $args['purchaseRequest']->id,
            'json_data' =>  json_encode($args['purchaseRequest']->data),
            'balance'   => $args['auth_wallet']->amount,
        ]));

    }
}
