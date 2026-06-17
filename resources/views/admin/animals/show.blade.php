@extends('layouts.base')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-start mb-2">

        <div>
            <h1 class="mb-1">{{ $animal->name }}</h1>

            <p class="text-muted mb-2">
                {{ $animal->scientific_name }}
            </p>

            <p class="mb-0">
                <i>{{ $animal->description }}</i>
            </p>
        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('admin.animals.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-chevron-double-left"></i> Lista
            </a>

            <a href="{{ route('admin.animals.edit', $animal) }}" class="btn btn-outline-warning">
                <i class="bi bi-pencil-square"></i> Modifica
            </a>

            <button type="button"
                    class="btn btn-outline-danger"
                    data-bs-toggle="modal"
                    data-bs-target="#delete-animal-{{ $animal->id }}">
                <i class="bi bi-trash-fill"></i> Elimina
            </button>

        </div>

    </div>

    @include('admin.animals.partials.delete-modal', ['animal' => $animal])

    <div class="row mb-2">

        <div class="col-md-6 mb-3 mb-md-0">

            <div class="card h-100">

                <div class="card-header">
                    Immagine Fantasy
                </div>

                <div class="card-body d-flex justify-content-center align-items-center p-2">

                    <img src="{{ asset('storage/' . $animal->card_image) }}"
                         alt="{{ $animal->name }}"
                         class="img-fluid"
                         style="max-height: 230px; object-fit: contain;">

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="card h-100">

                <div class="card-header">
                    Immagine Reale
                </div>

                <div class="card-body d-flex justify-content-center align-items-center p-2">

                    <img src="{{ asset('storage/' . $animal->real_image) }}"
                         alt="{{ $animal->name }}"
                         class="img-fluid"
                         style="max-height: 230px; object-fit: contain;">

                </div>

            </div>

        </div>

    </div>

    <div class="card mb-2">

        <div class="card-header">
            Dati principali
        </div>

        <div class="card-body text-md-center">

            <div class="row g-3">

                <div class="col-md-1">
                    <strong>ID</strong><br>
                    {{ $animal->id }}
                </div>

                <div class="col-md-1">
                    <strong class="text-nowrap">N° DEX</strong><br>
                    {{ str_pad((string) $animal->id, 4, '0', STR_PAD_LEFT) }}
                </div>

                <div class="col-md-2">
                    <strong>Slug</strong><br>
                    {{ $animal->slug }}
                </div>

                <div class="col-md-2">
                    <strong>Peso</strong><br>
                    {{ $animal->weight_kg ? $animal->weight_kg . ' kg' : '-' }}
                </div>

                <div class="col-md-2">
                    <strong>Lunghezza</strong><br>
                    {{ $animal->length_cm ? $animal->length_cm . ' cm' : '-' }}
                </div>

                <div class="col-md-2">
                    <strong>Altezza</strong><br>
                    {{ $animal->height_cm ? $animal->height_cm . ' cm' : '-' }}
                </div>

                <div class="col-md-2">
                    <strong>Longevità</strong><br>
                    {{ $animal->lifespan_years ? $animal->lifespan_years . ' anni' : '-' }}
                </div>

            </div>

        </div>

    </div>

    <div class="row g-4 mb-2">

        <div class="col-md-6 col-lg-3">

            <div class="card h-100">

                <div class="card-header">
                    Classe
                </div>

                <div class="card-body text-center">

                    <x-icon :entity="$animal->animalClass" measure=70 shape=1>
                    </x-icon>
            
                    <div>
                        {{ $animal->animalClass?->name ?? '-' }}
                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-6 col-lg-3">

            <div class="card h-100">

                <div class="card-header">
                    Dieta
                </div>

                <div class="card-body text-center">

                    <x-icon :entity="$animal->diet" measure=70 shape=2>
                    </x-icon>

                    <div>
                        {{ $animal->diet?->name ?? '-' }}
                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-6 col-lg-3">

            <div class="card h-100">

                <div class="card-header">
                    Stato
                </div>

                <div class="card-body text-center">

                    @if ($animal->conservationStatus?->image)
                        <img src="{{ asset('storage/' . $animal->conservationStatus->image) }}"
                             alt="{{ $animal->conservationStatus->name }}"
                             style="width: 70px; height: 70px; object-fit: contain;">
                    @endif

                    <div>
                        {{ $animal->conservationStatus?->name ?? '-' }}
                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-6 col-lg-3">

            <div class="card h-100">

                <div class="card-header">
                    Continenti
                </div>

                <div class="card-body text-center">

                    <div class="d-flex justify-content-center align-items-center gap-2">

                        <img src="{{ asset('storage/continents/globo.png') }}" 
                            alt="Globo"
                            style="width: 100px; height: 100px; object-fit: cover;">

                        <div class="d-flex flex-column justify-content-start align-items-center gap-0">
                            @foreach ($animal->continents as $continent)

                                <big>
                                    <span class="badge" style="background-color: {{ $continent->color }};">
                                        {{ $continent->name }}
                                    </span>
                                </big>

                            @endforeach
                        </div>
                        

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="row g-4">

        <div class="col-lg-6">

            <div class="card h-100">

                <div class="card-header">
                    Habitat
                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-center flex-wrap gap-3">

                        @foreach ($animal->habitats as $habitat)

                            <div class="text-center">

                                <img src="{{ asset('storage/' . $habitat->image) }}"
                                     alt="{{ $habitat->name }}"
                                     style="width: 120px; height: 120px; object-fit: cover;"><br>

                                <big>
                                    <span class="badge"
                                         style="background-color: {{ $habitat->color }}">
                                        {{ $habitat->name }}
                                    </span>
                                </big>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="card h-100">

                <div class="card-header">
                    Abilità
                </div>

                <div class="card-body">

                    <div class="d-flex justify-content-center flex-wrap gap-3">

                        @foreach ($animal->abilities as $ability)

                            <div class="text-center">

                                <img src="{{ asset('storage/' . $ability->image) }}"
                                     alt="{{ $ability->name }}"
                                     style="width: 120px; height: 120px; object-fit: contain;"><br>

                                <big>
                                    <span class="badge"
                                         style="background-color: {{ $ability->color }}">
                                        {{ $ability->name }}
                                    </span>
                                </big>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection