@extends('layouts.base')

@section('content')

@php
    $oldHabitats = old('habitats', $animal->habitats->pluck('id')->toArray());
    $oldContinents = old('continents', $animal->continents->pluck('id')->toArray());
    $oldAbilities = old('abilities', $animal->abilities->pluck('id')->toArray());
@endphp

<div class="container py-4">

    @if ($errors->any())
        <div class="alert alert-danger">
            <h5 class="mb-2">Ci sono errori nel form:</h5>

            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h1 class="mb-2">Modifica Animale</h1>

    <form action="{{ route('admin.animals.update', $animal) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="card mb-2">
            <div class="card-header bg-secondary text-light">
                Dati base
            </div>

            <div class="card-body">
                <div class="row g-2">

                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">Nome</label>
                        <input type="text"
                               name="name"
                               id="name"
                               class="form-control"
                               value="{{ old('name', $animal->name) }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="scientific_name" class="form-label fw-semibold">Nome scientifico</label>
                        <input type="text"
                               name="scientific_name"
                               id="scientific_name"
                               class="form-control"
                               value="{{ old('scientific_name', $animal->scientific_name) }}">
                    </div>

                    <div class="col-md-3">
                        <label for="weight_kg" class="form-label fw-semibold">Peso kg</label>
                        <input type="number"
                               min="0"
                               step="0.01"
                               name="weight_kg"
                               id="weight_kg"
                               class="form-control"
                               value="{{ old('weight_kg', $animal->weight_kg) }}">
                    </div>

                    <div class="col-md-3">
                        <label for="length_cm" class="form-label fw-semibold">Lunghezza cm</label>
                        <input type="number"
                               min="0"
                               step="0.01"
                               name="length_cm"
                               id="length_cm"
                               class="form-control"
                               value="{{ old('length_cm', $animal->length_cm) }}">
                    </div>

                    <div class="col-md-3">
                        <label for="height_cm" class="form-label fw-semibold">Altezza cm</label>
                        <input type="number"
                               min="0"
                               step="0.01"
                               name="height_cm"
                               id="height_cm"
                               class="form-control"
                               value="{{ old('height_cm', $animal->height_cm) }}">
                    </div>

                    <div class="col-md-3">
                        <label for="lifespan_years" class="form-label fw-semibold">Longevità anni</label>
                        <input type="number"
                               min="0"
                               step="1"
                               name="lifespan_years"
                               id="lifespan_years"
                               class="form-control"
                               value="{{ old('lifespan_years', $animal->lifespan_years) }}">
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label fw-semibold">Descrizione</label>
                        <textarea name="description"
                                id="description"
                                rows="2"
                                class="form-control">{{ old('description', $animal->description) }}</textarea>
                    </div>

                </div>
            </div>
        </div>

        <div class="card mb-2">
            <div class="card-header bg-secondary text-light">
                Immagini
            </div>

            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="card_image" class="form-label fw-semibold">Immagine fantasy</label>

                        @if ($animal->card_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $animal->card_image) }}"
                                     alt="{{ $animal->name }}"
                                     class="img-thumbnail"
                                     style="width: 120px;">
                            </div>
                        @endif

                        <div class="form-check mb-2">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="remove_card_image"
                                   id="remove_card_image"
                                   value="1">
                            <label class="form-check-label" for="remove_card_image">
                                Rimuovi immagine attuale
                            </label>
                        </div>

                        <input type="file"
                               name="card_image"
                               id="card_image"
                               class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label for="real_image" class="form-label fw-semibold">Immagine reale</label>

                        @if ($animal->real_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $animal->real_image) }}"
                                     alt="{{ $animal->name }}"
                                     class="img-thumbnail"
                                     style="width: 120px;">
                            </div>
                        @endif

                        <div class="form-check mb-2">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="remove_real_image"
                                   id="remove_real_image"
                                   value="1">
                            <label class="form-check-label" for="remove_real_image">
                                Rimuovi immagine attuale
                            </label>
                        </div>

                        <input type="file"
                               name="real_image"
                               id="real_image"
                               class="form-control">
                    </div>

                </div>
            </div>
        </div>

        <div class="card mb-2">
            <div class="card-header bg-secondary text-light">
                Dettagli
            </div>

            <div class="card-body">
                <div class="row g-2 mb-2">

                    <div class="col-12">
                        <div class="card h-100">
                            <div class="card-header fw-semibold">Classe</div>

                            <div class="card-body">
                                <div class="row g-1">
                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-check d-flex align-items-center gap-2">
                                            <input class="form-check-input"
                                                   type="radio"
                                                   name="animal_class_id"
                                                   id="animal_class-none"
                                                   value=""
                                                   @checked(old('animal_class_id', $animal->animal_class_id) === null || old('animal_class_id', $animal->animal_class_id) === '')>

                                            <label class="form-check-label btn btn-secondary fw-semibold rounded-3"
                                                   for="animal_class-none">
                                                Nessuno
                                            </label>
                                        </div>
                                    </div>

                                    @foreach ($animalClasses as $animalClass)
                                        <div class="col-md-4 col-lg-3">
                                            <div class="form-check d-flex align-items-center gap-2">
                                                <input class="form-check-input"
                                                       type="radio"
                                                       name="animal_class_id"
                                                       id="animal_class-{{ $animalClass->id }}"
                                                       value="{{ $animalClass->id }}"
                                                       @checked(old('animal_class_id', $animal->animal_class_id) == $animalClass->id)>

                                                <label class="form-check-label btn btn-outline-light fw-semibold rounded-3"
                                                       for="animal_class-{{ $animalClass->id }}"
                                                       style="background-color: {{ !empty($animalClass->color) ? $animalClass->color : '#6c757d' }};">
                                                    {{ $animalClass->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card h-100">
                            <div class="card-header fw-semibold">Dieta</div>

                            <div class="card-body">
                                <div class="row g-1">
                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-check d-flex align-items-center gap-2">
                                            <input class="form-check-input"
                                                   type="radio"
                                                   name="diet_id"
                                                   id="diet-none"
                                                   value=""
                                                   @checked(old('diet_id', $animal->diet_id) === null || old('diet_id', $animal->diet_id) === '')>

                                            <label class="form-check-label btn btn-secondary fw-semibold rounded-3"
                                                   for="diet-none">
                                                Nessuno
                                            </label>
                                        </div>
                                    </div>

                                    @foreach ($diets as $diet)
                                        <div class="col-md-4 col-lg-3">
                                            <div class="form-check d-flex align-items-center gap-2">
                                                <input class="form-check-input"
                                                       type="radio"
                                                       name="diet_id"
                                                       id="diet-{{ $diet->id }}"
                                                       value="{{ $diet->id }}"
                                                       @checked(old('diet_id', $animal->diet_id) == $diet->id)>

                                                <label class="form-check-label btn btn-outline-light fw-semibold rounded-3"
                                                       for="diet-{{ $diet->id }}"
                                                       style="background-color: {{ !empty($diet->color) ? $diet->color : '#6c757d' }};">
                                                    {{ $diet->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card h-100">
                            <div class="card-header fw-semibold">Stato conservazione</div>

                            <div class="card-body">
                                <div class="row g-1">
                                    <div class="col-md-4 col-lg-3">
                                        <div class="form-check d-flex align-items-center gap-2">
                                            <input class="form-check-input"
                                                   type="radio"
                                                   name="conservation_status_id"
                                                   id="conservation_status-none"
                                                   value=""
                                                   @checked(old('conservation_status_id', $animal->conservation_status_id) === null || old('conservation_status_id', $animal->conservation_status_id) === '')>

                                            <label class="form-check-label btn btn-secondary fw-semibold rounded-3"
                                                   for="conservation_status-none">
                                                Nessuno
                                            </label>
                                        </div>
                                    </div>

                                    @foreach ($conservationStatuses as $conservationStatus)
                                        <div class="col-md-4 col-lg-3">
                                            <div class="form-check d-flex align-items-center gap-2">
                                                <input class="form-check-input"
                                                       type="radio"
                                                       name="conservation_status_id"
                                                       id="conservation_status-{{ $conservationStatus->id }}"
                                                       value="{{ $conservationStatus->id }}"
                                                       @checked(old('conservation_status_id', $animal->conservation_status_id) == $conservationStatus->id)>

                                                <label class="form-check-label btn btn-outline-light fw-semibold rounded-3"
                                                       for="conservation_status-{{ $conservationStatus->id }}"
                                                       style="background-color: {{ !empty($conservationStatus->color) ? $conservationStatus->color : '#6c757d' }};">
                                                    {{ $conservationStatus->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card mb-2">
                    <div class="card-header fw-semibold">
                        Habitat
                    </div>

                    <div class="card-body">
                        <div class="row g-1">

                            @foreach ($habitats as $habitat)
                                <div class="col-md-4 col-lg-3">
                                    <div class="form-check d-flex align-items-center gap-2">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="habitats[]"
                                               id="habitat-{{ $habitat->id }}"
                                               value="{{ $habitat->id }}"
                                               @checked(in_array($habitat->id, $oldHabitats))>

                                        <label class="form-check-label btn btn-outline-light fw-semibold rounded-3" for="habitat-{{ $habitat->id }}" style="background-color: {{ !empty($habitat->color) ? $habitat->color : '#6c757d' }};">
                                            {{ $habitat->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="card mb-2">
                    <div class="card-header fw-semibold">
                        Continenti
                    </div>

                    <div class="card-body">
                        <div class="row g-1">

                            @foreach ($continents as $continent)
                                <div class="col-md-4 col-lg-3">
                                    <div class="form-check d-flex align-items-center gap-2">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="continents[]"
                                               id="continent-{{ $continent->id }}"
                                               value="{{ $continent->id }}"
                                               @checked(in_array($continent->id, $oldContinents))>

                                        <label class="form-check-label btn btn-outline-light fw-semibold rounded-3" for="continent-{{ $continent->id }}" style="background-color: {{ !empty($continent->color) ? $continent->color : '#6c757d' }};">
                                            {{ $continent->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="card mb-0">
                    <div class="card-header fw-semibold">
                        Abilità
                    </div>

                    <div class="card-body">
                        <div class="row g-1">

                            @foreach ($abilities as $ability)
                                <div class="col-md-4 col-lg-3">
                                    <div class="form-check d-flex align-items-center gap-2">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               name="abilities[]"
                                               id="ability-{{ $ability->id }}"
                                               value="{{ $ability->id }}"
                                               @checked(in_array($ability->id, $oldAbilities))>

                                        <label class="form-check-label btn btn-outline-light fw-semibold rounded-3" for="ability-{{ $ability->id }}" style="background-color: {{ !empty($ability->color) ? $ability->color : '#6c757d' }};">
                                            {{ $ability->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">
                Aggiorna Animale
            </button>

            <a href="{{ route('admin.animals.show', $animal) }}" class="btn btn-secondary">
                Annulla
            </a>
        </div>

    </form>

</div>

@endsection