<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Hospital') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            @if (!Auth::guest())
            <ul class="navbar-nav mr-auto">
{{--                @if(auth()->user()->can('create appointment'))--}}
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" href="{{ route('appointments.index') }}">{{ __('Appointments') }}</a>--}}
{{--                </li>--}}
{{--                @endif--}}
                @if(auth()->user()->can('create appointment'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('doctors.index') }}">{{ __('Doctors') }}</a>
                </li>
                @endif
                @if(auth()->user()->can('read patient'))
                <li class="nav-item">
                    <a class="nav-link" href="/users/{{Auth::id()}}/patients">{{ __('Patients') }}</a>
                </li>
                @endif
                @if(auth()->user()->can('read patient'))
                    <li class="nav-item">
                        <a class="nav-link" href="/drugs">{{ __('Drug Statistics') }}</a>
                    </li>

                @endif
{{--                <li class="nav-item">--}}
{{--                    <a class="nav-link" href="{{ route('patients.index') }}">{{ __('Patients') }}</a>--}}
{{--                </li>--}}
            </ul>
            @endif

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
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
