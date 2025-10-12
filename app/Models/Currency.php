<?php

namespace App\Models;

use Storage;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
	protected $fillable = ['name', 'symbol', 'created_at', 'updated_at' , 'code', 'is_crypto','thumb'];

	public function getThumbAttribute($value){
		if($value) return $value;

		return Storage::url('users/default.png');
	}

	public function DepositMethods(){
		return $this->belongsToMany(\App\Models\DepositMethod::class, 'currency_deposit_methods');
	}

	public function WithdrawalMethods(){
		return $this->belongsToMany(\App\Models\WithdrawalMethod::class, 'currency_withdrawal_methods');
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