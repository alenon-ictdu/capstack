<?php

namespace ICTDUInventory;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function books(){
    	return $this->hasMany('ICTDUInventory\Book');
    }
}
