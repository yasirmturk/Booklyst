<nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @auth
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('stripe.billing') }}">Billing Portal</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('stripe.payment-methods') }}">Payment Methods</a></li>
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @can('sadmin')
                        <a class="dropdown-item" href="{{ route('reset') }}">Reset Cache</a>
                        <a class="dropdown-item" href="{{ route('ping') }}">Ping</a>
                        <a class="dropdown-item" href="{{ route('routes') }}">All Routes</a>
                        <div class="dropdown-divider"></div>
                        @endcan
                        @can('admin')
                        <a class="dropdown-item" href="{{ route('admin.index') }}">Admin Panel</a>
                        <a class="dropdown-item" href="{{ route('developer') }}">Developer Center</a>
                        <div class="dropdown-divider"></div>
                        @endcan
                        @can('provider')
                        <a class="dropdown-item" href="{{ route('settings') }}">Settings</a>
                        <div class="dropdown-divider"></div>
                        @endcan
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
