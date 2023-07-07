<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{

    protected $table = "color";
    protected $fillable = ['name'];

    public function dogs()
    {
        return $this->hasMany(Dog::class);
    }
}
