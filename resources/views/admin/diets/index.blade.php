@extends('layouts.base')

@section('content')

    <div class="container py-4">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-1">
            <h1>{{ __('Lista Diete') }}</h1>

            <a href="{{ route('admin.diets.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Aggiungi Nuovo
            </a>
        </div>

        <div class="mb-2">
            <button class="btn btn-info"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#diets-filters"
                    aria-expanded="true"
                    aria-controls="diets-filters">
                <i class="bi bi-funnel-fill"></i> Apri/Chiudi Filtri
            </button>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                window.rememberCollapse('diets-filters', 'dietsFiltersOpen');
            });
        </script>

        <div class="collapse" id="diets-filters">
            <div class="bg-info p-2 border border-3 rounded-3">
            <form action="{{ route('admin.diets.index') }}" method="GET">
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
                                    class="btn btn-sm btn-secondary"
                                    aria-label="Reset ID"
                                    title="Reset ID"
                                    onclick="document.getElementById('id').value=''; document.getElementById('id').focus();">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-12 col-lg-8">
                        <label for="search" class="form-label fw-semibold">Nome o Descrizione</label>
                        <input type="text"
                            name="search"
                            id="search"
                            class="form-control"
                            placeholder="Nome o Descrizione dieta"
                            value="{{ request('search') }}">
                    </div>                    

                    <div class="col-12 col-lg-2 d-flex gap-2">
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="bi bi-funnel-fill"></i> Filtra
                        </button>

                        <a href="{{ route('admin.diets.index') }}" class="btn btn-secondary">
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
                        <th title="ordina per ID">{!! sortLink('diets', 'ID', 'id', $sort, $direction) !!}</th>
                        <th class="text-center">Immagine</th>
                        <th title="ordina per Nome">{!! sortLink('diets', 'Nome', 'name', $sort, $direction) !!}</th>
                        <th title="ordina per Colore">{!! sortLink('diets', 'Colore', 'color', $sort, $direction) !!}</th>
                        <th class="text-center">Descrizione</th>
                        <th class="text-center">Azioni</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($diets as $diet)
                        <tr class="text-center">
                            <td>{{ $diet->id }}</td>

                            <td>
                                <x-icon :entity="$diet" measure=50 shape=2></x-icon>
                            </td>

                            <td>
                                <strong>{{ $diet->name }}</strong>
                            </td>

                            <td>
                                <big>
                                    <span class="badge" style="background-color: {{ $diet->color !== null ? $diet->color : config('zoodex.fallback_color') }}">
                                        {{ $diet->color !== null ? $diet->color : config('zoodex.fallback_color') }}
                                    </span>
                                </big>
                            </td>

                            <td>
                                <textarea disabled rows="2" class="form-control bg-transparent border-0">{{ $diet->description }}</textarea>
                            </td>

                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.diets.show', $diet) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-binoculars-fill"></i> Vedi
                                </a>

                                <a href="{{ route('admin.diets.edit', $diet) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil-square"></i> Modifica
                                </a>

                                <button type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#delete-entity-{{ $diet->id }}">
                                    <i class="bi bi-trash-fill"></i> Elimina
                                </button>
                                <x-delete-modal :entity="$diet" route="admin.diets.destroy"></x-delete-modal>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-1">
            <div class="text-muted small">
                Visualizzati
                {{ $diets->firstItem() ?? 0 }}
                -
                {{ $diets->lastItem() ?? 0 }}
                di
                {{ $diets->total() }}
                Classi
            </div>

            <div>
                {{ $diets->links('vendor.pagination.bootstrap-5') }}
            </div>
        </div>

    </div>

@endsection