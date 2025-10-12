<?php

namespace App\Models;

use App\Models\User;
use Storage;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{	
	protected $table = 'transactionable';
    //protected $with = ['Status'];
    
    protected $fillable = [
        'user_id',
        'entity_id',
        'entity_name',
        'thumb',
        'currency',
        'balance',
        'activity_title',
        'money_flow',
        'transaction_state_id',
        'request_id',
        'gross',
        'fee',
        'net',
        'json_data',
        'currency_id',
        'is_crypto',
        'currency_symbol'];


    public function Transactionable(){
    	return $this->morph();
    }

    public function Currencie(){
        return $this->hasOne(\App\Models\Currency::class, 'id', 'currency_id');
    }

    public function Status(){
        return $this->hasOne(\App\Models\TransactionState::class, 'id', 'transaction_state_id');
    }

    public function User(){
    	return $this->belongsTo(\App\Models\User::class);
    }

    public function TransactionState(){
    	return $this->belongsTo(\App\Models\TransactionState::class);
    }
   
    
    public function getBalanceAttribute($value){
        if ($this->Currencie()->first()->is_crypto == 1) {
                 return $this->money_flow .' '. $this->trimzero( $value) .' '. $this->currency_symbol;
            }

        return $this->money_flow .' '. number_format((float)$this->trimzero( $value), 2, '.', ',') .' '.  $this->currency_symbol;
    } 

    public function getGrossAttribute($value){
        if ($this->Currencie()->first()->is_crypto == 1) {
                 return $this->money_flow .' '. $this->trimzero( $value) .' '. $this->currency_symbol;
            }

        return $this->money_flow .' '. number_format((float)$this->trimzero( $value), 2, '.', ',') .' '.  $this->currency_symbol;
    }

    public function getFeeAttribute($value){
        if ($this->fee > 0) {
            if ($this->Currencie()->first()->is_crypto) {
                 return  '- ' . $this->trimzero($value) .' '. $this->currency_symbol;
            }
            return  '- ' . number_format((float)$this->trimzero($value), 2, '.', ',') .' '. $this->currency_symbol;
        }

        if ($this->Currencie()->first()->is_crypto) {
                 return   $this->trimzero($value) .' '. $this->currency_symbol;
            }
        return number_format((float)$this->trimzero($value), 2, '.', ',') . ' '. $this->currency_symbol;
    }

    public function getNetAttribute($value){

        if ($this->Currencie()->first()->is_crypto) {
             return $this->money_flow .' '.  $this->trimzero($value) .' '. $this->currency_symbol;
        }
        
        return $this->money_flow .' '. number_format((float)$this->trimzero($value), 2, '.', ',') . ' '. $this->currency_symbol;
    }

    // public function balance(){

    //     if ($this->Currencie()->first()->is_crypto) {
    //          return $this->money_flow .' '.$this->balance .' '. $this->currency_symbol;
    //     }
        
    //     return number_format((float) $this->balance, 2, '.', ',') . ' '. $this->currency_symbol;
    // }

    public function thumb(){
        return $this->thumb;
    }

    public function getUpdatedAtAttribute(  $date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i:s');//->diffForHumans() ;//\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }

    public function getCreatedAtAttribute(  $date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i:s');//->diffForHumans() ;//\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }

    private function trimzero( $val )
	{
	    preg_match( "#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($val), $o );
	    return $o[1].sprintf('%d',$o[2]).($o[3]!='.'?$o[3]:'');
	}
    
}
