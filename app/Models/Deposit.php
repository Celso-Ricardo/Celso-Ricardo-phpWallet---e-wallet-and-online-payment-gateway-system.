<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
	//protected $with =	['Method','Status'];
    protected $fillable = ['user_id', 'transaction_state_id', 'transaction_receipt', 'gross', 'fee', 'net', 'json_data', 'wallet_id', 'currency_id', 'currency_symbol','message', 'transfer_method_id', 'unique_transaction_id'];

    public function Transactions(){
        return $this->morphMany('App\Models\Transaction', 'Transactionable');
    }

    public function TransferMethod(){
        return $this->hasOne(\App\Models\TransferMethod::class, 'id', 'transfer_method_id');
    }
    
    public function Wallet(){
        return $this->hasOne(\App\Models\Wallet::class, 'id', 'wallet_id');
    }

    public function User(){
        return $this->hasOne(\App\Models\User::class, 'id', 'user_id');
    }

    public function Currency(){
        return $this->hasOne(\App\Models\Currency::class, 'id', 'currency_id');
    }

    public function TransactionState(){
        return $this->hasOne(\App\Models\TransactionState::class, 'id', 'transaction_state_id');
    }

    public function getUpdatedAtAttribute(  $date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i:s');//->diffForHumans() ;//\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }

    public function getCreatedAtAttribute(  $date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i:s');//->diffForHumans() ;//\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }

    private function trimzero($val)
	{
	    preg_match( "#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($val), $o );
	    return $o[1].sprintf('%d',$o[2]).($o[3]!='.'?$o[3]:'');
	}

    public function getGrossAttribute($value){
        if ($this->Currency()->first()->is_crypto == 1) {
                 return  $this->trimzero( $value);
            }

        return  number_format((float)$this->trimzero( $value), 2, '.', ',') ;
    }

    public function getFeeAttribute($value){
        if ($value > 0) {
            if ($this->Currency()->first()->is_crypto) {
                 return   $this->trimzero($value);
            }
            return   number_format((float)$this->trimzero($value), 2, '.', ',');
        }

        if ($this->Currency()->first()->is_crypto) {
                 return   $this->trimzero($value);
            }
        return number_format((float)$this->trimzero($value), 2, '.', ',') ;
    }

    public function getNetAttribute($value){

        if ($this->Currency()->first()->is_crypto) {
             return   $this->trimzero($value);
        }
        
        return  number_format((float)$this->trimzero($value), 2, '.', ',') ;
    }

   

}
