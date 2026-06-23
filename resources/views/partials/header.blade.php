<header>
    <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center text-danger" href="{{ route("admin.animals.index") }}">
                <h1 class="display-5">🦜</h1>{{ config('app.name', 'ZooDex') }}
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Apri/chiudi navigazione') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route("admin.index") }}">{{ __('Home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.animals.*') ? 'active' : '' }}" href="{{ route("admin.animals.index") }}">{{ __('Animali') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.animalClasses.*') ? 'active' : '' }}" href="{{ route("admin.animalClasses.index") }}">{{ __('Classi') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.diets.*') ? 'active' : '' }}" href="{{ route("admin.diets.index") }}">{{ __('Diete') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.conservationStatuses.*') ? 'active' : '' }}" href="{{ route("admin.conservationStatuses.index") }}">{{ __('Stati') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.habitats.*') ? 'active' : '' }}" href="{{ route("admin.habitats.index") }}">{{ __('Habitat') }}</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.continents.*') ? 'active' : '' }}" href="{{ route("admin.continents.index") }}">{{ __('Continenti') }}</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.abilities.*') ? 'active' : '' }}" href="{{ route("admin.abilities.index") }}">{{ __('Abilità') }}</a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Accedi') }}</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Registrati') }}</a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ url('dashboard') }}">{{ __('Dashboard') }}</a>
                            <a class="dropdown-item" href="{{ url('profile') }}">{{ __('Profilo') }}</a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                {{ __('Esci') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>