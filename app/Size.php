<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $table = "size";
    protected $fillable = ['name', 'scale'];
    public function dogs()
    {
        return $this->hasMany(Dog::class);
    }
}
