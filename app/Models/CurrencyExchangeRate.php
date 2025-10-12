<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyExchangeRate extends Model
{
	protected $fillable = ['first_currency_id', 'second_currency_id', 'exchanges_to_second_currency_value'];
	
	public function firstCurrency(){

		return $this->belongsTo(Currency::class, 'first_currency_id');

	}

	public function secondCurrency(){

		return $this->belongsTo(Currency::class, 'second_currency_id');

	}
	public function getExchangesToSecondCurrencyValueAttribute($value)
	{
		return $this->trimzero($value);
	}


	private function trimzero( $val )
	{
	    preg_match( "#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($val), $o );
	    return $o[1].sprintf('%d',$o[2]).($o[3]!='.'?$o[3]:'');
	}

}