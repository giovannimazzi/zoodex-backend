@extends('layouts.base')

@section('content')

    <div class="container py-4">
        <h1>{{ __('Area Amministrativa') }}</h1>
        <h2>{{ __('Benvenuto') }}, {{ ucfirst($user->name) }}!</h2>
        <a href="{{ route('admin.animals.index') }}" class="btn btn-lg btn-primary mt-3">
            Consulta ZooDex
        </a>
    </div>

@endsection