<?php

namespace ICTDUInventory;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function borrower(){
    	return $this->hasOne('ICTDUInventory\Borrower');
    }

    public function course(){
    	return $this->belongsTo('ICTDUInventory\Course');
    }
}
