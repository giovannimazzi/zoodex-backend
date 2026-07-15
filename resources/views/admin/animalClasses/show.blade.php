@extends('layouts.base')

@section('content')

<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap">

        <h1 class="mb-1">{{ $animalClass->name }}</h1>

        <div class="d-flex gap-2 flex-wrap">

            <a href="{{ route('admin.animalClasses.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-chevron-double-left"></i> Lista
            </a>

            <a href="{{ route('admin.animalClasses.edit', $animalClass) }}" class="btn btn-outline-warning">
                <i class="bi bi-pencil-square"></i> Modifica
            </a>

            <button type="button"
                    class="btn btn-outline-danger"
                    data-bs-toggle="modal"
                    data-bs-target="#delete-{{ $animalClass->slug }}">
                <i class="bi bi-trash-fill"></i> Elimina
            </button>

        </div>

    </div>

    <x-delete-modal :entity="$animalClass" route="admin.animalClasses.destroy"></x-delete-modal>

    <div class="row mb-2">

        <div class="col-12 mb-3 mb-md-0">

            <div class="card h-100">

                <div class="card-header">
                    Immagine
                </div>

                <div class="card-body d-flex justify-content-center align-items-center p-2">

                    <x-icon :entity="$animalClass" measure=200 shape=1 addClassesString="img-fluid zoom"></x-icon>

                </div>

            </div>

        </div>

    </div>

    <div class="card mb-2">

        <div class="card-header">
            Dati
        </div>

        <div class="card-body text-md-center">

            <div class="row g-3">

                <div class="col-md-1">
                    <strong>ID</strong><br>
                    {{ $animalClass->id }}
                </div>

                <div class="col-md-2">
                    <strong>Slug</strong><br>
                    {{ $animalClass->slug }}
                </div>

                <div class="col-md-2">
                    <strong>Colore</strong><br>
                    <big>
                        <span class="badge" style="background-color: {{ setColor($animalClass) }}">
                            {{ setColor($animalClass) }}
                        </span>
                    </big>
                </div>

                <div class="col-7 text-start text-md-center">
                    <strong>Descrizione</strong><br>
                    {{ $animalClass->description ?: '-' }}
                </div>

            </div>

        </div>

    </div>

</div>

@endsection