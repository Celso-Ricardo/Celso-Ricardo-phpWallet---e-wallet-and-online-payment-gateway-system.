<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionState extends Model
{
    //

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
