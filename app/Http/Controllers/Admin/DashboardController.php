<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ability;
use App\Models\Animal;
use App\Models\AnimalClass;
use App\Models\ConservationStatus;
use App\Models\Continent;
use App\Models\Diet;
use App\Models\Habitat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        $user = Auth::user();

        $animalsCount = Animal::count();
        $classesCount = AnimalClass::count();
        $dietCount = Diet::count();
        $statusCount = ConservationStatus::count();
        $habitatsCount = Habitat::count();
        $continentsCount = Continent::count();
        $abilitiesCount = Ability::count();

        $lastUpdatedAnimal = Animal::latest('updated_at')->first();
        $lastUpdatedClass = AnimalClass::latest('updated_at')->first();
        $lastUpdatedDiet = Diet::latest('updated_at')->first();
        $lastUpdatedStatus = ConservationStatus::latest('updated_at')->first();
        $lastUpdatedHabitat = Habitat::latest('updated_at')->first();
        $lastUpdatedContinent = Continent::latest('updated_at')->first();
        $lastUpdatedAbility = Ability::latest('updated_at')->first();

        return view("admin.homepage", compact(
            'user', 
            'animalsCount', 
            'classesCount',
            'dietCount',
            'statusCount',
            'habitatsCount',
            'continentsCount',
            'abilitiesCount',
            'lastUpdatedAnimal',
            'lastUpdatedClass',
            'lastUpdatedDiet',
            'lastUpdatedStatus',
            'lastUpdatedHabitat',
            'lastUpdatedContinent',
            'lastUpdatedAbility'
            ));
    }
}
