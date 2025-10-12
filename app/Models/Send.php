<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Send extends Model
{	
	protected $with = ['User', 'To'];
    protected $fillable = ['user_id', 'to_id', 'receive_id', 'transaction_state_id', 'gross', 'fee', 'net', 'description', 'json_data','currency_id', 'currency_symbol'];

    public function User(){
    	return $this->belongsTo(\App\Models\User::class);
    }

    public function To(){
    	return $this->belongsTo(\App\Models\User::class, 'to_id');
    }

    public function TransactionState(){
        return $this->hasOne(\App\Models\TransactionState::class, 'id', 'transaction_state_id');
    }

    public function Currency(){
        return $this->hasOne(\App\Models\Currency::class, 'id', 'currency_id');
    }


    public function Transactions(){
        return $this->morphMany('App\Models\Transaction', 'Transactionable');
    }

    public function getGrossAttribute($value){
        if ($this->Currency()->first()->is_crypto == 1) {
                 return  $this->trimzero( $value) ;
            }

        return  number_format((float)$this->trimzero( $value), 2, '.', ',') ;
    }

    public function getFeeAttribute($value){
        if ($value > 0) {
            if ($this->Currency()->first()->is_crypto) {
                 return  '- ' . $this->trimzero($value) ;
            }
            return  '- ' . number_format((float)$this->trimzero($value), 2, '.', ',') ;
        }

        if ($this->Currency()->first()->is_crypto) {
                 return   $this->trimzero($value) ;
            }
        return number_format((float)$this->trimzero($value), 2, '.', ',') ;
    }

    public function getNetAttribute($value){

        if ($this->Currency()->first()->is_crypto) {
             return   $this->trimzero($value) ;
        }
        
        return number_format((float)$this->trimzero($value), 2, '.', ',');
    }

    private function trimzero( $val )
	{
	    preg_match( "#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($val), $o );
	    return $o[1].sprintf('%d',$o[2]).($o[3]!='.'?$o[3]:'');
	}
}
