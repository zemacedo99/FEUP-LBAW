@include('partials.modals.login')

<nav class="navbar navbar-expand-md navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('homepage') }}"> <img alt="Logo" src="{{ asset('images/logo.png') }}"
                width="100" height="25">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" id="navLinks1" href="{{ route('items') }}">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="navLinks2" href="{{ route('suppliers') }}">Stores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="navLinks3" href="{{ route('about_us') }}">About Us</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link navLinks" href="{{ route('map') }}">SiteMap</a>
                </li> --}}
            </ul>

            {{-- @if (Auth::check())
                <a class="button" href="{{ url('/logout') }}"> Logout </a>
                <span>| email: {{ Auth::user()->email }}</span>
                <span>| id: {{ \Illuminate\Support\Facades\Auth::id() }}</span>
                @if (\App\Models\Client::where('id', \Illuminate\Support\Facades\Auth::id())->exists())
                    <span>| Client:
                        {{ \App\Models\Client::where('id', \Illuminate\Support\Facades\Auth::id())->get()[0]->name }}</span>
                @endif
                @if (\App\Models\Supplier::where('id', \Illuminate\Support\Facades\Auth::id())->exists())
                    <span>| Supplier:
                        {{ \App\Models\Supplier::where('id', \Illuminate\Support\Facades\Auth::id())->get()[0]->name }}</span>
                @endif
            @endif --}}

            <form class="d-flex" method="GET" action="/search">
                {{-- @csrf --}}
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="search"
                    name="search">
                <button type="button" class="headericon">search</button>
            </form>
        </div>

        <!-- navbar profile and cart buttons -->
        <div class="navbar-nav ms-auto">
            <div class="col align-items-end">

                <button type="button" class="headericon" @guest data-bs-toggle="modal" data-bs-target="#loginModal"
                        @endguest @auth @if (app('App\Models\Client')::find(Auth::user()->id) != null) onclick="window.location.href=' {{ route('client_profile', ['client' => \Illuminate\Support\Facades\Auth::id()]) }}';"
                            
                        @elseif (Auth::check() && Auth::user()->is_admin) 
                                onclick="window.location.href='{{ route('dashboard') }}';"

                        @else
                                onclick="window.location.href=' {{ route('supplierProfile', ['id' => \Illuminate\Support\Facades\Auth::id()]) }}';" @endif
                    @endauth>account_circle

                </button>

                @auth
                    <button type="button" class="headericon"
                        onclick="window.location.href=' {{ route('logout') }}';">logout</button>
                @endauth
                <button type="button" class="headericon"
                    onclick="window.location.href='@auth {{ route('checkout', ['id' => \Illuminate\Support\Facades\Auth::id()]) }} @endauth @guest {{ route('register') }} @endguest'">
                    shopping_cart
                </button>
            </div>
        </div>
    </div>
</nav>
