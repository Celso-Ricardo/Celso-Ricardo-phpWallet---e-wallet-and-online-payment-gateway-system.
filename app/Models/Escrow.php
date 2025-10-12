<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Escrow extends Model
{

    protected $fillable = ['user_id', 'to', 'gross', 'description','json_data','currency_id','currency_symbol','escrow_transaction_status','deleted_at','created_at','updated_at', 'agreement'];


    public function User(){
    	return $this->belongsTo(User::class);
    }

    public function toUser(){
    	return $this->belongsTo(User::class, 'to');
    }

    public function Currency(){
    	return $this->belongsTo(Currency::class);
    }

     public function getUpdatedAtAttribute(  $date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i:s');//->diffForHumans() ;//\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }

    public function getCreatedAtAttribute(  $date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:i:s');//->diffForHumans() ;//\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }


    

}
