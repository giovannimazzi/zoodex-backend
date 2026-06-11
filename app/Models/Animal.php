<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    public function animalClass()
    {
        return $this->belongsTo(AnimalClass::class);
    }

    public function diet()
    {
        return $this->belongsTo(Diet::class);
    }

    public function conservationStatus()
    {
        return $this->belongsTo(ConservationStatus::class);
    }

    public function abilities()
    {
        return $this->belongsToMany(Ability::class)
            ->withTimestamps();
    }

    public function habitats()
    {
        return $this->belongsToMany(Habitat::class)
            ->withTimestamps();
    }

    public function continents()
    {
        return $this->belongsToMany(Continent::class)
            ->withTimestamps();
    }
}
