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

    <h1 class="mb-2">Modifica Classe</h1>

    <form action="{{ route('admin.animalClasses.update', $animalClass) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="card mb-2">
            <div class="card-header bg-secondary text-light">
                Dati
            </div>

            <div class="card-body">
                <div class="row g-2">

                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">Nome</label>
                        <input type="text"
                               name="name"
                               id="name"
                               class="form-control"
                               value="{{ old('name', $animalClass->name) }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label for="color" class="form-label fw-semibold">Colore</label>
                        <div class="d-flex align-items-center gap-2">
                            <input type="color"
                                name="color"
                                id="color"
                                class="form-control form-control-color"
                                value="{{ old('color', $animalClass->color ?? config('zoodex.fallback_color')) }}">
                                <big>
                                    <span id="color-value" class="badge"></span>
                                </big>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            window.initColorBadge();
                        });
                    </script>

                    <div class="col-12">
                        <label for="description" class="form-label fw-semibold">Descrizione</label>
                        <textarea name="description"
                                id="description"
                                rows="2"
                                class="form-control">{{ old('description', $animalClass->description) }}</textarea>
                    </div>

                </div>
            </div>
        </div>

        <div class="card mb-2">
            <div class="card-header bg-secondary text-light">
                Immagine
            </div>

            <div class="card-body">

                @if ($animalClass->image)
                    <div class="mb-2">
                        <x-icon :entity="$animalClass" measure=120 bgPresent=0 addClassesString="img-thumbnail"></x-icon>
                    </div>

                    <div class="form-check mb-2">
                        <input class="form-check-input"
                            type="checkbox"
                            name="remove_image"
                            id="remove_image"
                            value="1">

                        <label class="form-check-label" for="remove_image">
                            Rimuovi immagine attuale
                        </label>
                    </div>
                @endif

                <label for="image" class="form-label fw-semibold">Nuova Immagine</label>
                <input type="file"
                        name="image"
                        id="image"
                        class="form-control">
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">
                Aggiorna Classe
            </button>

            <a href="{{ route('admin.animalClasses.show', $animalClass) }}" class="btn btn-secondary">
                Annulla
            </a>
        </div>

    </form>

</div>

@endsection