@extends('layouts.base')

@section('content')

    <div class="container py-4">
        <h1>{{ __('Area Amministrativa') }}</h1>
        <h2>{{ __('Benvenuto') }}, {{ ucfirst($user->name) }}!</h2>
    </div>

@endsection