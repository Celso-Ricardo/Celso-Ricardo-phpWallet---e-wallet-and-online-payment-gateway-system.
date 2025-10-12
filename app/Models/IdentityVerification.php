<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentityVerification extends Model
{
    protected $fillable = ['id','user_id','front','back','is_done','is_aproved','message'];


    public function User(){
    	return $this->belongsTo(\App\Models\User::class);
    }
}
