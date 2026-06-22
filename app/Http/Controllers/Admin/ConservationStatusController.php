<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ConservationStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ConservationStatusController extends Controller
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
        $query = ConservationStatus::query();

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
            $sort = 'id';
        }

        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'asc';
        }

        $conservationStatuses = $query
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->appends($request->query());

        return view('admin.conservationStatuses.index', compact(
            'conservationStatuses',
            'sort',
            'direction'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.conservationStatuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->validator);

        $conservationStatus = new ConservationStatus();

        $conservationStatus->name = ucfirst($data['name']);
        $conservationStatus->slug = Str::slug($data['name']);
        $conservationStatus->color = $data['color'];
        $conservationStatus->description = $data['description'];

        if ($request->hasFile('image')) {
            $path = Storage::putFile('conservation-status', $request->image);
            $conservationStatus->image = $path;
        }

        $conservationStatus->save();

        return redirect()
            ->route('admin.conservationStatuses.show', $conservationStatus)
            ->with('success', 'Stato creato con successo.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ConservationStatus $conservationStatus)
    {
        return view('admin.conservationStatuses.show', compact('conservationStatus')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConservationStatus $conservationStatus)
    {
        return view('admin.conservationStatuses.edit', compact('conservationStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ConservationStatus $conservationStatus)
    {
        $data = $request->validate($this->validator);

        $removeImage = $request->boolean('remove_image');

        $conservationStatus->name = ucfirst($data['name']);
        $conservationStatus->slug = Str::slug($data['name']);
        $conservationStatus->color = $data['color'];
        $conservationStatus->description = $data['description'];

        if ($removeImage) {
            if ($conservationStatus->image && Storage::exists($conservationStatus->image)) {
                Storage::delete($conservationStatus->image);
            }

            $conservationStatus->image = null;
        }

        if ($request->hasFile('image')) {
            if ($conservationStatus->image && Storage::exists($conservationStatus->image)) {
                Storage::delete($conservationStatus->image);
            }

            $path = Storage::putFile('conservation-status', $request->image);
            $conservationStatus->image = $path;
        }

        $conservationStatus->save();

        return redirect()
            ->route('admin.conservationStatuses.show', $conservationStatus)
            ->with('success', 'Stato aggiornato con successo.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConservationStatus $conservationStatus)
    {
        if ($conservationStatus->image && Storage::exists($conservationStatus->image)) {
            Storage::delete($conservationStatus->image);
        }

        $conservationStatus->delete();

        return redirect()
            ->route('admin.conservationStatuses.index')
            ->with('success', 'Stato eliminato con successo.');
    }
}
