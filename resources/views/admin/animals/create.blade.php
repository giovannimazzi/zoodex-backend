@extends('layouts.base')

@section('content')

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

    <h1 class="mb-2">Nuovo Animale</h1>

    <form action="{{ route('admin.animals.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

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
                               value="{{ old('name') }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="scientific_name" class="form-label fw-semibold">Nome scientifico</label>
                        <input type="text"
                               name="scientific_name"
                               id="scientific_name"
                               class="form-control"
                               value="{{ old('scientific_name') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="weight_kg" class="form-label fw-semibold">Peso kg</label>
                        <input type="number"
                               min="0"
                               step="0.01"
                               name="weight_kg"
                               id="weight_kg"
                               class="form-control"
                               value="{{ old('weight_kg') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="length_cm" class="form-label fw-semibold">Lunghezza cm</label>
                        <input type="number"
                               min="0"
                               step="0.01"
                               name="length_cm"
                               id="length_cm"
                               class="form-control"
                               value="{{ old('length_cm') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="height_cm" class="form-label fw-semibold">Altezza cm</label>
                        <input type="number"
                               min="0"
                               step="0.01"
                               name="height_cm"
                               id="height_cm"
                               class="form-control"
                               value="{{ old('height_cm') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="lifespan_years" class="form-label fw-semibold">Longevità anni</label>
                        <input type="number"
                               min="0"
                               step="1"
                               name="lifespan_years"
                               id="lifespan_years"
                               class="form-control"
                               value="{{ old('lifespan_years') }}">
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
                        <input type="file"
                               name="card_image"
                               id="card_image"
                               class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label for="real_image" class="form-label fw-semibold">Immagine reale</label>
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
                <div class="row g-3 mb-3">

                    <div class="col-md-4">
                        <label for="animal_class_id" class="form-label fw-semibold">Classe</label>
                        <select name="animal_class_id"
                                id="animal_class_id"
                                class="form-select">
                            <option value="">Seleziona classe</option>

                            @foreach ($animalClasses as $animalClass)
                                <option value="{{ $animalClass->id }}"
                                    @selected(old('animal_class_id') == $animalClass->id)>
                                    {{ $animalClass->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="diet_id" class="form-label fw-semibold">Dieta</label>
                        <select name="diet_id"
                                id="diet_id"
                                class="form-select">
                            <option value="">Seleziona dieta</option>

                            @foreach ($diets as $diet)
                                <option value="{{ $diet->id }}"
                                    @selected(old('diet_id') == $diet->id)>
                                    {{ $diet->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="conservation_status_id" class="form-label fw-semibold">Stato conservazione</label>
                        <select name="conservation_status_id"
                                id="conservation_status_id"
                                class="form-select">
                            <option value="">Seleziona stato</option>

                            @foreach ($conservationStatuses as $conservationStatus)
                                <option value="{{ $conservationStatus->id }}"
                                    @selected(old('conservation_status_id') == $conservationStatus->id)>
                                    {{ $conservationStatus->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                
                <div class="card mb-2">
                    <div class="card-header fw-semibold">
                        Habitat
                    </div>

                    <div class="card-body">
                        <div class="row">

                            @foreach ($habitats as $habitat)
                                <div class="col-md-4 col-lg-3">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            type="checkbox"
                                            name="habitats[]"
                                            id="habitat-{{ $habitat->id }}"
                                            value="{{ $habitat->id }}"
                                            @checked(is_array(old('habitats')) && in_array($habitat->id, old('habitats')))> 

                                        <label class="form-check-label" for="habitat-{{ $habitat->id }}">
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
                        <div class="row">

                            @foreach ($continents as $continent)
                                <div class="col-md-4 col-lg-3">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            type="checkbox"
                                            name="continents[]"
                                            id="continent-{{ $continent->id }}"
                                            value="{{ $continent->id }}"
                                            @checked(is_array(old('continents')) && in_array($continent->id, old('continents')))> 

                                        <label class="form-check-label" for="continent-{{ $continent->id }}">
                                            {{ $continent->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

                <div class="card mb-2">
                    <div class="card-header fw-semibold">
                        Abilità
                    </div>

                    <div class="card-body">
                        <div class="row">

                            @foreach ($abilities as $ability)
                                <div class="col-md-4 col-lg-3">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                            type="checkbox"
                                            name="abilities[]"
                                            id="ability-{{ $ability->id }}"
                                            value="{{ $ability->id }}"
                                            @checked(is_array(old('abilities')) && in_array($ability->id, old('abilities')))> 

                                        <label class="form-check-label" for="ability-{{ $ability->id }}">
                                            {{ $ability->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>

            <div class="card mb-2">
                <div class="card-header fw-semibold">
                    Descrizione
                </div>

                <div class="card-body">
                    <textarea name="description"
                            id="description"
                            rows="5"
                            class="form-control">{{ old('description') }}</textarea>
                </div>
            </div>
            </div>

        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">
                Salva Animale
            </button>

            <a href="{{ route('admin.animals.index') }}" class="btn btn-secondary">
                Annulla
            </a>
        </div>

    </form>

</div>

@endsection