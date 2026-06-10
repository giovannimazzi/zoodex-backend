@extends('layouts.admin')

@section('content')

    <div class="container py-4">
        <h1>HOMEPAGE ADMIN</h1>
        <h2>Welcome, {{ucfirst($user->name)}}!</h2>
    </div>  

@endsection