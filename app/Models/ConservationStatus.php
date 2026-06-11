<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConservationStatus extends Model
{
    public function animals()
    {
        return $this->hasMany(Animal::class);
    }
}
