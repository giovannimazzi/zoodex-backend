<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\AnimalClass;
use App\Models\ConservationStatus;
use App\Models\Diet;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function index(Request $request)
    {
        $validationError = $this->validateAnimalFilters($request);

        if ($validationError) {
            return response()->json([
                'success' => false,
                'message' => $validationError,
            ], 422);
        }

        $query = Animal::with([
            'animalClass',
            'diet',
            'conservationStatus',
            'habitats',
            'continents',
            'abilities',
        ]);

        $search = $request->search;

        if ($search) {
            $dexSearch = ltrim($search, '#0');

            $query->where(function ($query) use ($search, $dexSearch) {
                $query
                    ->where('animals.name', 'LIKE', "%{$search}%")
                    ->orWhere('animals.scientific_name', 'LIKE', "%{$search}%");

                if ($dexSearch !== '' && is_numeric($dexSearch)) {
                    $query->orWhere('animals.id', (int) $dexSearch);
                }
            });
        }

        if ($request->animal_class) {

            $animalClass = AnimalClass::where('slug', $request->animal_class)->first();

            if ($animalClass) {
                $query->where('animal_class_id', $animalClass->id);
            }

        }

        if ($request->diet) {

            $diet = Diet::where('slug', $request->diet)->first();

            if ($diet) {
                $query->where('diet_id', $diet->id);
            }

        }

        if ($request->conservation_status) {

            $conservationStatus = ConservationStatus::where('slug', $request->conservation_status)->first();

            if ($conservationStatus) {
                $query->where('conservation_status_id', $conservationStatus->id);
            }

        }

        $this->applyNumericFilter($query, 'weight_kg', $request->weight_min, $request->weight_max);

        $this->applyNumericFilter($query, 'height_cm', $request->height_min, $request->height_max);

        $this->applyNumericFilter($query, 'length_cm', $request->length_min, $request->length_max);

        $this->applyNumericFilter($query, 'lifespan_years', $request->lifespan_min, $request->lifespan_max);

        if ($request->continents) {
            $continents = explode(',', $request->continents);
            $mode = $request->continents_mode ?? 'or';

            $this->applyManyToManyFilter($query, 'continents', $continents, $mode);
        }

        if ($request->habitats) {
            $habitats = explode(',', $request->habitats);
            $mode = $request->habitats_mode ?? 'or';

            $this->applyManyToManyFilter($query, 'habitats', $habitats, $mode);
        }

        if ($request->abilities) {
            $abilities = explode(',', $request->abilities);
            $mode = $request->abilities_mode ?? 'or';

            $this->applyManyToManyFilter($query, 'abilities', $abilities, $mode);
        }

        $sort = $request->sort ?? 'id';
        $direction = $request->direction ?? 'asc';

        $this->applySorting($query, $sort, $direction);

        $perPage = $request->per_page ?? 12;

        $animals = $query->paginate($perPage);

        foreach ($animals as $animal) {
            $this->prepareAnimal($animal);
        }

        return response()->json([
            'success' => true,
            'results' => $animals->items(),
            'pagination' => [
                'current_page' => $animals->currentPage(),
                'last_page' => $animals->lastPage(),
                'per_page' => $animals->perPage(),
                'total' => $animals->total(),
                'next_page_url' => $animals->nextPageUrl(),
                'prev_page_url' => $animals->previousPageUrl(),
            ],
        ]);
    }

    public function show($slug)
    {
        $animal = Animal::with([
            'animalClass',
            'diet',
            'conservationStatus',
            'habitats',
            'continents',
            'abilities',
        ])
            ->where('slug', $slug)
            ->first();

        if (!$animal) {
            return response()->json([
                'success' => false,
                'message' => 'Animale non trovato.',
            ], 404);
        }

        $previousAnimal = Animal::where('id', '<', $animal->id)
            ->orderByDesc('id')
            ->first(['id', 'name', 'slug']);

        $nextAnimal = Animal::where('id', '>', $animal->id)
            ->orderBy('id')
            ->first(['id', 'name', 'slug']);

        $this->prepareAnimal($animal);

        return response()->json([
            'success' => true,

            'results' => $animal,

            'navigation' => [
                'previous' => $previousAnimal,
                'next' => $nextAnimal,
            ],
        ]);
    }

    private function prepareAnimal($animal)
    {
        $this->setImageUrl($animal, 'card_image');
        $this->setImageUrl($animal, 'real_image');

        $this->setImageUrl($animal->animalClass);
        $this->setImageUrl($animal->diet);
        $this->setImageUrl($animal->conservationStatus);

        foreach ($animal->habitats as $habitat) {
            $this->setImageUrl($habitat);
        }

        /* foreach ($animal->continents as $continent) {
            $this->setImageUrl($continent);
        } */

        foreach ($animal->abilities as $ability) {
            $this->setImageUrl($ability);
        }

        return $animal;
    }

    private function setImageUrl($entity, $field = 'image')
    {
        if ($entity && $entity->$field && !str_starts_with($entity->$field, 'http')) 
        {
            $entity->$field = asset('storage/' . $entity->$field);
        }

        return $entity;
    }

    private function applyNumericFilter($query, $column, $min, $max)
    {
        if ($min !== null) {
            $query->where($column, '>=', $min);
        }

        if ($max !== null) {
            $query->where($column, '<=', $max);
        }
    }

    private function validateAnimalFilters($request)
    {
        $numericFilters = [
            'weight',
            'height',
            'length',
            'lifespan',
        ];

        foreach ($numericFilters as $filter) {
            $min = $request->{$filter . '_min'};
            $max = $request->{$filter . '_max'};

            if ($min !== null && (!is_numeric($min) || $min < 0)) {
                return "$filter minimo non valido.";
            }

            if ($max !== null && (!is_numeric($max) || $max < 0)) {
                return "$filter massimo non valido.";
            }

            if ($min !== null && $max !== null && (float) $min > (float) $max) {
                return "$filter minimo non può essere maggiore del massimo.";
            }
        }

        $allowedSorts = [
            'id',
            'name',
            'scientific_name',
            'weight_kg',
            'height_cm',
            'length_cm',
            'lifespan_years',
            'animal_class',
            'diet',
            'conservation_status'
        ];

        if ($request->sort && !in_array($request->sort, $allowedSorts)) {
            return 'Parametro sort non valido.';
        }

        if ($request->direction && !in_array($request->direction, ['asc', 'desc'])) {
            return 'Parametro direction non valido.';
        }

        $allowedModes = ['or', 'and'];

        foreach (['continents_mode', 'habitats_mode', 'abilities_mode'] as $mode) {
            if ($request->$mode && !in_array($request->$mode, $allowedModes)) {
                return "$mode non valido.";
            }
        }

        $perPage = $request->per_page;

        if ($perPage !== null && (
            !is_numeric($perPage) ||
            $perPage < 1 ||
            $perPage > 100
        )) {
            return 'Parametro per_page non valido.';
        }

        return null;
    }

    private function applyManyToManyFilter($query, $relation, $slugs, $mode = 'or')
    {
        if ($mode === 'and') {

            foreach ($slugs as $slug) {
                $query->whereHas($relation, function ($query) use ($slug) {
                    $query->where('slug', $slug);
                });
            }

        } else {

            $query->whereHas($relation, function ($query) use ($slugs) {
                $query->whereIn('slug', $slugs);
            });

        }
    }

    private function applySorting($query, $sort, $direction)
    {
        $numericSorts = [
            'weight_kg',
            'height_cm',
            'length_cm',
            'lifespan_years',
        ];

        if (in_array($sort, $numericSorts)) {
            $query->orderByRaw("$sort IS NULL")
                ->orderBy($sort, $direction);

            return;
        }

        if ($sort === 'animal_class') {
            $query->leftJoin('animal_classes', 'animals.animal_class_id', '=', 'animal_classes.id')
                ->orderBy('animal_classes.name', $direction)
                ->select('animals.*');

            return;
        }

        if ($sort === 'diet') {
            $query->leftJoin('diets', 'animals.diet_id', '=', 'diets.id')
                ->orderBy('diets.name', $direction)
                ->select('animals.*');

            return;
        }

        if ($sort === 'conservation_status') {
            $query->orderBy('conservation_status_id', $direction);

            return;
        }

        $query->orderBy($sort, $direction);
    }
}
