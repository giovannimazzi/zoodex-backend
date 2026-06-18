@extends('layouts.base')
@section('content')

    <div class="container py-4">
        <h1>{{ __('Benvenuto nel pannello di amministrazione!') }}</h1>
        <a href="{{ route('admin.index') }}" class="btn btn-lg btn-primary">Vai alla Home</a>
    </div>  

@endsection