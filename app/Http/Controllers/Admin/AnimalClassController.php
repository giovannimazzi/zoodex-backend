<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnimalClass;
use Illuminate\Http\Request;

class AnimalClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AnimalClass::query();

        if ($request->id) {
            $query->where('id', $request->id);
        }

        if ($request->search) {
            $query->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('description', 'LIKE', '%' . $request->search . '%');
        }

        $sort = $request->sort ?? 'name';
        $direction = $request->direction ?? 'asc';

        $allowedSorts = [
            'id',
            'name',
            'color'
        ];

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'name';
        }

        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        $animalClasses = $query
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->appends($request->query());

        return view('admin.animalClasses.index', compact(
            'animalClasses',
            'sort',
            'direction'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.animalClasses.create');
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
    public function show(AnimalClass $animalClass)
    {
        return view('admin.animalClasses.show', compact('animalClass')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnimalClass $animalClass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnimalClass $animalClass)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnimalClass $animalClass)
    {
        //
    }
}
