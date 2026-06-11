<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalClass extends Model
{
    public function animals()
    {
        return $this->hasMany(Animal::class);
    }
}
