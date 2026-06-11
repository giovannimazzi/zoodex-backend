<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitat extends Model
{
    public function animals()
    {
        return $this->belongsToMany(Animal::class)
            ->withTimestamps();
    }
}
