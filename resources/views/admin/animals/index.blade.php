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

        <div class="mb-2">
            <button class="btn btn-warning"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#animals-filters"
                    aria-expanded="true"
                    aria-controls="animals-filters">
                <i class="bi bi-funnel-fill"></i> Apri/Chiudi Filtri
            </button>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                window.rememberCollapse('animals-filters', 'animalsFiltersOpen');
            });
        </script>

        <div class="collapse" id="animals-filters">
            <div class="bg-warning p-2 border border-3 rounded-3">
            <form action="{{ route('admin.animals.index') }}" method="GET">
                <div class="row g-2 align-items-end">

                    <div class="col-12 col-lg-1">
                        <label for="id" class="form-label fw-semibold">ID</label>
                        <div class="input-group">
                            <input type="number"
                                name="id"
                                id="id"
                                class="form-control"
                                placeholder="ID"
                                value="{{ request('id') }}"
                                min="1">

                            <button type="button"
                                    class="btn btn-sm btn-secondary"
                                    aria-label="Reset ID"
                                    title="Reset ID"
                                    onclick="document.getElementById('id').value=''; document.getElementById('id').focus();">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-12 col-lg-2">
                        <label for="search" class="form-label fw-semibold">Nome</label>
                        <input type="text"
                            name="search"
                            id="search"
                            class="form-control"
                            placeholder="Nome animale"
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-12 col-lg-2">
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

                    <div class="col-12 col-lg-2">
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

                    <div class="col-12 col-lg-3">
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

                    <div class="col-12 col-lg-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel-fill"></i> Filtra
                        </button>
                        <a href="{{ route('admin.animals.index') }}" class="btn btn-secondary">
                            Reset
                        </a>
                    </div>

                </div>
            </form>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th title="ordina per ID">{!! sortLink('animals', 'ID', 'id', $sort, $direction) !!}</th>
                        <th class="text-center">N° DEX</th>
                        <th class="text-center">Immagini</th>
                        <th title="ordina per Nome">{!! sortLink('animals', 'Nome', 'name', $sort, $direction) !!}</th>
                        <th title="ordina per Classe">{!! sortLink('animals', 'Classe', 'animal_class_id', $sort, $direction) !!}</th>
                        <th title="ordina per Dieta">{!! sortLink('animals', 'Dieta', 'diet_id', $sort, $direction) !!}</th>
                        <th title="ordina per Stato">{!! sortLink('animals', 'Stato', 'conservation_status_id', $sort, $direction) !!}</th>
                        <th class="text-center">Azioni</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($animals as $animal)
                        <tr class="text-center">
                            <td>{{ $animal->id }}</td>

                            <td>{{ str_pad((string) $animal->id, 4, '0', STR_PAD_LEFT) }}</td>

                            <td class="text-nowrap">
                                <x-icon :entity="$animal" image='card_image' measure=90 bgPresent=0 addClassesString="me-2"></x-icon>

                                <x-icon :entity="$animal" image='real_image' measure=90 bgPresent=0></x-icon>
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
                                <x-icon :entity="$animal->diet" measure=60 shape=0></x-icon>
                                @if ($animal->diet?->name)
                                    <br/>
                                    {{ $animal->diet->name }}
                                @else
                                    <br/>
                                    -
                                @endif
                            </td>

                            <td>
                                <x-icon :entity="$animal->conservationStatus" measure=60 bgPresent=0></x-icon>
                                @if ($animal->conservationStatus?->name)
                                    <br/>
                                    {{ $animal->conservationStatus->name }}
                                @endif
                            </td>

                            <td class="text-end text-nowrap w-25">
                                <a href="{{ route('admin.animals.show', $animal) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-binoculars-fill"></i> Vedi
                                </a>

                                <a href="{{ route('admin.animals.edit', $animal) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil-square"></i> Modifica
                                </a>

                                <button type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#delete-entity-{{ $animal->id }}">
                                    <i class="bi bi-trash-fill"></i> Elimina
                                </button>
                                <x-delete-modal :entity="$animal" route="admin.animals.destroy"></x-delete-modal>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-1">
            <div class="text-muted small">
                Visualizzati
                {{ $animals->firstItem() ?? 0 }}
                -
                {{ $animals->lastItem() ?? 0 }}
                di
                {{ $animals->total() }}
                Animali
            </div>

            <div>
                {{ $animals->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>

    </div>

@endsection