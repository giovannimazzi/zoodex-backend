<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\AnimalClass;
use App\Models\ConservationStatus;
use App\Models\Diet;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
   {
        $query = Animal::with([
            'animalClass',
            'diet',
            'conservationStatus',
        ]);

        if ($request->id) {
            $query->where('id', $request->id);
        }

        if ($request->search) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->animal_class_id) {
            $query->where('animal_class_id', $request->animal_class_id);
        }

        if ($request->diet_id) {
            $query->where('diet_id', $request->diet_id);
        }

        if ($request->conservation_status_id) {
            $query->where('conservation_status_id', $request->conservation_status_id);
        }

        $sort = $request->sort ?? 'id';
        $direction = $request->direction ?? 'asc';

        $allowedSorts = [
            'id',
            'name',
            'animal_class_id',
            'diet_id',
            'conservation_status_id',
        ];

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }

        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        $animals = $query
            ->orderBy($sort, $direction)
            ->paginate(5)
            ->appends($request->query());

        $animalClasses = AnimalClass::orderBy('name')->get();
        $diets = Diet::orderBy('name')->get();
        $conservationStatuses = ConservationStatus::orderBy('id')->get();

        return view('admin.animals.index', compact(
            'animals',
            'sort',
            'direction',
            'animalClasses',
            'diets',
            'conservationStatuses'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Animal $animal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Animal $animal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Animal $animal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Animal $animal)
    {
        //
    }
}
