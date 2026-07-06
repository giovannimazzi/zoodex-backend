<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Habitat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HabitatController extends Controller
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
        $query = Habitat::query();

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

        $habitats = $query
            ->orderBy($sort, $direction)
            ->paginate(3)
            ->appends($request->query());

        return view('admin.habitats.index', compact(
            'habitats',
            'sort',
            'direction'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.habitats.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->validator);

        $habitat = new Habitat();

        $habitat->name = ucfirst($data['name']);
        $habitat->slug = generateUniqueSlug(Habitat::class, $data['name']);
        $habitat->color = $data['color'];
        $habitat->description = ucfirst($data['description']);

        if ($request->hasFile('image')) {
            $path = Storage::putFile('habitats', $request->image);
            $habitat->image = $path;
        }

        $habitat->save();

        return redirect()
            ->route('admin.habitats.show', $habitat)
            ->with('success', 'Habitat creato con successo.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Habitat $habitat)
    {
        return view('admin.habitats.show', compact('habitat')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Habitat $habitat)
    {
        return view('admin.habitats.edit', compact('habitat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Habitat $habitat)
    {
        $data = $request->validate($this->validator);

        $removeImage = $request->boolean('remove_image');

        $habitat->name = ucfirst($data['name']);
        $habitat->slug = generateUniqueSlug(Habitat::class, $data['name'], $habitat->id);
        $habitat->color = $data['color'];
        $habitat->description = ucfirst($data['description']);

        if ($removeImage) {
            if ($habitat->image && Storage::exists($habitat->image)) {
                Storage::delete($habitat->image);
            }

            $habitat->image = null;
        }

        if ($request->hasFile('image')) {
            if ($habitat->image && Storage::exists($habitat->image)) {
                Storage::delete($habitat->image);
            }

            $path = Storage::putFile('habitats', $request->image);
            $habitat->image = $path;
        }

        $habitat->save();

        return redirect()
            ->route('admin.habitats.show', $habitat)
            ->with('success', 'Habitat aggiornato con successo.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Habitat $habitat)
    {
        if ($habitat->image && Storage::exists($habitat->image)) {
            Storage::delete($habitat->image);
        }

        $habitat->delete();

        return redirect()
            ->route('admin.habitats.index')
            ->with('success', 'Habitat eliminato con successo.');
    }
}
