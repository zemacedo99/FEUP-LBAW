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

            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button type="button" id="headericon">search</button>
            </form>
        </div>

        <!-- navbar profile and cart buttons -->
        <div class="navbar-nav ms-auto">
            <div class="col align-items-end">
                <button type="button" id="headericon" data-bs-toggle="modal"
                        data-bs-target="#loginModal">account_circle
                </button>
                <a href="../checkout/cart_info.php">
                    <button type="button" id="headericon">shopping_cart</button>
                </a>
            </div>
        </div>
    </div>
</nav>
