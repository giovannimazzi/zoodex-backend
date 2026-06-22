<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnimalClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AnimalClassController extends Controller
{

    public $validator = [
            'name' => 'required|string|max:255',
            'color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'description' => 'nullable|string',

            'image' => 'nullable|image|max:2048'
        ];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AnimalClass::query();

        if ($request->id) {
            $query->where('id', $request->id);
        }

        $search = $request->search;
        if ($search) {
            $query->where(function ($query) use ($search) {

                $query->where('name', 'LIKE', "%$search%")
                    ->orWhere('description', 'LIKE', "%$search%");

            });
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
        $data = $request->validate($this->validator);

        $animalClass = new AnimalClass();

        $animalClass->name = ucfirst($data['name']);
        $animalClass->slug = Str::slug($data['name']);
        $animalClass->color = $data['color'];
        $animalClass->description = $data['description'];

        if ($request->hasFile('image')) {
            $path = Storage::putFile('animal-classes', $request->image);
            $animalClass->image = $path;
        }

        $animalClass->save();

        return redirect()
            ->route('admin.animalClasses.show', $animalClass)
            ->with('success', 'Classe creata con successo.');
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
        return view('admin.animalClasses.edit', compact('animalClass'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnimalClass $animalClass)
    {
        $data = $request->validate($this->validator);

        $removeImage = $request->boolean('remove_image');

        $animalClass->name = ucfirst($data['name']);
        $animalClass->slug = Str::slug($data['name']);
        $animalClass->color = $data['color'];
        $animalClass->description = $data['description'];

        if ($removeImage) {
            if ($animalClass->image && Storage::exists($animalClass->image)) {
                Storage::delete($animalClass->image);
            }

            $animalClass->image = null;
        }

        if ($request->hasFile('image')) {
            if ($animalClass->image && Storage::exists($animalClass->image)) {
                Storage::delete($animalClass->image);
            }

            $path = Storage::putFile('animal-classes', $request->image);
            $animalClass->image = $path;
        }

        $animalClass->save();

        return redirect()
            ->route('admin.animalClasses.show', $animalClass)
            ->with('success', 'Classe aggiornata con successo.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnimalClass $animalClass)
    {
        if ($animalClass->image && Storage::exists($animalClass->image)) {
            Storage::delete($animalClass->image);
        }

        $animalClass->delete();

        return redirect()
            ->route('admin.animalClasses.index')
            ->with('success', 'Classe eliminata con successo.');
    }
}
