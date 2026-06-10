<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta
      name="description"
      content="Laravel Portfolio"
    />
    <meta name="author" content="Giovanni Mazzi" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Icona Progetto -->
    <!-- <link rel="icon" href="./assets/img/..." /> -->
    <link
      rel="icon"
      href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>@yield('favicon', '🃏')</text></svg>"
    />


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Usando Vite -->
    {{-- @vite(['resources/js/app.js']) --}}
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">

        @include('partials.header')

        <main class="">
            @yield('content')
        </main>
    </div>
</body>

</html>
