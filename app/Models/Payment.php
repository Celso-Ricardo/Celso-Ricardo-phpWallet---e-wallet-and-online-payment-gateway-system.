<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    
    protected $fillable = ['user_id', 'to_id', 'transaction_state_id', 'gross', 'fee', 'net', 'description', 'json_data','currency_id', 'item_id'];

    public function From(){
    	return $this->belongsTo(\App\User::class);
    }

    public function To(){
    	return $this->belongsTo(\App\User::class, 'to_id');
    }

    public function User($id){
    	if($this->from->id == $id){
    		return $this->from;
    	}
    	if($this->to->id == $id){
    		return $this->to;
    	}
    }

    public function Item(){
    	return $this->belongsTo(\App\Models\Item::class, 'item_id');
    }

    public function Transactions(){
        return $this->morphMany('App\Models\Transaction', 'Transactionable');
    }
}
