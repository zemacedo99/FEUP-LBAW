@include('partials.modals.login')

<nav class="navbar navbar-expand-md navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('homepage') }}"> <img alt="Logo" src="{{ asset('images/logo.png') }}" width="100" height="25">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" id="navLinks" href="{{ route('items') }}">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="navLinks" href="{{ route('suppliers') }}">Stores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="navLinks" href="{{ route('about_us') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="navLinks" href="{{ route('map') }}">SiteMap</a>
                </li>
            </ul>

            @if (Auth::check())
                <a class="button" href="{{ url('/logout') }}"> Logout </a>
                <span>| email: {{ Auth::user()->email }}</span>
                <span>| id: {{ \Illuminate\Support\Facades\Auth::id() }}</span>
                @if(\App\Models\Client::where('id', \Illuminate\Support\Facades\Auth::id())->exists())
                    <span>| Client: {{ \App\Models\Client::where('id', \Illuminate\Support\Facades\Auth::id())->get()[0]->name }}</span>
                @endif
                @if(\App\Models\Supplier::where('id', \Illuminate\Support\Facades\Auth::id())->exists())
                    <span>| Supplier: {{ \App\Models\Supplier::where('id', \Illuminate\Support\Facades\Auth::id())->get()[0]->name }}</span>
                @endif
            @endif

            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button type="button" id="headericon">search</button>
            </form>
        </div>

        <!-- navbar profile and cart buttons -->
        <div class="navbar-nav ms-auto">
            <div class="col align-items-end">

                <a  
                    @auth
                        @if (app('App\Models\Client')::find(Auth::user()->id) != null)

                        href="{{ route('client_profile'  , ['client' => \Illuminate\Support\Facades\Auth::id()])}}"
                        
                        @elseif (Auth::check() && Auth::user()->is_admin) 

                        href="{{ route('dashboard') }}"

                        @else
                            href="{{ route('supplierProfile'  , ['id' => \Illuminate\Support\Facades\Auth::id()])}}"
                        @endif
                        
                    
                    @endauth
                    >
                    <button type="button" id="headericon" 
                            @guest
                            data-bs-toggle="modal"
                            data-bs-target="#loginModal"
                            @endguest
                            >account_circle
                            
                    </button>
                </a>

                {{-- @guest
                    <button type="button" id="headericon" data-bs-toggle="modal"
                        data-bs-target="#loginModal">account_circle
                </button>
                @endguest
                 --}}
                @auth
                <a href="{{ route('logout')}}"> <button type="button" id="headericon" >logout</button> </a>
                @endauth

                <a href="
                @auth
                {{ route('checkout'  , ['id' => \Illuminate\Support\Facades\Auth::id()]) }}
                @endauth
                @guest
                {{ route('register') }}
                @endguest
                ">
                    <button type="button" id="headericon">shopping_cart</button>
                </a>
            </div>
        </div>
    </div>
</nav>
