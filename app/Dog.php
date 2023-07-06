<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    protected $table = "dog";
    
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
    public function size()
    {
        return $this->belongsTo(Size::class);
    }
    public function race()
    {
        return $this->belongsTo(Race::class);
    }
  
}
