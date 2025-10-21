<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionState extends Model
{
    //

    public $fillable = ['name', 'json_data', 'created_at', 'updated_at'];

    public function getColor():string{
        if($this->id == 1){
            return 'success';
        }
        if($this->id == 2){
            return 'warnig';
        }
        if($this->id == 3){
            return 'primary';
        }
    }
}
