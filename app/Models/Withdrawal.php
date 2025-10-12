<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    protected $fillable = ['user_id','transaction_state_id','send_to_platform_name', 'platform_id', 'gross','fee','net','json_data','currency_id', 'currency_symbol','wallet_id', 'transfer_method_id', 'unique_transaction_id'];

    public function Transactions()
    {
        return $this->morphMany('App\Models\Transaction', 'Transactionable');
    }

    public function User()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function TransactionState()
    {
        return $this->belongsTo(\App\Models\TransactionState::class);
    }
    
    public function TransferMethod()
    {
        return $this->hasOne(\App\Models\TransferMethod::class, 'id', 'transfer_method_id');
    }
    
    public function Wallet()
    {
        return $this->hasOne(\App\Models\Wallet::class, 'id', 'wallet_id');
    }

    public function Currency()
    {
        return $this->hasOne(\App\Models\Currency::class, 'id', 'currency_id');
    }

    public function Status()
    {
        return $this->hasOne(\App\Models\TransactionState::class, 'id', 'transaction_state_id');
    }

    public function getGrossAttribute($value)
    {
        return number_format((float)$this->trimzero($value), 2, '.', '') ;
    } 

    public function getFeeAttribute($value)
    {
        if ($this->trimzero($value) > 0) 
        {
            return   number_format((float)$this->trimzero($value), 2, '.', '') ;
        }
        return number_format((float)$this->trimzero($value), 2, '.', '');
    }

    public function getNetAttribute($value)
    {
        return number_format((float)$this->trimzero($value), 2, '.', '') ;
    }
 
    public function getUpdatedAtAttribute($date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i:s');//->diffForHumans() ;//\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }

    public function getCreatedAtAttribute($date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i:s');//->diffForHumans() ;//\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }
    
    private function trimzero($val)
	{
	    preg_match( "#^([\+\-]|)([0-9]*)(\.([0-9]*?)|)(0*)$#", trim($val), $o );
	    return $o[1].sprintf('%d',$o[2]).($o[3]!='.'?$o[3]:'');
	}

}
