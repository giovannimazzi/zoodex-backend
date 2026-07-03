@extends('layouts.base')

@section('content')

    <div class="container py-4">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center flex-wrap mb-1">
            <h1>{{ __('Lista Continenti') }}</h1>

            <a href="{{ route('admin.continents.create') }}" class="btn btn-secondary">
                <i class="bi bi-plus-circle"></i> Aggiungi Nuovo
            </a>
        </div>

        <div class="mb-2">
            <button class="btn btn-secondary"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#continents-filters"
                    aria-expanded="true"
                    aria-controls="continents-filters">
                <i class="bi bi-funnel-fill"></i> Apri/Chiudi Filtri
            </button>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                window.rememberCollapse('continents-filters', 'continentsFiltersOpen');
            });
        </script>

        <div class="collapse" id="continents-filters">
            <div class="bg-secondary text-light p-2 border border-3 rounded-3">
            <form action="{{ route('admin.continents.index') }}" method="GET">
                <div class="row g-2 align-items-end">

                    <div class="col-12 col-lg-2">
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
                                    class="btn btn-sm btn-outline-light"
                                    aria-label="Reset ID"
                                    title="Reset ID"
                                    onclick="document.getElementById('id').value=''; document.getElementById('id').focus();">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-12 col-lg-8">
                        <label for="search" class="form-label fw-semibold">Nome</label>
                        <input type="text"
                            name="search"
                            id="search"
                            class="form-control"
                            placeholder="Nome o descrizione continente"
                            value="{{ request('search') }}">
                    </div>                    

                    <div class="col-12 col-lg-2 d-flex gap-2 flex-wrap flex-sm-nowrap">
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="bi bi-funnel-fill"></i> Filtra
                        </button>

                        <a href="{{ route('admin.continents.index') }}" class="btn btn-outline-light">
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
                        <th title="ordina per ID">{!! sortLink('continents', 'ID', 'id', $sort, $direction) !!}</th>
                        <th class="text-center">{{-- Immagine --}}Badge</th>
                        <th title="ordina per Nome">{!! sortLink('continents', 'Nome', 'name', $sort, $direction) !!}</th>
                        <th title="ordina per Colore">{!! sortLink('continents', 'Colore', 'color', $sort, $direction) !!}</th>
                        <th class="text-center">Descrizione</th>
                        <th class="text-center">Azioni</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($continents as $continent)
                        <tr class="text-center">
                            <td>{{ $continent->id }}</td>

                            <td>
                                {{-- <x-icon :entity="$continent" measure=50 shape=0></x-icon> --}}
                                <big>
                                    <span class="badge" style="background-color: {{ setColor($continent) }}">
                                        {{ $continent->name }}
                                    </span>
                                </big>
                            </td>

                            <td>
                                <strong>{{ $continent->name }}</strong>
                            </td>

                            <td>
                                <big>
                                    <span class="badge" style="background-color: {{ setColor($continent) }}">
                                        {{ setColor($continent) }}
                                    </span>
                                </big>
                            </td>

                            <td>
                                <textarea disabled rows="2" class="form-control bg-transparent border-0">{{ $continent->description }}</textarea>
                            </td>

                            <td class="text-end text-nowrap w-25">
                                <a href="{{ route('admin.continents.show', $continent) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-binoculars-fill"></i> Vedi
                                </a>

                                <a href="{{ route('admin.continents.edit', $continent) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil-square"></i> Modifica
                                </a>

                                <button type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#delete-entity-{{ $continent->id }}">
                                    <i class="bi bi-trash-fill"></i> Elimina
                                </button>
                                <x-delete-modal :entity="$continent" route="admin.continents.destroy"></x-delete-modal>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-1 flex-wrap">
            <div class="text-muted small">
                Visualizzati
                {{ $continents->firstItem() ?? 0 }}
                -
                {{ $continents->lastItem() ?? 0 }}
                di
                {{ $continents->total() }}
                Continenti
            </div>

            <div>
                {{ $continents->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>

    </div>

@endsection