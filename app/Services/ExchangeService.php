<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Exchange;

class ExchangeService
{

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function exchange(Array $args)
    
    {
        $exchange_rate = $args['rate'];

        if (is_null($exchange_rate)) {
        	return[
                'error'=> true,
                'data'  =>  null,
                'errorTitle'    =>'Rate not found!',
                'errorMessage'   => ' No Exchange rate available for this pair of currencies, please contact admin to add this rate',
        	];
        }

        $main_currency = $args['rate']->firstCurrency;
        $second_currency = $args['rate']->secondCurrency;
        $main_wallet = Wallet::where('user_id',  $args['user']->id)->where('currency_id', $args['first_currency_id'])->first();

        if((float)$main_wallet->amount < (float)$args['amount']){       
            return[
                'error'=> true,
                'data'  =>  null,
                'errorTitle'    =>'Insufficient funds.',
                'errorMessage'   => ' Insufficient funds to Exchange ' .  $main_currency->symbol  . '' . $args['amount'] . ' ',
        	];
        }

        $second_wallet = Wallet::where('user_id',  $args['user']->id)->where('currency_id', $args['second_currency_id'])->first();

        if(is_null($second_wallet)){
            return[
                'error'=> true,
                'data'  =>  null,
                'errorTitle'    =>'Wallet not found !',
                'errorMessage'   => 'Please, setup your ' . $second_currency->name  . ' wallet first.',
        	];
        }


        if ( $second_currency->is_crypto == 1 ){
        	$second_currency_precision = 8 ;
        } else {
        	$second_currency_precision = 2;
        }


        if ( $main_currency->is_crypto == 1 ){
            $main_currency_precision = 8 ;
        } else {
            $main_currency_precision = 2;
        }

        $exchange_result = bcmul((string)$args['amount'],(string)$exchange_rate->exchanges_to_second_currency_value, $second_currency_precision);

        $second_wallet->amount = bcadd($second_wallet->amount, $exchange_result, $second_currency_precision);
        $main_wallet->amount = bcsub($main_wallet->amount, $args['amount'], $main_currency_precision);

        $second_wallet->save();
        $main_wallet->save();

        // $first_wallet_new_amount = 'new_amount_for_'.$main_wallet->name . '_wallet';
        // $second_wallet_new_amount = 'new_amount_for'.$second_wallet->amount.'_wallet';

        $exchange = Exchange::create([
            'user_id'   =>  $args['user']->id,
            'first_currency_id' =>   $main_currency->id,
            'second_currency_id'    =>  $second_currency->id,
            'gross' =>  $args['amount'],
            'fee'   =>  0.00,
            'net'   =>  $args['amount'],
        ]);

        return [
            'exchange' => $exchange, 
            'main_wallet' => $main_wallet, 
            'second_wallet' => $second_wallet,
            'exchange_result' =>  $exchange_result,
        ];

    }

}
