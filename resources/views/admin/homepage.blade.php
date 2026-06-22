@extends('layouts.base')

@section('content')

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h1>{{ __('Area Amministrativa') }}</h1>
                <h2>{{ __('Benvenuto') }}, {{ ucfirst($user->name) }}!</h2>
            </div>
             
            <a href="{{ route('admin.animals.index') }}" class="btn btn-lg btn-primary mt-3">
                Consulta ZooDex
            </a>
        </div>
       

        
        <div class="row g-3 my-4">
            <h3>Riepilogo Entità</h3>

            <div class="col-12">
                <a href="{{ route('admin.animals.index') }}" class="text-decoration-none">
                    <div class="card text-center btn btn-outline-warning">
                        <div class="card-body">
                            <h3>{{ $animalsCount }}</h3>
                            <span class="fw-semibold">Animali</span><br>---<br>
                            @if ($lastUpdatedAnimal)
                                    Ultimo aggiornato:
                                    <br><strong>{{ $lastUpdatedAnimal->name }}</strong>
                            @endif
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-lg-2">
                <a href="{{ route('admin.animalClasses.index') }}" class="text-decoration-none">
                    <div class="card text-center btn btn-outline-primary">
                        <div class="card-body">
                            <h3>{{ $classesCount }}</h3>
                            <span class="fw-semibold">Classi</span><br>---<br>
                            @if ($lastUpdatedClass)                     
                                Ultimo aggiornato:
                                <strong>{{ $lastUpdatedClass->name }}</strong>                    
                            @endif
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-lg-2">
                <a href="{{ route('admin.diets.index') }}" class="text-decoration-none">
                    <div class="card text-center btn btn-outline-info">
                        <div class="card-body">
                            <h3>{{ $dietCount }}</h3>
                            <span class="fw-semibold">Diete</span><br>---<br>
                            @if ($lastUpdatedDiet)
                                Ultimo aggiornato:
                                <strong>{{ $lastUpdatedDiet->name }}</strong>
                            @endif
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-lg-2">
                <a href="{{ route('admin.conservationStatuses.index') }}" class="text-decoration-none">
                    <div class="card text-center btn btn-outline-danger">
                        <div class="card-body">
                            <h3>{{ $statusCount }}</h3>
                            <span class="fw-semibold">Stati conservazione</span><br>---<br>
                            @if ($lastUpdatedStatus)
                                Ultimo aggiornato:
                                <strong>{{ $lastUpdatedStatus->name }}</strong>
                            @endif
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-lg-2">
               {{--  <a href="{{ route('admin.habitats.index') }}" class="text-decoration-none"> --}}
                    <div class="card text-center btn btn-outline-success">
                        <div class="card-body">
                            <h3>{{ $habitatsCount }}</h3>
                            <span class="fw-semibold">Habitat</span><br>---<br>
                            @if ($lastUpdatedHabitat)
                                Ultimo aggiornato:
                                <strong>{{ $lastUpdatedHabitat->name }}</strong>
                            @endif
                        </div>
                    </div>
                {{-- </a> --}}
            </div>

            <div class="col-12 col-lg-2">
                {{-- <a href="{{ route('admin.continents.index') }}" class="text-decoration-none"> --}}
                    <div class="card text-center btn btn-outline-secondary">
                        <div class="card-body">
                            <h3>{{ $continentsCount }}</h3>
                            <span class="fw-semibold">Continenti</span><br>---<br>
                             @if ($lastUpdatedContinent)
                                Ultimo aggiornato:
                                <strong>{{ $lastUpdatedContinent->name }}</strong>
                            @endif
                        </div>
                    </div>
                {{-- </a> --}}
            </div>

            <div class="col-12 col-lg-2">
                {{-- <a href="{{ route('admin.abilities.index') }}" class="text-decoration-none"> --}}
                    <div class="card text-center btn btn-outline-dark">
                        <div class="card-body">
                            <h3>{{ $abilitiesCount }}</h3>
                            <span class="fw-semibold">Abilità</span><br>---<br>
                            @if ($lastUpdatedAbility)
                                Ultimo aggiornato:
                                <strong>{{ $lastUpdatedAbility->name }}</strong>
                            @endif
                        </div>
                    </div>
                {{-- </a> --}}
            </div>

        </div>
    </div>

@endsection