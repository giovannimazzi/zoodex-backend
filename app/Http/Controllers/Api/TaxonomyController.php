<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ability;
use App\Models\AnimalClass;
use App\Models\ConservationStatus;
use App\Models\Continent;
use App\Models\Diet;
use App\Models\Habitat;

class TaxonomyController extends Controller
{
    public function index()
    {
        $animalClasses = AnimalClass::orderBy('id')->get();
        $diets = Diet::orderBy('id')->get();
        $conservationStatuses = ConservationStatus::orderBy('id')->get();
        $habitats = Habitat::orderBy('id')->get();
        $continents = Continent::orderBy('id')->get();
        $abilities = Ability::orderBy('id')->get();

        $this->prepareEntities($animalClasses);
        $this->prepareEntities($diets);
        $this->prepareEntities($conservationStatuses);
        $this->prepareEntities($habitats);
        $this->prepareEntities($continents);
        $this->prepareEntities($abilities);

        return response()->json([
            'success' => true,
            'results' => [
                'animal_classes' => $animalClasses,
                'diets' => $diets,
                'conservation_statuses' => $conservationStatuses,
                'habitats' => $habitats,
                'continents' => $continents,
                'abilities' => $abilities,
            ],
        ]);
    }

    private function prepareEntities($entities)
    {
        foreach ($entities as $entity) {
            $this->setImageUrl($entity);
        }
    }

    private function setImageUrl($entity, $field = 'image')
    {
        if ($entity && $entity->$field && !str_starts_with($entity->$field, 'http')) {
            $entity->$field = asset('storage/' . $entity->$field);
        }

        return $entity;
    }
}