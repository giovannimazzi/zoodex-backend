<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ability;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AbilityController extends Controller
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
        $query = Ability::query();

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

        $sort = $request->sort ?? 'id';
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

        $abilities = $query
            ->orderBy($sort, $direction)
            ->paginate(5)
            ->appends($request->query());

        return view('admin.abilities.index', compact(
            'abilities',
            'sort',
            'direction'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.abilities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->validator);

        $ability = new Ability();

        $ability->name = ucfirst($data['name']);
        $ability->slug = Str::slug($data['name']);
        $ability->color = $data['color'];
        $ability->description = ucfirst($data['description']);

        if ($request->hasFile('image')) {
            $path = Storage::putFile('abilities', $request->image);
            $ability->image = $path;
        }

        $ability->save();

        return redirect()
            ->route('admin.abilities.show', $ability)
            ->with('success', 'Abilità creata con successo.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ability $ability)
    {
        return view('admin.abilities.show', compact('ability')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ability $ability)
    {
        return view('admin.abilities.edit', compact('ability'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ability $ability)
    {
        $data = $request->validate($this->validator);

        $removeImage = $request->boolean('remove_image');

        $ability->name = ucfirst($data['name']);
        $ability->slug = Str::slug($data['name']);
        $ability->color = $data['color'];
        $ability->description = ucfirst($data['description']);

        if ($removeImage) {
            if ($ability->image && Storage::exists($ability->image)) {
                Storage::delete($ability->image);
            }

            $ability->image = null;
        }

        if ($request->hasFile('image')) {
            if ($ability->image && Storage::exists($ability->image)) {
                Storage::delete($ability->image);
            }

            $path = Storage::putFile('abilities', $request->image);
            $ability->image = $path;
        }

        $ability->save();

        return redirect()
            ->route('admin.abilities.show', $ability)
            ->with('success', 'Abilità aggiornata con successo.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ability $ability)
    {
        if ($ability->image && Storage::exists($ability->image)) {
            Storage::delete($ability->image);
        }

        $ability->delete();

        return redirect()
            ->route('admin.abilities.index')
            ->with('success', 'Abilità eliminata con successo.');
    }
}
