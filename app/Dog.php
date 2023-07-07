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
    public function toArray()
    {
        $data = parent::toArray();

        // Obtener los datos de las relaciones
        $data['color'] = $this->color->toArray();
        $data['size'] = $this->size->toArray();
        $data['race'] = $this->race->toArray();
        $data['image_path'] = asset('images/'.$this->image);

        return $data;
    }
}
