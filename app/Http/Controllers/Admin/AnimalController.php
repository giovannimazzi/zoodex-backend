<?php
//completed and tested

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
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{

    public $validator = [
            'name' => 'required|string|max:255',
            'scientific_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',

            'weight_kg' => 'nullable|numeric|min:0',
            'length_cm' => 'nullable|numeric|min:0',
            'height_cm' => 'nullable|numeric|min:0',
            'lifespan_years' => 'nullable|integer|min:0',

            'animal_class_id' => 'nullable|exists:animal_classes,id',
            'diet_id' => 'nullable|exists:diets,id',
            'conservation_status_id' => 'nullable|exists:conservation_statuses,id',

            'card_image' => 'nullable|image|max:2048',
            'real_image' => 'nullable|image|max:2048',

            'habitats' => 'nullable|array',
            'habitats.*' => 'exists:habitats,id',

            'continents' => 'nullable|array',
            'continents.*' => 'exists:continents,id',

            'abilities' => 'nullable|array',
            'abilities.*' => 'exists:abilities,id',
        ];


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

        $search = $request->search;
        if ($search) {
            $query->where(function ($query) use ($search) {

                $query->where('name', 'LIKE', "%$search%")
                    ->orWhere('scientific_name', 'LIKE', "%$search%");

            });
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
        $diets = Diet::all();
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
        $animalClasses = AnimalClass::orderBy('name')->get();
        $diets = Diet::orderBy('name')->get();
        $conservationStatuses = ConservationStatus::all();

        $habitats = Habitat::orderBy('name')->get();
        $continents = Continent::orderBy('name')->get();
        $abilities = Ability::orderBy('name')->get();

        return view('admin.animals.create', compact(
            'animalClasses',
            'diets',
            'conservationStatuses',
            'habitats',
            'continents',
            'abilities'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->validator);

        $animal = new Animal();

        $animal->name = ucwords(strtolower($data['name']));
        $animal->slug = generateUniqueSlug(Animal::class, $data['name']);
        $animal->scientific_name = ucwords(strtolower($data['scientific_name']));
        $animal->description = ucfirst($data['description']);

        $animal->weight_kg = $data['weight_kg'];
        $animal->length_cm = $data['length_cm'];
        $animal->height_cm = $data['height_cm'];
        $animal->lifespan_years = $data['lifespan_years'];

        $animal->animal_class_id = $data['animal_class_id'];
        $animal->diet_id = $data['diet_id'];
        $animal->conservation_status_id = $data['conservation_status_id'];

        if ($request->hasFile('card_image')) {
            $path = Storage::putFile('animals/card_image', $request->card_image);
            $animal->card_image = $path;
        }

        if ($request->hasFile('real_image')) {
            $path = Storage::putFile('animals/real_image', $request->real_image);
            $animal->real_image = $path;
        }

        $animal->save();

        if (isset($data['habitats'])) {
            $animal->habitats()->attach($data['habitats']);
        }

        if (isset($data['continents'])) {
            $animal->continents()->attach($data['continents']);
        }

        if (isset($data['abilities'])) {
            $animal->abilities()->attach($data['abilities']);
        }

        return redirect()
            ->route('admin.animals.show', $animal)
            ->with('success', 'Animale creato con successo.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Animal $animal)
    {
        $animal->load([
            'animalClass',
            'diet',
            'conservationStatus',
            'habitats',
            'continents',
            'abilities',
        ]);

        $animal->habitats = $animal->habitats->sortBy('id');
        $animal->continents = $animal->continents->sortBy('id');
        $animal->abilities = $animal->abilities->sortBy('id');

        return view('admin.animals.show', compact('animal')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Animal $animal)
    {
        $animalClasses = AnimalClass::orderBy('name')->get();
        $diets = Diet::orderBy('name')->get();
        $conservationStatuses = ConservationStatus::all();

        $habitats = Habitat::orderBy('name')->get();
        $continents = Continent::orderBy('name')->get();
        $abilities = Ability::orderBy('name')->get();

        return view('admin.animals.edit', compact(
            'animal',
            'animalClasses',
            'diets',
            'conservationStatuses',
            'habitats',
            'continents',
            'abilities'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Animal $animal)
    {
        $data = $request->validate($this->validator);

        $removeCardImage = $request->boolean('remove_card_image');
        $removeRealImage = $request->boolean('remove_real_image');

        $animal->name = ucwords(strtolower($data['name']));
        $animal->slug = generateUniqueSlug(Animal::class, $data['name'], $animal->id);
        $animal->scientific_name = ucwords(strtolower($data['scientific_name']));
        $animal->description = ucfirst($data['description']);

        $animal->weight_kg = $data['weight_kg'];
        $animal->length_cm = $data['length_cm'];
        $animal->height_cm = $data['height_cm'];
        $animal->lifespan_years = $data['lifespan_years'];

        $animal->animal_class_id = $data['animal_class_id'];
        $animal->diet_id = $data['diet_id'];
        $animal->conservation_status_id = $data['conservation_status_id'];

        if ($removeCardImage) {
            if ($animal->card_image && Storage::exists($animal->card_image)) {
                Storage::delete($animal->card_image);
            }

            $animal->card_image = null;
        }

        if ($request->hasFile('card_image')) {
            if ($animal->card_image && Storage::exists($animal->card_image)) {
                Storage::delete($animal->card_image);
            }

            $path = Storage::putFile('animals/card_image', $request->card_image);
            $animal->card_image = $path;
        }

        if ($removeRealImage) {
            if ($animal->real_image && Storage::exists($animal->real_image)) {
                Storage::delete($animal->real_image);
            }

            $animal->real_image = null;
        }

        if ($request->hasFile('real_image')) {
            if ($animal->real_image && Storage::exists($animal->real_image)) {
                Storage::delete($animal->real_image);
            }

            $path = Storage::putFile('animals/real_image', $request->real_image);
            $animal->real_image = $path;
        }

        $animal->save();

        $animal->habitats()->sync($data['habitats'] ?? []);
        $animal->continents()->sync($data['continents'] ?? []);
        $animal->abilities()->sync($data['abilities'] ?? []);

        return redirect()
            ->route('admin.animals.show', $animal)
            ->with('success', 'Animale aggiornato con successo.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Animal $animal)
    {
        if ($animal->card_image && Storage::exists($animal->card_image)) {
            Storage::delete($animal->card_image);
        }

        if ($animal->real_image && Storage::exists($animal->real_image)) {
            Storage::delete($animal->real_image);
        }

        $animal->habitats()->detach();
        $animal->continents()->detach();
        $animal->abilities()->detach();

        $animal->delete();

        return redirect()
            ->route('admin.animals.index')
            ->with('success', 'Animale eliminato con successo.');
    }
}
