@extends('layouts.base')

@section('content')

    <div class="container py-4">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-1">
            <h1>{{ __('Lista Animali') }}</h1>

            <a href="{{ route('admin.animals.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Aggiungi Nuovo
            </a>
        </div>

        <div class="bg-warning p-2 border border-3 rounded-3">
            <form action="{{ route('admin.animals.index') }}" method="GET">
                <div class="row g-2 align-items-end">

                    <div class="col-12 col-md-1">
                        <label for="id" class="form-label fw-semibold">ID</label>
                        <div class="input-group">
                            <input type="number"
                                name="id"
                                id="id"
                                class="form-control"
                                placeholder="ID animale"
                                value="{{ request('id') }}"
                                min="1">

                            <button type="button"
                                    class="btn btn-sm btn-outline-secondary"
                                    aria-label="Reset ID"
                                    title="Reset ID"
                                    onclick="document.getElementById('id').value=''; document.getElementById('id').focus();">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-12 col-md-2">
                        <label for="search" class="form-label fw-semibold">Nome</label>
                        <input type="text"
                            name="search"
                            id="search"
                            class="form-control"
                            placeholder="Nome animale"
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-12 col-md-2">
                        <label for="animal_class_id" class="form-label fw-semibold">Classe</label>
                        <select name="animal_class_id" id="animal_class_id" class="form-select">
                            <option value="">Tutte</option>

                            @foreach ($animalClasses as $animalClass)
                                <option value="{{ $animalClass->id }}"
                                    @selected(request('animal_class_id') == $animalClass->id)>
                                    {{ $animalClass->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-2">
                        <label for="diet_id" class="form-label fw-semibold">Dieta</label>
                        <select name="diet_id" id="diet_id" class="form-select">
                            <option value="">Tutte</option>

                            @foreach ($diets as $diet)
                                <option value="{{ $diet->id }}"
                                    @selected(request('diet_id') == $diet->id)>
                                    {{ $diet->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-3">
                        <label for="conservation_status_id" class="form-label fw-semibold">Stato</label>
                        <select name="conservation_status_id" id="conservation_status_id" class="form-select">
                            <option value="">Tutti</option>

                            @foreach ($conservationStatuses as $conservationStatus)
                                <option value="{{ $conservationStatus->id }}"
                                    @selected(request('conservation_status_id') == $conservationStatus->id)>
                                    {{ $conservationStatus->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            <i class="bi bi-funnel-fill"></i> Filtra
                        </button>

                        <a href="{{ route('admin.animals.index') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
        </div>
        

        @php

            function sortLink($label, $column, $sort, $direction)
            {
                $newDirection = 'asc';

                if ($sort === $column && $direction === 'asc') {
                    $newDirection = 'desc';
                }

                $icon = '';

                if ($sort === $column) {
                    $icon = $direction === 'asc'
                        ? ' ↑'
                        : ' ↓';
                }

                $resetSortHtml = '';

                if ($sort === $column && request()->has('sort')) {
                    $resetQuery = request()->except(['sort', 'direction', 'page']);
                    $resetQuery['page'] = 1;
                    $resetUrl = route('admin.animals.index', $resetQuery);

                    $resetSortHtml = '
                        <a href="' . $resetUrl . '"
                           class="text-decoration-none text-muted ms-1"
                           title="Reset ordinamento"
                           aria-label="Reset ordinamento">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    ';
                }

                $url = request()->fullUrlWithQuery([
                    'sort' => $column,
                    'direction' => $newDirection,
                    'page' => 1,
                ]);

                return '
                    <span class="d-flex align-items-center">
                        <a href="' . $url . '" class="text-decoration-none text-dark">
                            ' . $label . $icon . '
                        </a>
                        ' . $resetSortHtml . '
                    </span>
                ';
            }

        @endphp
        
        <table class="table table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th title="ordina per ID">{!! sortLink('ID', 'id', $sort, $direction) !!}</th>
                    <th>N° DEX</th>
                    <th class="text-center">Immagini</th>
                    <th title="ordina per Nome">{!! sortLink('Nome', 'name', $sort, $direction) !!}</th>
                    <th title="ordina per Classe">{!! sortLink('Classe', 'animal_class_id', $sort, $direction) !!}</th>
                    <th title="ordina per Dieta">{!! sortLink('Dieta', 'diet_id', $sort, $direction) !!}</th>
                    <th title="ordina per Stato">{!! sortLink('Stato', 'conservation_status_id', $sort, $direction) !!}</th>
                    <th class="text-center">Azioni</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($animals as $animal)
                    <tr>
                        <td>{{ $animal->id }}</td>

                        <td>{{ str_pad((string) $animal->id, 4, '0', STR_PAD_LEFT) }}</td>

                        <td class="text-center text-nowrap">
                            @if ($animal->card_image)
                                <img src="{{ asset('storage/' . $animal->card_image) }}"
                                     alt="{{ $animal->name }}"
                                     style="width: 90px; height: 90px; object-fit: contain;"
                                     class="me-2">
                            @else
                                -
                            @endif
                            
                            @if ($animal->real_image)
                                <img src="{{ asset('storage/' . $animal->real_image) }}"
                                     alt="{{ $animal->name }}"
                                     style="width: 90px; height: 90px; object-fit: contain;">
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            <strong>{{ $animal->name }}</strong><br>
                            @if ($animal->scientific_name)
                                <small class="text-muted">{{ $animal->scientific_name }}</small>
                            @else
                                <small class="text-muted">-</small>
                            @endif
                        </td>

                        <td>
                            <x-icon :entity="$animal->animalClass" measure=60 shape=1></x-icon>
                            @if ($animal->animalClass?->name)
                                <br/>
                                {{ $animal->animalClass->name }}
                            @else
                                <br/>
                                -
                            @endif
                        </td>

                        <td>
                            <x-icon :entity="$animal->diet" measure=60 shape=2></x-icon>
                            @if ($animal->diet?->name)
                                <br/>
                                {{ $animal->diet->name }}
                            @else
                                <br/>
                                -
                            @endif
                        </td>

                        <td>
                            @if ($animal->conservationStatus)
                                @if ($animal->conservationStatus->image)
                                    <img src="{{ asset('storage/' . $animal->conservationStatus->image) }}"
                                         alt="{{ $animal->conservationStatus->name ?? '' }}"
                                         style="width: 60px; height: 60px; object-fit: contain;">
                                @endif

                                @if ($animal->conservationStatus->name)
                                    <br/>
                                    {{ $animal->conservationStatus->name }}
                                @endif
                            @else
                                -
                            @endif
                        </td>

                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.animals.show', $animal) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-binoculars-fill"></i> Vedi
                            </a>

                            <a href="{{ route('admin.animals.edit', $animal) }}" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-pencil-square"></i> Modifica
                            </a>

                            <button type="button"
                                    class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#delete-animal-{{ $animal->id }}">
                                <i class="bi bi-trash-fill"></i> Elimina
                            </button>
                            @include('admin.animals.partials.delete-modal', ['animal' => $animal])
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center mt-1">
            <div class="text-muted small">
                Visualizzati
                {{ $animals->firstItem() ?? 0 }}
                -
                {{ $animals->lastItem() ?? 0 }}
                di
                {{ $animals->total() }}
                animali
            </div>

            <div>
                {{ $animals->links() }}
            </div>
        </div>

    </div>

@endsection