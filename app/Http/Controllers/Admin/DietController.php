<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DietController extends Controller
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
        $query = Diet::query();

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

        $diets = $query
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->appends($request->query());

        return view('admin.diets.index', compact(
            'diets',
            'sort',
            'direction'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.diets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->validator);

        $diet = new Diet();

        $diet->name = ucwords(strtolower($data['name']));
        $diet->slug = generateUniqueSlug(Diet::class, $data['name']);
        $diet->color = $data['color'];
        $diet->description = ucfirst($data['description']);

        if ($request->hasFile('image')) {
            $path = Storage::putFile('diets', $request->image);
            $diet->image = $path;
        }

        $diet->save();

        return redirect()
            ->route('admin.diets.show', $diet)
            ->with('success', 'Dieta creata con successo.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Diet $diet)
    {
        return view('admin.diets.show', compact('diet')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diet $diet)
    {
        return view('admin.diets.edit', compact('diet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Diet $diet)
    {
        $data = $request->validate($this->validator);

        $removeImage = $request->boolean('remove_image');

        $diet->name = ucwords(strtolower($data['name']));
        $diet->slug = generateUniqueSlug(Diet::class, $data['name'], $diet->id);
        $diet->color = $data['color'];
        $diet->description = ucfirst($data['description']);

        if ($removeImage) {
            if ($diet->image && Storage::exists($diet->image)) {
                Storage::delete($diet->image);
            }

            $diet->image = null;
        }

        if ($request->hasFile('image')) {
            if ($diet->image && Storage::exists($diet->image)) {
                Storage::delete($diet->image);
            }

            $path = Storage::putFile('diets', $request->image);
            $diet->image = $path;
        }

        $diet->save();

        return redirect()
            ->route('admin.diets.show', $diet)
            ->with('success', 'Dieta aggiornata con successo.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diet $diet)
    {
        if ($diet->image && Storage::exists($diet->image)) {
            Storage::delete($diet->image);
        }

        $diet->delete();

        return redirect()
            ->route('admin.diets.index')
            ->with('success', 'Dieta eliminata con successo.');
    }
}
