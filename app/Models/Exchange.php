<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
	//protected $with =	['Method','Status'];
    protected $fillable = ['user_id', 'first_currency_id', 'second_currency_id',  'gross', 'fee', 'net'];

    public function Transactions(){
        return $this->morphMany('App\Models\Transaction', 'Transactionable');
    }
    
    public function gross(){
        return  number_format((float)$this->gross, 2, '.', '') ;
    } 

      private function trimzero($val)
	{
	    preg_match( "#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($val), $o );
	    return $o[1].sprintf('%d',$o[2]).($o[3]!='.'?$o[3]:'');
	}

    public function getGrossAttribute($value){
        if ($this->firstCurrency()->first()->is_crypto == 1) {
                 return  $this->trimzero( $value);
            }

        return  number_format((float)$this->trimzero( $value), 2, '.', ',') ;
    }

    public function fee(){
        if ($this->fee > 0) {
            return   number_format((float)$this->fee, 2, '.', '') ;
        }
        return number_format((float)$this->fee, 2, '.', '') ;
    }

    public function net(){
         return  number_format((float)$this->net, 2, '.', '') ;
    }

    public function firstCurrency()
    {
        return $this->belongsTo(Currency::class,  'first_currency_id', 'id');
    }

    public function secondCurrency()
    {
        return $this->belongsTo(Currency::class, 'second_currency_id', 'id' );
    }
}