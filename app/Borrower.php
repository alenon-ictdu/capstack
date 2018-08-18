<?php

namespace ICTDUInventory;

use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    public function book(){
    	return $this->belongsTo('ICTDUInventory\Book');
    }
}
